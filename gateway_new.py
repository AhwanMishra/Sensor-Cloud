
#..................................................................................................................................
import paho.mqtt.client as paho
import ssl


def on_connect(client, userdata, flags, rc):                # func for making connection
	print ("Connected to Cloud.")
	print("Connection returned result: " + str(rc) )
	# Subscribing in on_connect() means that if we lose the connection and
	# reconnect then subscriptions will be renewed.
	client.subscribe("communication/cloud" , 1 )                              # Subscribe to a topic
    
def on_message(client, userdata, msg):                      # Func for receiving msgs
	print("topic: "+msg.topic)
	message1=str(msg.payload, 'utf-8')
	#print("payload: "+str(msg.payload))
	#print("Senor value : ",message1)
	#global sensor_value
	#sensor_value = float(message1)
	
	print(message1) 
	
	global sensor_status_all
	global all_required_sensor_nodes
	
	if(message1 == "get_sensors_properties"):
		print("I will send sensor node properties now")
		
		temp = sensor_status_all
		to_send = {"type": "status", "packet":sensor_status_all}
		final_to_send = json.dumps(to_send)
		mqttc.publish("communication/fogg",final_to_send, qos=1)
	
	m = message1.split("@")
	if(m[0] == "get_sensors_data"):
		temp = m[1]
		all_required_sensor_nodes.clear()
		all_required_sensor_nodes = temp.split(":")
		print(all_required_sensor_nodes)
 
#def on_log(client, userdata, level, msg):
#    print(msg.topic+" "+str(msg.payload))
 
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
 
mqttc.tls_set(caPath, certfile=certPath, keyfile=keyPath, cert_reqs=ssl.CERT_REQUIRED, tls_version=ssl.PROTOCOL_TLSv1_2, ciphers=None)      # pass parameters
 
mqttc.connect(awshost, awsport, keepalive=60)               # connect to aws server
 
mqttc.loop_start()                                        # Start receiving in loop  #loop_forever() does the same but blocks the call, loop_start checks the messages in a different thread, so below loop_start in a while loop, you may do other works you need to do


#................................................................................................................................

external_cache = {"node2":"", "node3":"", "node4":"", "node5":""}
cache_last_refresh_time = {"node2": "00:00:00", "node3": "00:00:00", "node4": "00:00:00", "node5": "00:00:00"}  #last time when the cache was refreshed
cache_refresh_time = {"node2": 0, "node3": 0, "node4": 0, "node5": 0}  #subtract the current time from last

sensor_status_except_cache_refresh_time = {"node2":{}, "node3":{}, "node4":{}, "node5":{}}  
sensor_status_all = {}




all_required_sensor_nodes = []
#................................................................................................................................

import threading
import time 

from datetime import datetime
import json
import serial, string

#................................................................................................................................

#Thread 1

