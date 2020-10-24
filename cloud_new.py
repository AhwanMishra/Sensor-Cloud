#.....................................................................................................................................
import signal

def handler(signum, frame):
	#mqttc.publish("communication/fogg", "cloud_closed", qos=1)
	print ("Ctrl+Z pressed. Closing.....\n\n\n")
	#print_cost()
	exit()

signal.signal(signal.SIGTSTP, handler)
#.....................................................................................................................................

import paho.mqtt.client as paho
import ssl
import mysql.connector

def connect_to_database():
	mydb = mysql.connector.connect(host="localhost", user="newuser", passwd="password", database="sensor_cloud")
	return mydb
#....................................................................................................................................

def on_connect(client, userdata, flags, rc):                # func for making connection
    print("Connection returned result: " + str(rc) )
    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("communication/fogg" , 1 )                              # Subscribe to a topic


import json

def update_profit(message1):
	
	print("hellllllllllllllllllllllllllllllooooooooooo")
	global final_plan
	global best_sensor_nodes_sorted
	
	print(best_sensor_nodes_sorted)
	to_pick = len(best_sensor_nodes_sorted)
	
	if (final_plan == "Diamond"):
		to_pick = len(best_sensor_nodes_sorted)
	
	elif (final_plan == "Gold"):
		to_pick = len(best_sensor_nodes_sorted) - 1
		
	elif(final_plan == "Silver"):
		to_pick = len(best_sensor_nodes_sorted) - 2
	
	print(to_pick)
	
	for i in range(to_pick):
		node_id_temp =  best_sensor_nodes_sorted[i]
		print(node_id_temp)
		
		query1 = "INSERT INTO Profit (node_id, total_profit) values (" + str(node_id_temp) + ",0) ON DUPLICATE KEY UPDATE total_profit = total_profit + 1"
		#print(query1)
		
	
		mydb = connect_to_database()
		mycursor = mydb.cursor()
	
		mycursor.execute(query1)
		mydb.commit()
	
		mydb.close()
    
def on_message(client, userdata, msg):                      # Func for receiving msgs
	print("topic: "+msg.topic)
	message1 = str(msg.payload, 'utf-8')
	#message1 = msg.payload
	
	#print(message1)
	#print(type(message1))
	
	message1 = message1.replace("node2", "26")
	message1 = message1.replace("node3", "27")
	message1 = message1.replace("node4", "37")
	message1 = message1.replace("node5", "38")
	
	
	
	query1 = "UPDATE Logs SET  text = '"+message1+"' where type = 'gateway_message'"
	
	mydb = connect_to_database()
	mycursor = mydb.cursor()
	
	mycursor.execute(query1)
	mydb.commit()
	
	mydb.close()
	
	
	
	global sensor_status_all_from_gateway
	global sensor_data_all_from_gateway
	
	temp = json.loads(message1)
	
	
	
	if(temp["type"] == "status"):
		
		sensor_status_all_from_gateway = temp["packet"]
		print("\n\n\n")	
		print(temp, end="\n\n\n")
		print(sensor_status_all_from_gateway, end="\n\n\n")
		pick_best_sensor_nodes()
	
	
	if(temp["type"] == "data"):
		sensor_data_all_from_gateway = temp["packet"]
		print("\n\n\n")	
		print(temp, end="\n\n\n")
		print(sensor_data_all_from_gateway, end="\n\n\n")
		
		update_profit(message1)
		update_database(sensor_data_all_from_gateway)
	
	'''val1 = float(message1)
	val2 = int(val1)
	print(val2)
	
	query1 = "UPDATE sensor_data SET data = "+str(val2)+" WHERE id = 1"
	#query1= "select * from sensor_data"
	print(query1)
	
	mydb = connect_to_database()
	mycursor = mydb.cursor()
	mycursor.execute(query1)
	mydb.commit()		#Commit after write/update
	mydb.close()
 	'''
 
#def on_log(client, userdata, level, msg):
#    print(msg.topic+" "+str(msg.payload))

#................................................................................................................................
mqttc = paho.Client()                                       # mqttc object
mqttc.on_connect = on_connect                               # assign on_connect func
mqttc.on_message = on_message                               # assign on_message func
#mqttc.on_log = on_log

