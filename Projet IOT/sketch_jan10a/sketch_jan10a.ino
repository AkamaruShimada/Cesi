#include <SPI.h> // SPI
#include <MFRC522.h> // RFID
#include <WiFiNINA.h>
#include <Time.h>

#define SS_PIN 11
#define RST_PIN 6

// Déclaration 
MFRC522 rfid(SS_PIN, RST_PIN); 

// Tableau contentent l'ID
byte nuidPICC[4];

char ssid[] = "Dylan";
char pass[] = "LemonLemon31~";
int status = WL_IDLE_STATUS;

void setup() 
{ 
  // Init RS232
  Serial.begin(9600);

  /*while(!Serial);

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
  Serial.print("\n");*/



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

  // Affichage de l'ID 
  //Serial.print()
  Serial.println("Un badge est détecté");
  Serial.println(" L'ID du tag est:");
  for (byte i = 0; i < 4; i++) 
  {
    Serial.print(nuidPICC[i], HEX);
  }
  Serial.println();

  // Re-Init RFID
  rfid.PICC_HaltA(); // Halt PICC
  rfid.PCD_StopCrypto1(); // Stop encryption on PCD
}