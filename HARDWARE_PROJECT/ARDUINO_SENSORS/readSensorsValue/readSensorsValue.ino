#include <digitLibrary.h>
#define LOOP_DEFAULT_VALUE 1000
int pinLed = 2;

//Analog Input from the Sensor board
//PM2.5
int PM2_5 = A0;


int CO_WE = A1;
int CO_AE = A2;

int O3_WE = A3;
int O3_AE = A4;
int PT_p  = A5;

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
  ctrl = 1;
  pinMode(pinLed, OUTPUT);  

  pinMode(digit, OUTPUT);  
  pinMode(segment, OUTPUT);  

  digitalWrite(digit, HIGH);
  digitalWrite(segment, HIGH);
  delayLoop = LOOP_DEFAULT_VALUE;
  analogReadResolution(12);

  int ii;
  for(ii = 0 ; ii < 7 ; ii++)
  {
    arraySegments[ii] = ii + startPortSegment; 
  }

  for(ii = 0 ; ii < 4 ; ii++)
  {
    arrayDigits[ii] = ii + startPortDigit; 
  }

//  SegmentDevice controlLED(arraySegments,arrayDigits);

  digitalWrite(pinLed, HIGH);
}



void loop()
{
 

  Serial.print(analogRead(CO_WE));
  Serial.print(",");
  Serial.print(analogRead(CO_AE));
  Serial.print(",");
  Serial.print(analogRead(O3_WE));
  Serial.print(",");
  Serial.print(analogRead(O3_AE));
  Serial.print(",");
  Serial.print(analogRead(PT_p));
  Serial.print(",");
  Serial.print(analogRead(PM2_5));
  Serial.println();



  if (ctrl == 0)
  {
    digitalWrite(pinLed, HIGH);
    ctrl = 1;
  }
  else
  {
   
    digitalWrite(pinLed, LOW);
    ctrl = 0;
  }

//  int tmpValue = Serial.read();
//  if (tmpValue != -1)
//  {
//    delayLoop = tmpValue;
//  }
//  else
//  {
//    delayLoop = LOOP_DEFAULT_VALUE;
//  }
  delay(delayLoop);
}