#### Change following parameters ####  
awshost = "a3c3q60w5n9zit-ats.iot.us-east-1.amazonaws.com"      # Endpoint
awsport = 8883                                              # Port no.   
clientId = "thing1"                                     # Thing_Name
thingName = "thing1"                                    # Thing_Name
caPath = "security_files/AmazonRootCA1.pem"                                      # Root_CA_Certificate_Name
certPath = "security_files/881dcb1346-certificate.pem.crt"                            # <Thing_Name>.cert.pem
keyPath = "security_files/881dcb1346-private.pem.key"                          # <Thing_Name>.private.key
 
mqttc.tls_set(caPath, certfile=certPath, keyfile=keyPath, cert_reqs=ssl.CERT_REQUIRED, tls_version=ssl.PROTOCOL_TLSv1_2, ciphers=None)      
# pass parameters
 
mqttc.connect(awshost, awsport, keepalive=60)               # connect to aws server
 
mqttc.loop_start()                                        
# Start receiving in loop  #loop_forever() does the same but blocks the call, loop_start checks the messages in a different thread, so below loop_start in a while loop, you may do other works you need to do

#...........................................................................................................................


last_requirement = ""	#Communicate with gateway only if new_requirement is not same as last and update last
physical_sensor_all_sensor_types1 = {"MQ2": ["CO","LPG","SMOKE","AIR_POLLUTION"]}	#sensor name to types
physical_sensor_all_sensor_types2 = {"CO": "MQ2", "LPG" : "MQ2", "SMOKE" : "MQ2", "AIR_POLLUTION" : "MQ2"} #types to name

all_required_virtual_sensor_types = {}
all_required_physical_sensor_types = {}

sensor_status_all_from_gateway = {}
sensor_data_all_from_gateway = {}

Sensor_details_owner = {}

gateway_loc_x =	678 
gateway_loc_y =	341

final_plan = "Diamond"	#It will be changed after finding final physical sensors required. By default diamond

final_score = {"closer_to_gateway_score":{}, "scattered_score" : {}, "CRT_score": {}, "energy_score":{}, "signal_strength_score":{}, "hops_score" : {}}

grand_final_score = {}

grand_final_score_list = []
best_sensor_nodes_sorted = []


import math	
import operator
from sklearn.neighbors import KDTree

def update_database(sensor_data_all_from_gateway):
	print("hi..............................")
	
	sum_ANALOG1 = 0
	sum_SMOKE = 0 
	sum_CO = 0 
	sum_LPG = 0
	
	ANALOG1_count = 0
	SMOKE_count = 0
	CO_count = 0
	LPG_count = 0
	
	
	for i in sensor_data_all_from_gateway:
		
		if "ANALOG1" in sensor_data_all_from_gateway[i]:
			sum_ANALOG1 = sum_ANALOG1 + sensor_data_all_from_gateway[i]["ANALOG1"]
			ANALOG1_count = ANALOG1_count + 1
			
		if "SMOKE" in sensor_data_all_from_gateway[i]:
			sum_SMOKE = sum_SMOKE + sensor_data_all_from_gateway[i]["SMOKE"] 
			SMOKE_count = SMOKE_count + 1
			
		if "CO" in sensor_data_all_from_gateway[i]:
			sum_CO = sum_CO + sensor_data_all_from_gateway[i]["CO"] 
			CO_count = CO_count + 1
			
		if "LPG" in sensor_data_all_from_gateway[i]:
			sum_LPG = sum_LPG + sensor_data_all_from_gateway[i]["LPG"]
			LPG_count = LPG_count + 1
	
	
	print("Sums: ", sum_ANALOG1, sum_SMOKE, sum_CO, sum_LPG)
	print("Counts: ", ANALOG1_count, SMOKE_count, CO_count, LPG_count)
	
	if ANALOG1_count != 0:
		avg_ANALOG1 = int(sum_ANALOG1 / ANALOG1_count)
		
	
	if SMOKE_count != 0:
		avg_SMOKE = int (sum_SMOKE / SMOKE_count)
		
	
	
	if CO_count != 0:
		avg_CO = int (sum_CO / CO_count)
		
	
	
	if LPG_count != 0:
		avg_LPG = int(sum_LPG / LPG_count)
		print("Avgdfdsfs: ", avg_LPG)
		
	print("fine up tp this...")
	print("Averages: ", avg_ANALOG1, avg_SMOKE, avg_CO, avg_LPG)


	#query1 = "UPDATE sensor_data SET data = "+str(val2)+" WHERE id = 1"
	
	
	query1 = "insert into CO(data) values("+str(avg_CO)+")"
	query2 = "insert into ANALOG1(data) values("+str(avg_ANALOG1)+")"
	query3 = "insert into SMOKE(data) values("+str(avg_SMOKE)+")"
	query4 = "insert into LPG(data) values("+str(avg_LPG)+")"
	
	query_all = "UPDATE latest_values SET  CO = "+ str(avg_CO) +", ANALOG1 = "+ str(avg_ANALOG1) +", SMOKE = "+ str(avg_SMOKE) +", LPG = "+ str(avg_LPG) + " WHERE sl_no = 1"
	
	print(query_all)
	
	mydb = connect_to_database()
	mycursor = mydb.cursor()
	
	mycursor.execute(query1)
	mydb.commit()		#Commit after write/update
	
	mycursor.execute(query2)
	mydb.commit()
	
	mycursor.execute(query3)
	mydb.commit()
	
	mycursor.execute(query4)
	mydb.commit()
	
	mycursor.execute(query_all)
	mydb.commit()
	
	
	
	#mycursor.execute(query1)
	#mydb.commit()
	
	mydb.close()

