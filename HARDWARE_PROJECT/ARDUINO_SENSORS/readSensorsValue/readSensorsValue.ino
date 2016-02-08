#include <digitLibrary.h>


#define LOOP_DEFAULT_VALUE 1000
int pinLed = 0;

//Analog Input from the Sensor board
int PT_p  = A0;

int CO_WE = A1;
int CO_AE = A2;

int O3_WE = A3;
int O3_AE = A4;
//PM2.5
int PM2_5 = A5;

//PIN 7 way
int pinDigit      = 11;
int pinDigit2     = 12;
int pinDigit3     = 13;
int pinDigit4     = 14;



int arraySegments[7];
int arrayDigits[4];


int startPortSegment  = 4;
int startPortDigit    = 11;


int ctrl ;
int delayLoop;
void setup()
{
  Serial.begin(115200);
  ctrl = 1;
  pinMode(pinLed, OUTPUT);  
  delayLoop = LOOP_DEFAULT_VALUE;


  int ii;
  for(ii = 0 ; ii < 7 ; ii++)
  {
    arraySegments[ii] = ii + startPortSegment; 
  }

  for(ii = 0 ; ii < 4 ; ii++)
  {
    arrayDigits[ii] = ii + startPortDigit; 
  }

  SegmentDevice controlLED(arraySegments,arrayDigits);
}



void loop()
{
  analogReadResolution(12);

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
    //    digitalWrite(pinDigit, HIGH);
    //    digitalWrite(pinDigit2, LOW);
    //
    //    digitalWrite(pinSegmentE, HIGH);
    //
    digitalWrite(pinLed, HIGH);
    //
    ctrl = 1;
  }
  else
  {
    //    digitalWrite(pinDigit, LOW);
    //    digitalWrite(pinDigit2, LOW);
    //    digitalWrite(pinSegmentE, HIGH);
    //
    digitalWrite(pinLed, LOW);

    ctrl = 0;
  }

  int tmpValue = Serial.read();
  if (tmpValue != -1)
  {
    delayLoop = tmpValue;
  }
  else
  {
    delayLoop = LOOP_DEFAULT_VALUE;
  }
  delay(delayLoop);
}


