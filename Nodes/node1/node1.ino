
#include "namedMesh.h"

#define   MESH_SSID       "MeshNetwork"
#define   MESH_PASSWORD   "somethingSneaky"
#define   MESH_PORT       5555

Scheduler     userScheduler; // to control your personal task
namedMesh  mesh;

String nodeName = "node1"; // Name needs to be unique

bool send_flag = 0;
int  interval;
Task taskSendMessage( TASK_SECOND*(interval), TASK_FOREVER, To []() {
    if(send_flag == 1)
    {
    
    	String msg = "start_"+interval;
    	String to = To;
    	mesh.sendSingle(To, msg);
    } 
    else
    {
    	String msg = String("stop");
    	String to = To;
    	mesh.sendSingle(To, msg);
    }
}); 

/*
String cache[] = {"blank","blank","blank"};



Task taskSendtoGatewaySerially( TASK_SECOND*(1), TASK_FOREVER, [](){
//Do Serial Communication here
	String output ="sensor_data_all@" + cache[0] +"@"+ cache[1] +"@"+ cache[2] +"$"; 
	Serial.println(output);

});
*/


void setup() {
	//pinMode(LED_BUILTIN, OUTPUT);
	//digitalWrite(LED_BUILTIN, LOW);
	//delay(10000);
	//digitalWrite(LED_BUILTIN, HIGH);
  Serial.begin(9600);

  mesh.setDebugMsgTypes(ERROR | DEBUG | CONNECTION);  // set before init() so that you can see startup messages

  mesh.init(MESH_SSID, MESH_PASSWORD, &userScheduler, MESH_PORT);

  mesh.setName(nodeName); // This needs to be an unique name! 

  //mesh.onReceive([](uint32_t from, String &msg) {
   // Serial.printf("Received message by id from: %u, %s\n", from, msg.c_str());
  //});

  mesh.onReceive([](String &from, String &msg) {
  	//digitalWrite(LED_BUILTIN, LOW);
    Serial.println(msg.c_str());
	/*
		if(String(msg.c_str()).substring(0, 11) = "sensor_data")
		{
    	String original_sender = String(msg.c_str()).substring(17, 22);
   		 if(original_sender == "node4") cache[2] = msg.c_str();
    	else if (original_sender == "node3") cache[1] = msg.c_str();
    	else if(original_sender == "node2") cache[0] = msg.c_str();
		}
		*/
  });

  mesh.onChangedConnections([]() {
    //Serial.printf("Changed connection\n");
  });

  //userScheduler.addTask(taskSendMessage);
  //taskSendMessage.enable();
  
  //userScheduler.addTask(taskSendtoGatewaySerially);
  //taskSendtoGatewaySerially.enable();
 
}

void loop() {
  // it will run the user scheduler as well
  mesh.update();
  	/*String z = "";
  	if(Serial.available())
  	{
 			z = Serial.readStringUntil('$');;
 			if(z=="hello") Serial.println(z);
 			else Serial.println("Not hello");
  	}*/
}