def pick_best_sensor_nodes():
	
	print("\n\n\nWe will pick best nodes now\n\n\n")
	
	global sensor_status_all_from_gateway	#paramters from sensor network  
	global	Sensor_details_owner			#paramters from registration database (Useful : loc_x, loc_y)
	
	global gateway_loc_x
	global gateway_loc_y
	
	global final_score
	global grand_final_score
	global grand_final_score_list
	
	global best_sensor_nodes_sorted
	
	#.............................................................................
	#(1)Closer to gateway 	(using loc_x and loc_y from Sensor_details_owner)
	#print( gateway_loc_x, Sensor_details_owner[26]["loc_x"])
	
	max_distance = 0
	distance = {}
	
	for i in Sensor_details_owner:
		#print(i)
		#print(Sensor_details_owner[i]["loc_x"], Sensor_details_owner[i]["loc_y"])
		
		loc_x = Sensor_details_owner[i]["loc_x"]
		loc_y = Sensor_details_owner[i]["loc_y"]
		
		print("loc : ", loc_x, loc_y)
		
		sq1 = (gateway_loc_x - loc_x)
		sq1 = sq1 * sq1
		
		sq2 = (gateway_loc_y - loc_y)
		sq2 = sq2 * sq2
		
		
		distance[i] = math.sqrt(sq1+sq2)
		max_distance = max(max_distance, distance[i])
		
	
	print("Hi")	
	for i in distance:
		final_score["closer_to_gateway_score"][i] =	(( max_distance - distance[i] )/max_distance) * 100		#Scaled to 0-100...the one which is farthest get the least score as 0. Other nodes get a better compartive score in the scale of 0-100.
		
		
	#...........................................................................
	#(2)Scattered
	map_x= 1600
	map_y = 822
	
	node_locations_reverse = {}
	new_randPoints = []
	
	for i in Sensor_details_owner:
		
		loc_x = Sensor_details_owner[i]["loc_x"]
		loc_y = Sensor_details_owner[i]["loc_y"]
		
		temp = str(loc_x) + "," + str(loc_y)
		node_locations_reverse[temp] = i
		temp1 = [loc_x, loc_y]
		new_randPoints.append(temp1)
	
	
	#uniform points
	rangeX = (0, map_x)
	rangeY = (0, map_y)
	qty = 4  # or howe many points you want

	
	
	
	
	qty_r = int(math.sqrt(qty))

	rx = int(map_x/qty_r)
	ry = int(map_y/qty_r)

	
	Points = [[ None for j in range(qty_r)] for i in range (qty_r)]

	
	for i in range(qty_r):
		if(i==0):
			Points[0][0] = (rx/2, ry/2)	
		else:
			Points[i][0] = (Points[i-1][0][0], Points[i-1][0][1]+ry) 
	
		for j in range(qty_r):
			if(j!=0):
				Points[i][j] = ( Points[i][j-1][0]+rx, Points[i][j-1][1] )

	

	print(map_x, map_y)
	#print (Points)

	
	#Put it in 2D array format
	new_Points = []
	for i in range(qty_r):
		for j in range(qty_r):
			tempx = []
			tempx.append(Points[i][j][0])
			tempx.append(Points[i][j][1])
			new_Points.append(tempx)
			#print(temp)

	print ("new points \n")
	print(new_Points)
	

	#make kd tree with random points
	

	X = new_randPoints
	
	tree = KDTree(X,leaf_size=2) #Form tree with X
	
	Y= new_Points
	nearest_dist, nearest_ind = tree.query(Y, k=1)  # k: number of nearest neighbors, Y: Input 2D array from which you want distance
	print(X,end="\n\n\n")



	print(nearest_dist, end = "\n\n\n")   #nearest distances 
	print(nearest_ind)		#nearest indices in original array X



	final_points = []
	for i in range(len(nearest_ind)):
		temp1 = new_randPoints[nearest_ind[i][0]] #1st neighbor
		final_points.append(temp1)
	

	print("final points:")
	print(final_points)

	final_points_node = []
	for i in final_points:
		temp = str(i[0]) + "," + str(i[1])
		final_points_node.append(node_locations_reverse[temp])

	print("scattered points", final_points_node)
	#...........................................................................
	#(3)External Cache Refresh time (CRT)
			#less is better.. so just like distance we will find max and find comparative score
			
	max_CRT = 0
	CRT = {}
		
	for i in sensor_status_all_from_gateway:
	
		if("CRT" in sensor_status_all_from_gateway[i]):
			print("...........",sensor_status_all_from_gateway[i]["CRT"])		
		
			CRT[i] = sensor_status_all_from_gateway[i]["CRT"]
			max_CRT = max(max_CRT, CRT[i])
		
		
		else:
			final_score["CRT_score"][i] = 0
	
		
	for i in CRT:
		final_score["CRT_score"][i] =	(( max_CRT - CRT[i] )/max_CRT) * 100
	
	
	#...........................................................................
	#(4)Residual Energy
	
	#...........................................................................
	#(5)Signal Strength
					#RSSI -100 means no signal, 0 means best
	
	
	for i in sensor_status_all_from_gateway:				
		
		
		if("WIFI" in sensor_status_all_from_gateway[i]):	#This parameter should exist in json packet, sometimes it might be missing, so give score 0 in such case.
		
			RSSI = sensor_status_all_from_gateway[i]["WIFI"]
			print("RSSI : ",i,RSSI,type(RSSI))
		
			if(RSSI > 0):
				RSSI = RSSI*(-1)	#for some reasons it is coming in positive sometimes, so.
		
			
			#For score, we will just add 100 with it, to give score...so 0 RSSI will get 100 as score, -30 will get 70 as score....
		
			final_score["signal_strength_score"][i] = RSSI + 100
			
		
		else:
			final_score["signal_strength_score"][i] = 0	#Not exist in parameter
	
	#..........................................................................
	#(6)hops
	
		#Here number of hops should be counted and the score should be given as per that
		#but we will just see if the hop paramter exists or not, if exists we will get score 0 otherwise 100
		
		for i in sensor_status_all_from_gateway:
		
			if("through" in sensor_status_all_from_gateway[i]):
				final_score["hops_score"][i] = 0
			
			elif("through" not in sensor_status_all_from_gateway[i] and "WIFI" in sensor_status_all_from_gateway[i]):	#To make sure it is not empty packet except "CRT, we do not want to give 100 score to that"
				final_score["hops_score"][i] = 100
				
			else:
				final_score["hops_score"][i] = 0
	
	#....................................................................................
	print("hi",final_score)
	
	for i in sensor_status_all_from_gateway:
		grand_final_score[int(i)] = 0
	
	
	#few are in integers and few are in string so give accordingly.
	for j in sensor_status_all_from_gateway:
		#print("CRT_score", final_score["CRT_score"][j])
		i = int(j)
		grand_final_score[i] = grand_final_score[i] + final_score["closer_to_gateway_score"][i] * 1 + final_score["CRT_score"][j] * 1 +  final_score["signal_strength_score"][j] * 1 + final_score["hops_score"][j] * 1   #add "scattered_score" after completing
		
	print("OK")
	
	grand_final_score_list = sorted(grand_final_score.items(), key=lambda x: x[1], reverse = True)

	print(grand_final_score_list)
	
	best_sensor_nodes_sorted.clear()
	
	for i in grand_final_score_list:
		best_sensor_nodes_sorted.append(i[0])
	
	print(best_sensor_nodes_sorted)
	#grand_final_score = sorted(grand_final_score.items(), key=operator.itemgetter(1))
	
	#print(grand_final_score)
	request_sensor_data()

	
	
