
#include "digitLibrary.h"

SegmentDevice::SegmentDevice()
{
}
SegmentDevice::SegmentDevice(int * pinsSegments , int * pinsDigits )
{

  int ii ;

  for (ii = 0 ; ii < 7 ; ii++)
  {
    
    pinMode(pinsSegments[ii],OUTPUT);
    _arrayPin_segment[ii] = pinsSegments[ii];
    // Serial.println(ii);
    Serial.println(pinsSegments[ii]);

  }

  
  for (ii = 0 ; ii < 4 ; ii++)
  {

    pinMode(pinsDigits[ii],OUTPUT);
    _arrayPin_digit[ii] = pinsDigits[ii];
    // Serial.println(pinsDigits[ii]);
  }

}


void SegmentDevice::assignPin_Segment(int * pinsSegments )
{

  int ii ;
  for (ii = 0 ; ii < 7 ; ii++)
  {
    pinMode(pinsSegments[ii],OUTPUT);
    _arrayPin_segment[ii] = pinsSegments[ii];
  }

}


void SegmentDevice::assignPin_Digit(int * pinsDigits )
{



  int ii ;
  for (ii = 0 ; ii < 4 ; ii++)
  {
    pinMode(pinsDigits[ii],OUTPUT);
    _arrayPin_digit[ii] = pinsDigits[ii];
  }
}


////DIGIT PART
////I HAVE TO CREATE A FUNCTION
void SegmentDevice::pickNumber(int x){
  Serial.println(x);
   switch(x){
     case 1: one(); break;
     case 2: two(); break;
     case 3: three(); break;
     case 4: four(); break;
     case 5: five(); break;
     case 6: six(); break;
     case 7: seven(); break;
     case 8: eight(); break;
     case 9: nine(); break;
     default: zero(); break;
   }
}
//
void SegmentDevice::clearLEDs()
{  

  int ii;
  for (ii = 0 ; ii < 7 ; ii++)
  {
    digitalWrite(  _arrayPin_segment[ii], LOW); // A  
  }
  
  
}

void SegmentDevice::one()
{

  digitalWrite( _arrayPin_segment[0], LOW);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], LOW);
  digitalWrite( _arrayPin_segment[4], LOW);
  digitalWrite( _arrayPin_segment[5], LOW);
  digitalWrite( _arrayPin_segment[6], LOW);
}

void SegmentDevice::two()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], LOW);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], HIGH);
  digitalWrite( _arrayPin_segment[5], LOW);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::three()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], LOW);
  digitalWrite( _arrayPin_segment[5], LOW);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::four()
{
  digitalWrite( _arrayPin_segment[0], LOW);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], LOW);
  digitalWrite( _arrayPin_segment[4], LOW);
  digitalWrite( _arrayPin_segment[5], HIGH);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::five()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], LOW);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], LOW);
  digitalWrite( _arrayPin_segment[5], HIGH);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::six()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], LOW);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], HIGH);
  digitalWrite( _arrayPin_segment[5], HIGH);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::seven()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], LOW);
  digitalWrite( _arrayPin_segment[4], LOW);
  digitalWrite( _arrayPin_segment[5], LOW);
  digitalWrite( _arrayPin_segment[6], LOW);
}

void SegmentDevice::eight()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], HIGH);
  digitalWrite( _arrayPin_segment[5], HIGH);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::nine()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], LOW);
  digitalWrite( _arrayPin_segment[5], HIGH);
  digitalWrite( _arrayPin_segment[6], HIGH);
}

void SegmentDevice::zero()
{
  digitalWrite( _arrayPin_segment[0], HIGH);
  digitalWrite( _arrayPin_segment[1], HIGH);
  digitalWrite( _arrayPin_segment[2], HIGH);
  digitalWrite( _arrayPin_segment[3], HIGH);
  digitalWrite( _arrayPin_segment[4], HIGH);
  digitalWrite( _arrayPin_segment[5], HIGH);
  digitalWrite( _arrayPin_segment[6], LOW);
}