#include <SPI.h> // SPI
#include <MFRC522.h> // RFID
#include <WiFiNINA.h>
#include <Time.h>
#include <string>

//#include <Bridge.h>
#include <ArduinoHttpClient.h>
#include <WiFiClient.h>


#define SS_PIN 11
#define RST_PIN 6

// Déclaration 
MFRC522 rfid(SS_PIN, RST_PIN); 

// Tableau contentent l'ID
byte nuidPICC[4];

char ssid[] = "Aka";
char pass[] = "LemonLemon31";
//char ssid[] = "iPhoneJoris";
//char pass[] = "jorisdenice";
//char ssid[] = "SFR-16a8";
//char pass[] = "DLA4UWMTFGZK";

char serverName[] = "192.168.89.5";
int port = 80;

WiFiClient wifi;
HttpClient client = HttpClient(wifi, serverName, port);

int status = WL_IDLE_STATUS;

void setup() 
{ 
  // Init RS232
  Serial.begin(115200);

  while(!Serial);

    while (status != WL_CONNECTED) {
    Serial.print("CONNEXION.. \n");
    status = WiFi.begin(ssid, pass);
    delay(10000);
  }
  Serial.print("CONNEXION ");
  Serial.print("ETABLIE \n");
  delay(5000);

  IPAddress ip = WiFi.localIP();
  Serial.print(ip);
  Serial.print("\n");

  Serial.print("Présentez un badge");
  // Init SPI bus
  SPI.begin(); 

  // Init MFRC522 
  rfid.PCD_Init(); 
}

void loop() 
{
  // Initialisé la boucle si aucun badge n'est présent 
  if ( !rfid.PICC_IsNewCardPresent())
    return;

  // Vérifier la présence d'un nouveau badge 
  if ( !rfid.PICC_ReadCardSerial())
    return;

  // Enregistrer l'ID du badge (4 octets) 
  for (byte i = 0; i < 4; i++) 
  {
    nuidPICC[i] = rfid.uid.uidByte[i];
  }
  String badge;

  // Affichage de l'ID
  Serial.println("Un badge est détecté");
  Serial.println("L'ID du badge est:");
  badge = String(nuidPICC[1]);
  badge += String(nuidPICC[2]);
  badge += String(nuidPICC[3]);
  badge += String(nuidPICC[4]);

  //Serial.print(nuidPICC[i]);
  Serial.print(badge);
  Serial.println();

  // Re-Init RFID
  rfid.PICC_HaltA(); // Halt PICC
  rfid.PCD_StopCrypto1(); // Stop encryption on PCD

  String contentType = "application/x-www-form-urlencoded";
  String postData = "Badge=" + badge;
  Serial.println(postData);

  client.post("/passage.php", contentType, postData);

  // read the status code and body of the response
  int statusCode = client.responseStatusCode();
  String response = client.responseBody();

  Serial.print("Status code: ");
  Serial.println(statusCode);
  Serial.print("Response: ");
  Serial.println(response);
  
  Serial.println("Fin, badgeage possible");
 

  delay(1000);

}