def request_sensor_data():

	global final_plan
	global best_sensor_nodes_sorted
	
	to_pick = len(best_sensor_nodes_sorted)
	
	if (final_plan == "Diamond"):
		to_pick = len(best_sensor_nodes_sorted)
	
	elif (final_plan == "Gold"):
		to_pick = len(best_sensor_nodes_sorted) - 1
		
	elif(final_plan == "Silver"):
		to_pick = len(best_sensor_nodes_sorted) - 2
	
	command = "get_sensors_data@"
	
	for i in range(to_pick):
		if( i!= to_pick - 1):
			command = command + str(best_sensor_nodes_sorted[i]) +":"
		else:
			command = command + str(best_sensor_nodes_sorted[i])
		
	
	
	
	
	query1 = "UPDATE Logs SET  text = '"+command+"' where type = 'picked_nodes'"
	query1 = query1.replace("get_sensors_data@","")
	query1 = query1.replace(":",", ")
	
	mydb = connect_to_database()
	mycursor = mydb.cursor()
	
	mycursor.execute(query1)
	mydb.commit()
	
	mydb.close()
	
	
	
	command = command.replace("26", "node2")
	command = command.replace("27", "node3")
	command = command.replace("37", "node4")
	command = command.replace("38", "node5")
			
	print(command)
	
	
	
	
	mqttc.publish("communication/cloud", command, qos=1)
	
	