def task1():

	global all_required_sensor_nodes
	global external_cache
	global cache_last_refresh_time
	global cache_refresh_time
	global sensor_status_except_cache_refresh_time
	global sensor_status_all

	serial_data = " "
	ser = serial.Serial('/dev/ttyUSB0', 9600, 8, 'N', 1, timeout=1)
	while True:
		print ("----")
		while serial_data != "":
			serial_data = ser.readline()
			serial_data_str = str(serial_data,'utf-8')
		
		
			if(serial_data_str.find("{")==0):
			
				now = datetime.now()
				current_time = now.strftime("%H:%M:%S")
				current_minute = int(current_time.split(":")[1])
				current_second = int(current_time.split(":")[2])
		
				#print (serial_data_str)
				temp_json = json.loads(serial_data_str)
			
				if(temp_json["from"] == "node2"):
		
					last_time = cache_last_refresh_time["node2"]
					last_minute = int(last_time.split(":")[1])
					last_second = int(last_time.split(":")[2])
				
					cache_refresh_time["node2"] = (current_minute*60 + current_second ) - (last_minute*60 + last_second )
					cache_last_refresh_time["node2"] = current_time
				
				
					if(temp_json["type"] == "data"):
						external_cache["node2"] = temp_json
					
					elif(temp_json["type"] == "status"):
						sensor_status_except_cache_refresh_time["node2"] = temp_json		
				
				
				elif(temp_json["from"] == "node3"):
				
					last_time = cache_last_refresh_time["node3"]
					last_minute = int(last_time.split(":")[1])
					last_second = int(last_time.split(":")[2])
				
					cache_refresh_time["node3"] = (current_minute*60 + current_second ) - (last_minute*60 + last_second )
					cache_last_refresh_time["node3"] = current_time
				
				
					if(temp_json["type"] == "data"):
						external_cache["node3"] = temp_json
					
					elif(temp_json["type"] == "status"):
						sensor_status_except_cache_refresh_time["node3"] = temp_json
				
				elif(temp_json["from"] == "node4"):
				
				
					last_time = cache_last_refresh_time["node4"]
					last_minute = int(last_time.split(":")[1])
					last_second = int(last_time.split(":")[2])
				
					cache_refresh_time["node4"] = (current_minute*60 + current_second ) - (last_minute*60 + last_second )
					
					cache_last_refresh_time["node4"] = current_time
				
				
					if(temp_json["type"] == "data"):
						external_cache["node4"] = temp_json
					
					elif(temp_json["type"] == "status"):
						sensor_status_except_cache_refresh_time["node4"] = temp_json
				
				
				elif(temp_json["from"] == "node5"):
				
				
				
					last_time = cache_last_refresh_time["node5"]
					last_minute = int(last_time.split(":")[1])
					last_second = int(last_time.split(":")[2])
				
					cache_refresh_time["node5"] = (current_minute*60 + current_second ) - (last_minute*60 + last_second )
				
					cache_last_refresh_time["node5"] = current_time
			
					if(temp_json["type"] == "data"):
						external_cache["node5"] = temp_json
				
					elif(temp_json["type"] == "status"):
						sensor_status_except_cache_refresh_time["node5"] = temp_json
			
			

				'''
				#before publishing to cloud, in json change the node id to corresponding node id generated from the dict map
				sum1 = 0
				for i in external_cache:
					if(external_cache[i]!=""):
						temp_json = json.loads(external_cache[i])
						sum1 = sum1 + int(temp_json["CO"])
					
				print("summmmm:"+str(sum1)) 
				mqttc.publish("communication/fogg",str(sum1), qos=1)'''
			
			
				#print("Serial_data_str:	" + serial_data_str, end = "\n\n\n")
				#print("External Cache:	" + str(external_cache), end = "\n\n\n")
				#print("cache refresh time: " + str(cache_refresh_time), end = "\n\n\n")
				#print("sensor_status_except_cache_refresh_time: "+ str(sensor_status_except_cache_refresh_time), end = "\n\n\n")
			
			
			

			
				sensor_status_all = sensor_status_except_cache_refresh_time		#Links to the same not the duplicate
				for i in sensor_status_except_cache_refresh_time:
					#print(i, "___",sensor_status_except_cache_refresh_time[i])
					sensor_status_all[i]["CRT"] = cache_refresh_time[i]
			

				print("External Cache:	" + str(external_cache), end = "\n\n\n")
				print("Sensor status : "+ str(sensor_status_all), end = "\n\n\n" )
			
			else:
				print (serial_data_str)
			
		serial_data = " "
	
#...........................................................................................................................
#2nd Thread
def task2():
	global all_required_sensor_nodes
	global external_cache
	
	
	
	
	while(1):
		if(len(all_required_sensor_nodes)>0):
			final_string = ""
			final_dict = {}
			for i in range(len(all_required_sensor_nodes)):
				final_dict[all_required_sensor_nodes[i]] = external_cache[all_required_sensor_nodes[i]]
				
			to_send = {"type": "data", "packet": final_dict}
			
			final_string = json.dumps(to_send)
			print("It will be sent : ",final_string)
			mqttc.publish("communication/fogg",final_string, qos=1)
			time.sleep(3)


t1 = threading.Thread(target = task1, args=[])
t2 = threading.Thread(target = task2, args=[])
t1.start()
t2.start()

