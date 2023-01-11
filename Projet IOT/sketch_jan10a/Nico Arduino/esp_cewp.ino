/*
cube2

 */

#include <EnvironmentCalculations.h>
#include <BME280I2C.h>
#include <Wire.h>

#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>

#include <LiquidCrystal_I2C.h>       // Include LiquidCrystal_I2C library 
LiquidCrystal_I2C lcd(0x27, 16, 2);

#define SERIAL_BAUD 115200



#ifndef STASSID
#define STASSID "GalaxyZFold_takus"
#define STAPSK  "internet"
#endif




// Assumed environmental values:
float referencePressure = 1018.6;  // hPa local QFF (official meteor-station reading)
float outdoorTemp = 4.7;           // °C  measured local outdoor temp.
float barometerAltitude = 1650.3;  // meters ... map readings + barometer position

const char* ssid     = STASSID;
const char* password = STAPSK;

const char* host = "192.168.1.1";
const uint16_t port = 3000;

const char* serverName = "http://192.168.58.115:22/data";

ESP8266WiFiMulti WiFiMulti;

HTTPClient http;


BME280I2C::Settings settings(
   BME280::OSR_X1,
   BME280::OSR_X1,
   BME280::OSR_X1,
   BME280::Mode_Forced,
   BME280::StandbyTime_1000ms,
   BME280::Filter_16,
   BME280::SpiEnable_False,
   BME280I2C::I2CAddr_0x76
);

BME280I2C bme(settings);





//////////////////////////////////////////////////////////////////
void setup()
{
  Serial.begin(SERIAL_BAUD);
  Wire.begin(0,2);
  lcd.init();
  lcd.cursor_on();            
  lcd.backlight();                
  lcd.setCursor(15, 0);


  byte i = 0;
   //char text[4];

  //lcd.clear();

    

    lcd.print("connection en cours...");
  for (int positionCounter = 0; positionCounter < 45; positionCounter++) {
    // scroll one position left:
    lcd.scrollDisplayLeft();
    // wait a bit:
    
    delay(150);
  
  }

  while(!Serial) {} // Wait

 // We start by connecting to a WiFi network
  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP(ssid, password);

  Serial.println();
  Serial.println();
  Serial.print("Wait for WiFi... ");

  while (WiFiMulti.run() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());


 

  while(!bme.begin())
  {
    Serial.println("Could not find BME280 sensor!");
    delay(1000);
  }

  switch(bme.chipModel())
  {
     case BME280::ChipModel_BME280:
       Serial.println("Found BME280 sensor! Success.");
       break;
     case BME280::ChipModel_BMP280:
       Serial.println("Found BMP280 sensor! No Humidity available.");
       break;
     default:
       Serial.println("Found UNKNOWN sensor! Error!");
  }
  Serial.print("Assumed outdoor temperature: "); Serial.print(outdoorTemp);
  Serial.print("°C\nAssumed reduced sea level Pressure: "); Serial.print(referencePressure);
  Serial.print("hPa\nAssumed barometer altitude: "); Serial.print(barometerAltitude);
  Serial.println("m\n***************************************");
  
  
}






//////////////////////////////////////////////////////////////////
void printBME280Data
(
   Stream* client
)
{
   float temp(NAN), hum(NAN), pres(NAN);

   BME280::TempUnit tempUnit(BME280::TempUnit_Celsius);
   BME280::PresUnit presUnit(BME280::PresUnit_hPa);

   bme.read(pres, temp, hum, tempUnit, presUnit);

   client->print("Temp: ");
   client->print(temp);
   client->print("°"+ String(tempUnit == BME280::TempUnit_Celsius ? "C" :"F"));
   client->print("\t\tHumidity: ");
   client->print(hum);
   client->print("% RH");
   client->print("\t\tPressure: ");
   client->print(pres);
   client->print(String(presUnit == BME280::PresUnit_hPa ? "hPa" : "Pa")); // expected hPa and Pa only

   EnvironmentCalculations::AltitudeUnit envAltUnit  =  EnvironmentCalculations::AltitudeUnit_Meters;
   EnvironmentCalculations::TempUnit     envTempUnit =  EnvironmentCalculations::TempUnit_Celsius;

   /// To get correct local altitude/height (QNE) the reference Pressure
   ///    should be taken from meteorologic messages (QNH or QFF)
   float altitude = EnvironmentCalculations::Altitude(pres, envAltUnit, referencePressure, outdoorTemp, envTempUnit);

   float dewPoint = EnvironmentCalculations::DewPoint(temp, hum, envTempUnit);

   /// To get correct seaLevel pressure (QNH, QFF)
   ///    the altitude value should be independent on measured pressure.
   /// It is necessary to use fixed altitude point e.g. the altitude of barometer read in a map
   float seaLevel = EnvironmentCalculations::EquivalentSeaLevelPressure(barometerAltitude, temp, pres, envAltUnit, envTempUnit);

   float absHum = EnvironmentCalculations::AbsoluteHumidity(temp, hum, envTempUnit);

   client->print("\t\tAltitude: ");
   client->print(altitude);
   client->print((envAltUnit == EnvironmentCalculations::AltitudeUnit_Meters ? "m" : "ft"));
   client->print("\t\tDew point: ");
   client->print(dewPoint);
   client->print("°"+ String(envTempUnit == EnvironmentCalculations::TempUnit_Celsius ? "C" :"F"));
   client->print("\t\tEquivalent Sea Level Pressure: ");
   client->print(seaLevel);
   client->print(String( presUnit == BME280::PresUnit_hPa ? "hPa" :"Pa")); // expected hPa and Pa only

   client->print("\t\tHeat Index: ");
   float heatIndex = EnvironmentCalculations::HeatIndex(temp, hum, envTempUnit);
   client->print(heatIndex);
   client->print("°"+ String(envTempUnit == EnvironmentCalculations::TempUnit_Celsius ? "C" :"F"));

   client->print("\t\tAbsolute Humidity: ");
   client->println(absHum);
  
   lcd.init();
   lcd.setCursor(0, 0); 
   lcd.print(WiFi.localIP());
   lcd.setCursor(5, 1); 
   lcd.print(temp);              
   


   byte i = 0;
   //char text[4];

  //lcd.clear();
  
   WiFiClient Wclient;
   HTTPClient http;
    
   
  http.begin(Wclient, serverName);
  
  //http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  //String httpRequestData = "api_key=tPmAT5Ab3j7F9&sensor=BME280&value1=24.25&value2=49.54&value3=1005.14";  
  //int httpResponseCode = http.POST(httpRequestData);

  http.addHeader("Content-Type", "application/json");
  int httpResponseCode = http.POST("{\"api_key\":\"tPmAT5Ab3j7F9\",\"sensor\":\"BME280\",\"Temp\":\"24.25\",\"Humidity\":\"49.54\",\"Pressure\":\"1005.14\"}");

  

   Serial.print("HTTP Response code: ");
   Serial.println(httpResponseCode);
   http.end();

   delay(1000);
}


//////////////////////////////////////////////////////////////////
void loop()
{
   printBME280Data(&Serial);
   delay(500);
}