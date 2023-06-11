#include <Adafruit_ADS1X15.h>
#include "DHT.h"
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266HTTPClient.h>



 #define DHTTYPE DHT11

 DHT dht2(3,DHTTYPE);
Adafruit_ADS1015 ads;  
WiFiClient client;

float humidityData;
float temperatureData;
float moisture_percentage;
float gas_percentage; 
float raindrop; //if this value gets 0 rain is present 
const char* ssid = "Airtel_7972143327";
const char* password = "air62994";
bool rainbool;

char server[] = "192.168.1.7"; 
const char* serverName = "http://192.168.1.7/iot_farm_monitoring/dht11.php";

void setup(void)
{
  Serial.begin(9600);
  Serial.println("Hello!");
  // Connect to WiFi network
  ads.setGain(GAIN_TWOTHIRDS);
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
 
  WiFi.begin(ssid, password);
 
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
 
  // Start the server
  Serial.println("Server started");
  Serial.print(WiFi.localIP());
  delay(1000);
  Serial.println("connecting...");
  if (!ads.begin()) {
    Serial.println("Failed to initialize ADS.");
    while (1);
  }
}

void loop(void)
{
  float adc0, adc1, adc2;

  adc0 = ads.readADC_SingleEnded(0);
  adc1 = ads.readADC_SingleEnded(1);
  adc2 = ads.readADC_SingleEnded(2);
  Serial.println("-----------------------------------------------------------");
  humidityData = dht2.readHumidity();
  temperatureData = dht2.readTemperature(); 
  moisture_percentage = (100.00 - (adc1/1023.00) * 100.00);
  raindrop = adc2;
  gas_percentage = adc0;
  if(raindrop <500.00){
    rainbool = 1;
  }
  else{
    rainbool = 0;
  }
  Sending_To_phpmyadmindatabase(); 
  delay(5000); // interval
}
 void Sending_To_phpmyadmindatabase()   //CONNECTING WITH MYSQL
 {
  HTTPClient https;

   if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP request:

    String getData = "?temperature=" + String(temperatureData) + "&humidity=" + String(humidityData) + "&moisture=" + String(moisture_percentage) + "&gas=" + String(gas_percentage) + "&rain=" + String(rainbool);
    String Link = "http://192.168.1.7/iot_farm_monitoring/dht11.php" + getData;

    Serial.print("[HTTPS] begin .... \n");
    
    if(https.begin(client, Link)){

      Serial.print("[HTTPS] GET .... \n");
      int httpCode = https.GET();

      if(httpCode > 0){
        Serial.printf(" HTTPS GET...... code ; %d \n", httpCode);
        Serial.println(Link);
        //file found at server
        if(httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY){
          String payload = https.getString();
        }
      }

    }
    else{
      Serial.printf("HTTPS GET..... FAILED");
    }
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
 }
