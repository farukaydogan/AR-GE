//Saniye başında +0.03 saniye sapma oluyor. Bu değer arduinonun işlem yaptığı gecikme suresidir. Bu nedenle sapma degeri program yukune gore degisebilir.
//Sicaklik sensorunun kutuphaneleri.
//LOW vanayı açar, HIGH vanayı kapatır.(Mavi giriş adaptördeki beyaz çıkışa bağlanırsa.)
#include <OneWire.h>
#include <DallasTemperature.h>
#include <EEPROM.h>
#include <SoftwareSerial.h>


SoftwareSerial gprsSerial(10,11);

 

String BasincWU, SicaklikWU, DebiWU;

//Sicaklik sensoru girisinin belirlenmesi

#define ONE_WIRE_BUS 2
OneWire oneWire(ONE_WIRE_BUS);

//Sicaklik sensorunun tanimlanmasi

DallasTemperature sensors(&oneWire);

//DeviceAddress insideThermometer;

float OSicaklik, SSicaklik;

//Vana rolelerinin tanimlanmasi


int RPWM = 8;
int LPWM = 9;
int L_EN = 5;
int R_EN = 6;
int R_I = 12;
int L_I = 13;

int sayac;

String VanaW = "Kapalı";

String VanaWU = "0";

//Vana sensoru icin eeprom bellek alan tahsisi

int adres = 15;
int vanaDurumu;

int DebiSensorPin = 3;

int Durum1, Durum2 = 1 ;
float RPM = 0 ;

const long Zaman = 5000;

unsigned long OZaman = 0;

unsigned long YZaman = millis();


int sensorValue1;
int sensorValue2; 
  
float voltage, batterylevel;
int batterylevelpr;

// Hiz : Olculen RPM degerinden cizgisel hiza donusturuldugunda elde edilen hiz degeridir. Formulu oldukca basit ve mantik yuruterek dahi bulunabilir. Cunku 1 turda kanat kendi cevresi
//kadar cizgisel yol alir. 1 Saniyede aldigi devir sayisi 10 ise, 1 saniyede alabilecegi yol uzunlugu cevresinin 10 kati olur. Bu mantik ile formulun "(2*pi*r*RPM)/60" oldugu cikarilir.
//Degeri 60'a boluyoruz cunku RPM dakikada ki devir sayisidir. Bize saniyedeki devir sayisi lazim.
// Debi : RPM'den yola cikarak hesaplanan cizgisel hiza gore boru ıc capindan gecen suyun debisinin hesaplanmasinin yapilması icin olusturulan degiskendir.

float Hiz = 0, Debi1 = 0, Debi2 = 0;

//Basinc Sensoru

const int BasincSensorPin = A1;

float x = 0;
float y = 0.0;


// Hesaplamada daha kolay islem yapilip, islem kalabaligi olusturulmamasi icin pi degeri onceden PI adinda sabit bir deger olarak tanimlandi.
#define PI 3.1415926535897932384626433832795


void setup() {

  vanaDurumu = EEPROM.read(adres);

  for (int i = 8; i < 14; i++) 
  {
    pinMode(i, OUTPUT);
  }
  
  for (int i = 8; i < 14; i++) 
  {
    digitalWrite(i, LOW);
  }
  
  digitalWrite(R_I, 35);
  digitalWrite(L_I, 35);

  pinMode(DebiSensorPin, INPUT);
  Serial.begin(9600);
   gprsSerial.begin(9600);   

  //Sicaklik Sensorunun calistirilmasi
  
  sensors.begin();
  
  
  digitalWrite(R_EN, HIGH);
  digitalWrite(L_EN, HIGH);
  
  /*analogWrite(RPWM, 255);
  delay(50000);
  analogWrite(RPWM, 0);
  delay(50);*/
  
  x = analogRead(BasincSensorPin);
  y = (pow(x, 2) * pow(10, (-6)) * 8.643476371) + (x * pow(10, (-3)) * 6.275544327) + 0.2910301502 - 1;

  delay(1000);
}

void GSM_WriteData()
{
 
  if (gprsSerial.available())
    Serial.write(gprsSerial.read());
 
  gprsSerial.println("AT");
  delay(1000);
 
  gprsSerial.println("AT+CPIN?");
  delay(1000);
 
  gprsSerial.println("AT+CREG?");
  delay(1000);
 
  gprsSerial.println("AT+CGATT?");
  delay(1000);
 
  gprsSerial.println("AT+CIPSHUT");
  delay(1000);
 
  gprsSerial.println("AT+CIPSTATUS");
  delay(2000);
 
  gprsSerial.println("AT+CIPMUX=0");
  delay(2000);
 
  ShowSerialData();
 
  gprsSerial.println("AT+CSTT=\"airtelgprs.com\"");//start task and setting the APN,
  delay(1000);
 
  ShowSerialData();
 
  gprsSerial.println("AT+CIICR");//bring up wireless connection
  delay(3000);
 
  ShowSerialData();
 
  gprsSerial.println("AT+CIFSR");//get local IP adress
  delay(2000);
 
  ShowSerialData();
 
  gprsSerial.println("AT+CIPSPRT=0");
  delay(3000);
 
  ShowSerialData();
  
  gprsSerial.println("AT+CIPSTART=\"TCP\",\"api.thingspeak.com\",\"80\"");//start up the connection
  delay(6000);
 
  ShowSerialData();
 
  gprsSerial.println("AT+CIPSEND");//begin send data to remote server
  delay(4000);
  ShowSerialData();
  
  String str="GET https://api.thingspeak.com/update?api_key=OQZV6SX9ZWWWJDMJ&field1=" + String(SSicaklik) +"&field2="+String(y) +"&field3="+String(Debi2)+"&field5="+String(voltage)+"&field4="+String(batterylevelpr);
  Serial.println(str);
  gprsSerial.println(str);//begin send data to remote server
  
  delay(4000);
  ShowSerialData();
 
  gprsSerial.println((char)26);//sending
  delay(5000);//waitting for reply, important! the time is base on the condition of internet 
  gprsSerial.println();
 
  ShowSerialData();
 
  gprsSerial.println("AT+CIPSHUT");//close the connection
  delay(100);
  ShowSerialData();
} 



