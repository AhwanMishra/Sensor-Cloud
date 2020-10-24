#include "namedMesh.h"

#include <MQ2.h>
#include <Wire.h> 

#include <ArduinoJson.h>

int pin = A0;
int lpg =0, co=0, smoke=0;
float analog1;
MQ2 mq2(pin);

#define   MESH_SSID       "MeshNetwork"
#define   MESH_PASSWORD   "somethingSneaky"
#define   MESH_PORT       5555

Scheduler     userScheduler; // to control your personal task
namedMesh  mesh;

String nodeName = "node4"; // Name needs to be unique



Task taskSendProperties( TASK_SECOND*(20), TASK_FOREVER, []() {
	String to = "node2";
	int ADC_Value = ESP.getVcc();
	int wifi_strength = WiFi.RSSI();
	DynamicJsonDocument doc(1024);
    JsonObject obj1 = doc.to<JsonObject>();
	obj1["from"] = "node4";
	obj1["type"] = "status";
	obj1["WIFI"] = wifi_strength;
	obj1["VOLT"] = ADC_Value;
	
	String msg;
  	serializeJson(doc, msg);
	Serial.println(msg);
    mesh.sendSingle(to, msg); 
});

int interval;
bool flag = 0;

Task taskSendMessage( TASK_SECOND*(interval), TASK_FOREVER, []() {
if(flag ==0) return;

		String to = "node2";
		DynamicJsonDocument doc(1024);
    JsonObject obj1 = doc.to<JsonObject>();
		
		obj1["from"] = "node4";
		obj1["type"] = "data";
		obj1["LPG"] = lpg;
		obj1["CO"] = co;
		obj1["SMOKE"] = smoke;
		obj1["ANALOG1"] = analog1;

		String msg;
  	serializeJson(doc, msg);
		Serial.println(msg);
    
    mesh.sendSingle(to, msg);

     
}); // start with a one second interval

void setup() {
//pinMode(LED_BUILTIN, OUTPUT);
	//digitalWrite(LED_BUILTIN, LOW);
	//delay(10000);
	//digitalWrite(LED_BUILTIN, HIGH);
  Serial.begin(9600);
	//pinMode(LED_BUILTIN, OUTPUT);
	//digitalWrite(LED_BUILTIN, HIGH); //Low to turn On
	
	mq2.begin();


  mesh.setDebugMsgTypes(ERROR | DEBUG | CONNECTION);  // set before init() so that you can see startup messages

  mesh.init(MESH_SSID, MESH_PASSWORD, &userScheduler, MESH_PORT);

  mesh.setName(nodeName); // This needs to be an unique name! 

  mesh.onReceive([](uint32_t from, String &msg) {
    Serial.printf("Received message by id from: %u, %s\n", from, msg.c_str());
  });

  mesh.onReceive([](String &from, String &msg) {
    Serial.printf("Received message by name from: %s, %s\n", from.c_str(), msg.c_str());
  });

  mesh.onChangedConnections([]() {
    Serial.printf("Changed connection\n");
  });

  userScheduler.addTask(taskSendMessage);
  taskSendMessage.enable();
  
  userScheduler.addTask(taskSendProperties);
  taskSendProperties.enable();
}

void loop() {
  // it will run the user scheduler as well
  mesh.update();
  

   float* values= mq2.read(false); //set it false if you don't want to print the values in the Serial
  
  //lpg = values[0];
  lpg = mq2.readLPG();
  //co = values[1];
  co = mq2.readCO();
  //smoke = values[2];
  smoke = mq2.readSmoke();
  
 	analog1 = analogRead(A0);
/*Serial.println(analog1);
  Serial.println("");
  Serial.println("LPG: ");
  Serial.println(lpg);
  Serial.println("CO: ");
  Serial.println(co);
  Serial.println("SMOKE: ");
  Serial.println(smoke);
  Serial.println("");*/

  
}