def request_node_properties():
	mqttc.publish("communication/cloud","get_sensors_properties", qos=1)
	print("Sensor node properties request sent !\n")


def update_Sensor_details_owner():	#Update the latest registered sensor owner details.
	query1 = "select * from Sensor_details_owner"
	global Sensor_details_owner
	mydb = connect_to_database()
	mycursor = mydb.cursor()
	mycursor.execute(query1)
	myresult = mycursor.fetchall()
	for i in myresult:
		temp = list(i)
		temp_dict = {}
		
		
		temp_dict["node_type"] = temp[1]
		temp_dict["owner_name"] = temp[2]
		temp_dict["sensor_type"] = temp[3]
		temp_dict["loc_x"] = temp[4]
		temp_dict["loc_y"] = temp[5]
		
		Sensor_details_owner[temp[0]] = temp_dict
		
	print (Sensor_details_owner)

def check_requirements():
	
	query1 = "select * from User_requirements where state = 'active'"
	mydb = connect_to_database()	#connect and disconnect after every operation to see the fresh database 
	mycursor = mydb.cursor()
	mycursor.execute(query1)
	myresult = mycursor.fetchall()		#In select commands it is necessary to do fetchall after executing, otherwise error will be shown
	mydb.close()
	#print(myresult,end="\n\n\n")
	
	global last_requirement
	if(myresult != last_requirement):
		last_requirement = myresult
		handle_change_in_requirements(myresult)


def handle_change_in_requirements(myresult):
	
	global all_required_virtual_sensor_types
	all_required_virtual_sensor_types.clear()
	
	global all_required_physical_sensor_types
	all_required_physical_sensor_types.clear()
	
	global physical_sensor_all_sensor_types2
	
	value_of_plans = {"Silver": 1, "Gold" : 2, "Diamond" : 3}
	for i in myresult:
		#print(i)
		temp1 = i[0]
		temp2 = i[1]
		
		if temp1 not in all_required_virtual_sensor_types:
			all_required_virtual_sensor_types[temp1] = temp2
		else:
			if(value_of_plans[all_required_virtual_sensor_types[temp1]] < value_of_plans[temp2]):
				all_required_virtual_sensor_types[temp1] = temp2
				
				
	for key in all_required_virtual_sensor_types:
		temp1 = physical_sensor_all_sensor_types2[key]
		temp2 = all_required_virtual_sensor_types[key]
		
		if temp1 not in all_required_physical_sensor_types:
			all_required_physical_sensor_types[temp1] = temp2
			
		else:
			if(value_of_plans[all_required_physical_sensor_types[temp1]] < value_of_plans[temp2]):
				all_required_physical_sensor_types[temp1] = temp2
		
		
	print(all_required_virtual_sensor_types)
	print(all_required_physical_sensor_types)
	
	global final_plan
	final_plan = all_required_physical_sensor_types['MQ2']
	#print("final plan is ", final_plan)
	
	print("Requirements changed.. So now we will ask for sensor properties")
	request_node_properties()
	
	update_Sensor_details_owner()	#Update the latest registered sensor owner details.

from time import sleep
while(1):
	check_requirements()
	sleep(1)
