#include <SoftwareSerial.h>
SoftwareSerial GSM(10, 11); // RX, TX

enum _parseState {
  PS_DETECT_MSG_TYPE,

  PS_IGNORING_COMMAND_ECHO,

  PS_HTTPACTION_TYPE,
  PS_HTTPACTION_RESULT,
  PS_HTTPACTION_LENGTH,
  PS_HTTPREAD_LENGTH,
  PS_HTTPREAD_CONTENT
};

byte parseState = PS_DETECT_MSG_TYPE;
char buffer[80];
byte pos = 0;
int abc;



int contentLength = 0;

void resetBuffer() {
  memset(buffer, 0, sizeof(buffer));
  pos = 0;
}

void sendGSM(const char* msg, int waitMs = 500) {
  GSM.println(msg);
  delay(waitMs);
  while(GSM.available()) {
    parseATText(GSM.read());
  }
}

void GSM_WriteData()
{
 
  if (GSM.available())
    Serial.write(GSM.read());
 
  GSM.println("AT");
  delay(1000);
 
  GSM.println("AT+CPIN?");
  delay(1000);
 
  GSM.println("AT+CREG?");
  delay(1000);
 
  GSM.println("AT+CGATT?");
  delay(1000);
 
  GSM.println("AT+CIPSHUT");
  delay(1000);
 
  GSM.println("AT+CIPSTATUS");
  delay(2000);
 
  GSM.println("AT+CIPMUX=0");
  delay(2000);
 
  ShowSerialData();
 
  GSM.println("AT+CSTT=\"airtelgprs.com\"");//start task and setting the APN,
  delay(1000);
 
  ShowSerialData();
 
  GSM.println("AT+CIICR");//bring up wireless connection
  delay(3000);
 
  ShowSerialData();
 
  GSM.println("AT+CIFSR");//get local IP adress
  delay(2000);
 
  ShowSerialData();
 
  GSM.println("AT+CIPSPRT=0");
  delay(3000);
 
  ShowSerialData();


  
  
  GSM.println("AT+CIPSTART=\"TCP\",\"erkaltyapi.com.tr\",\"80\"");//start up the connection
  delay(6000);
 
  ShowSerialData();
 
  GSM.println("AT+CIPSEND");//begin send data to remote server
  delay(4000);
  ShowSerialData();
 String str="GET http://erkaltyapi.com.tr/aviks/mark2.php?port1ad=" + String(random(0, 60)) +"&port2ad="+String(random(0, 16)) +"&port3ad="+String(random(0,1))+"&port4ad="+String(random(0, 25))+"&port1open="+abc;
   Serial.println(str);
 GSM.println(str);//begin send data to remote server
  
 //  String str="GET http://erkaltyapi.com.tr/aviks/mark2.php?port1ad=" + String(SSicaklik) +"&port2ad="+String(y) +"&port3ad="+String(Debi2)+"&port4ad="+String(voltage)+"&port4ad="+String(batterylevelpr);
 // Serial.println(str);
 // GPRS.println(str);//begin send data to remote server
  
  delay(4000);
  ShowSerialData();
 
  GSM.println((char)26);//sending
  delay(5000);//waitting for reply, important! the time is base on the condition of internet 
  GSM.println();
 
  ShowSerialData();
 
  GSM.println("AT+CIPSHUT");//close the connection
  delay(100);
  ShowSerialData();
} 



void ShowSerialData()
{
  while(GSM.available()!=0)
  Serial.write(GSM.read());
  delay(5000); 
}

void setup()
{
  pinMode(7, OUTPUT);
  GSM.begin(9600);
  Serial.begin(9600);
  cek();
   while(GSM.available()) {
    parseATText(GSM.read());
  }
  Serial.print(abc);
}
void cek()
{
   sendGSM("AT+SAPBR=3,1,\"APN\",\"turkcell\"");  
   delay(1000);
   ShowSerialData2();
  sendGSM("AT+SAPBR=1,1",3000);
   delay(1000);
    ShowSerialData2();
  sendGSM("AT+HTTPINIT");
   delay(1000);  
    ShowSerialData2();
  sendGSM("AT+HTTPPARA=\"CID\",1");
   delay(1000);
    ShowSerialData2();
  sendGSM("AT+HTTPPARA=\"URL\",\"http://erkaltyapi.com.tr/aviks/ulastirma.php\"");
   delay(1000);
    ShowSerialData2();
  sendGSM("AT+HTTPACTION=0");
   delay(1000);
    ShowSerialData2();
  }
  
