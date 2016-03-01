#include <digitLibrary.h>
#include <Wire.h>
#include <Adafruit_ADS1015.h>
Adafruit_ADS1015 ads1015;

#define LOOP_DEFAULT_VALUE 1000
int pinLed = 2;

//Analog Input from the Sensor board
//PM2.5
int NO2_WE = A0;
int NO2_AE = A5;

int CO_WE = A2;
int CO_AE = A3;

int O3_WE = A1;
int O3_AE = A4;


int LED = 2;


//PIN 7 way
int pinDigit      = 11;
int pinDigit2     = 12;
int pinDigit3     = 13;
int pinDigit4     = 14;

int arraySegments[7];
int arrayDigits[4];


int startPortSegment  = 4;
int startPortDigit    = 11;


int digit=8;
int segment=9;


int ctrl ;
int delayLoop;
void setup()
{
  Serial.begin(115200);
   while (!Serial);
  delay(100);
  ctrl = 1;
  analogReadResolution(12);
  pinMode(LED, OUTPUT);  



  digitalWrite(pinLed, HIGH);
//I2C
  ads1015.begin();
  ads1015.setGain(GAIN_ONE);
//  pinMode(LED, OUTPUT);  
}

int delayADC = 10;
int count = 0;
void loop()
{



      if (Serial.available() > 0 && count == 1) {
        
        while(Serial.available() > 0){
          Serial.read();
        }
          
        
        
        int16_t temp = ads1015.readADC_SingleEnded(0);
        int16_t pm25 = ads1015.readADC_SingleEnded(1);

        int16_t CO_w = analogRead(CO_WE);
        delay(delayADC);
        int16_t CO_a = analogRead(CO_AE);
        delay(delayADC);
        int16_t O3_w = analogRead(O3_WE);
        delay(delayADC);
        int16_t O3_a = analogRead(O3_AE);
        delay(delayADC);
        int16_t NO2_w = analogRead(NO2_WE);
        delay(delayADC);
        int16_t NO2_a = analogRead(NO2_AE);
        String ss = String(CO_w)+ ','+String(CO_a)+ ','+String(O3_w)+ ','+String(O3_a)+ ',' +String(NO2_w)+ ','+String(NO2_a)+ ',' + String(pm25)+ ','+String(temp);
//        String ss = String(CO_w)+ ','+String(CO_a)+ ','+String(O3_w)+ ','+String(O3_a)+ ',' +String(NO2_w)+ ','+String(NO2_a)+ ',' + String(temp)+ ','+String(pm25)+',' +String(Serial.available());

        Serial.println(ss);
        
        
        digitalWrite(LED, HIGH);
        delay(100);
        digitalWrite(LED, LOW);

        

      }
      if(count == 0){
        count++ ;
      }
}



//  pinMode(digit, OUTPUT);  
//  pinMode(segment, OUTPUT);  
//
//  digitalWrite(digit, HIGH);
//  digitalWrite(segment, HIGH);
//  delayLoop = LOOP_DEFAULT_VALUE;

//
//  int ii;
//  for(ii = 0 ; ii < 7 ; ii++)
//  {
//    arraySegments[ii] = ii + startPortSegment; 
//  }
//
//  for(ii = 0 ; ii < 4 ; ii++)
//  {
//    arrayDigits[ii] = ii + startPortDigit; 
//  }

//  SegmentDevice controlLED(arraySegments,arrayDigits);