void ShowSerialData()
{
  while(gprsSerial.available()!=0)
  Serial.write(gprsSerial.read());
  delay(5000); 
  
  
  }


void Voltage()
{
  
  sensorValue1 = analogRead(A3);
  sensorValue2 = analogRead(A5);
  
   voltage = sensorValue1 * (15.0 / 1023.0);
   
  batterylevel = sensorValue2 * (5.0 / 1023.0);
  batterylevelpr  =  batterylevel*20;
  
  }




  void Temperature()
  {
     //Sensorden sicakligi okumasinin talep edilmesi
    sensors.requestTemperatures();
    //Okunan degerin alinip ekrana yazdirilmasi
    SSicaklik = sensors.getTempCByIndex(0);
    }

    void Pressure ()
    {
    x = analogRead(BasincSensorPin);
    y = (pow(x, 2) * pow(10, (-6)) * 8.643476371) + (x * pow(10, (-3)) * 6.275544327) + 0.2910301502 - 1;
     
    }

      void hesaplama() {
  YZaman = millis();
  Durum1 = digitalRead(DebiSensorPin);

  //***************************************************************//
  //******************* RPM, Debi ve Hiz Olcme ********************//
  //***************************************************************//

  if (Durum1 != Durum2) {
    if ( Durum1 == LOW ) {
      RPM = RPM + 0.25;
    }
  }
  Durum2 = Durum1;
  if (YZaman - OZaman >= Zaman) {
    OZaman = YZaman;
    RPM = RPM * 12;
    // 1.19 Hiz Hesabi
    Hiz = 1.55 * 0.035 * PI * RPM / 60;

    // Debi Hesabi.
    Debi1 = Hiz * 0.097 * 0.097 * PI * 3600 / 4;

    //Sensor sayimi itibari ile gecen toplam debi
    Debi2 = Debi2 + Hiz * 0.097 * 0.097 * PI / 4;
    RPM = 0 ;

    Pressure();
    Temperature();
  
    if (Debi1 < 5) {
      DebiWU = "0";
    }
    else {
      DebiWU = "1";
    }
    if (SSicaklik > 35 || SSicaklik < 5) {
      SicaklikWU = "0";
    }
    else {
      SicaklikWU = "1";
    }
    if (y < 0.5) {
      BasincWU = "0";
    }
    else {
      BasincWU = "1";
    }

  }

  
}




void Vana()
{
  
  
  vanaDurumu = EEPROM.read(adres);
  
  digitalWrite(R_EN, HIGH);
  digitalWrite(L_EN, HIGH);
  
  if (y < 0.5 && vanaDurumu != 0) 
  {
    Serial.println("Vana kapatiliyor");
    for (sayac = 0; sayac <= 255; sayac += 2) 
    {
      analogWrite(RPWM, sayac);
      delay(50);
    }
    
    delay(60320);
    
    EEPROM.write(adres, 0);
    
    VanaW = "Kapalı";
    VanaWU = "0";
    
    for (sayac = 255; sayac >= 0; sayac -= 5) 
    {
      analogWrite(RPWM, sayac);
      delay(20);
    }

  }  
  
    if (y >= 0.4 && vanaDurumu != 1) 
    {
    Serial.println("Vana aciliyor");
    
    for (sayac = 0; sayac <= 255; sayac += 2) 
    {
      analogWrite(LPWM, sayac);
      delay(50);
    }
    
    delay(60300);
    
    EEPROM.write(adres, 1);
    
    VanaW = "Açık";
    VanaWU = "1";
    
    for (sayac = 255; sayac >= 0; sayac -= 5) 
    {
      analogWrite(LPWM, sayac);
      delay(20);

    }
  }
  
  
  }

void loop() {

  hesaplama();
  Temperature();
  Pressure();
  Vana();
  Voltage();


Serial.print("Temp:");
Serial.print(SSicaklik);
Serial.print("      Pressure:");
Serial.print(y);
Serial.print("      Flow:");
Serial.print(Debi2);
Serial.print("      VanaDurum:");
Serial.print(VanaW);
Serial.print("      RegulatorOut= ");
Serial.print(voltage);
Serial.print("      BatteryChargeLevel="); 
Serial.print(batterylevelpr);
Serial.println("%");
delay(500);
GSM_WriteData();
}