void loop()
{  
    while(GSM.available())
  Serial.write(GSM.read());
  while(Serial.available())
  GSM.write(Serial.read());

 cek();
  ShowSerialData2();
 
   while(GSM.available())
  Serial.write(GSM.read());
  while(Serial.available())
  GSM.write(Serial.read());
  GSM_WriteData();
  ShowSerialData();
  
}

void ShowSerialData2()
{
   while(GSM.available()) {
    parseATText(GSM.read());
  }
  delay(5000); 
  
  
  }

void parseATText(byte b) {

  buffer[pos++] = b;

  if ( pos >= sizeof(buffer) )
    resetBuffer(); // just to be safe

  /*
   // Detailed debugging
   Serial.println();
   Serial.print("state = ");
   Serial.println(state);
   Serial.print("b = ");
   Serial.println(b);
   Serial.print("pos = ");
   Serial.println(pos);
   Serial.print("buffer = ");
   Serial.println(buffer);*/

  switch (parseState) {
  case PS_DETECT_MSG_TYPE: 
    {
      if ( b == '\n' )
        resetBuffer();
      else {        
        if ( pos == 3 && strcmp(buffer, "AT+") == 0 ) {
          parseState = PS_IGNORING_COMMAND_ECHO;
        }
        else if ( b == ':' ) {
          //Serial.print("Checking message type: ");
          //Serial.println(buffer);

          if ( strcmp(buffer, "+HTTPACTION:") == 0 ) {
            Serial.println("Received HTTPACTION");
            parseState = PS_HTTPACTION_TYPE;
          }
          else if ( strcmp(buffer, "+HTTPREAD:") == 0 ) {
            Serial.println("Received HTTPREAD");            
            parseState = PS_HTTPREAD_LENGTH;
          }
          resetBuffer();
        }
      }
    }
    break;

  case PS_IGNORING_COMMAND_ECHO:
    {
      if ( b == '\n' ) {
        Serial.print("Ignoring echo: ");
        Serial.println(buffer);
        parseState = PS_DETECT_MSG_TYPE;
        resetBuffer();
      }
    }
    break;

  case PS_HTTPACTION_TYPE:
    {
      if ( b == ',' ) {
        Serial.print("HTTPACTION type is ");
        Serial.println(buffer);
        parseState = PS_HTTPACTION_RESULT;
        resetBuffer();
      }
    }
    break;

  case PS_HTTPACTION_RESULT:
    {
      if ( b == ',' ) {
        Serial.print("HTTPACTION result is ");
        Serial.println(buffer);
        parseState = PS_HTTPACTION_LENGTH;
        resetBuffer();
      }
    }
    break;

  case PS_HTTPACTION_LENGTH:
    {
      if ( b == '\n' ) {
        Serial.print("HTTPACTION length is ");
        Serial.println(buffer);
        
        // now request content
        GSM.print("AT+HTTPREAD=0,");
        GSM.println(buffer);
        
        parseState = PS_DETECT_MSG_TYPE;
        resetBuffer();
      }
    }
    break;

  case PS_HTTPREAD_LENGTH:
    {
      if ( b == '\n' ) {
        contentLength = atoi(buffer);
        Serial.print("HTTPREAD length is ");
        Serial.println(contentLength);
        
        Serial.print("HTTPREAD content: ");
        
        parseState = PS_HTTPREAD_CONTENT;
        resetBuffer();
      }
    }
    break;

  case PS_HTTPREAD_CONTENT:
    {
      
      // for this demo I'm just showing the content bytes in the serial monitor
       Serial.write(b);
      
       if(b%2==0)
       {
        
        abc=0;
        digitalWrite(7, LOW);
delay(1000);
 Serial.print("Vana Kapalı ");
        }
        else
        {
          abc=1;
                digitalWrite(7, HIGH);
delay(1000);
Serial.print("Vana Açık "); 
          }
           
      contentLength--;
      
      if ( contentLength <= 0 ) {

        // all content bytes have now been read

        parseState = PS_DETECT_MSG_TYPE;

      }
    }
    break;
  }
}
