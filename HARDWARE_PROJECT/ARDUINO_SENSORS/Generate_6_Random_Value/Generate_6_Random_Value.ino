int pinLed = 7;
int ctrl ;
int PT_p  = A0;
int PT_m  = A1;

void setup() 
{
  Serial.begin(115200);
  ctrl = 1;
  pinMode(pinLed,OUTPUT);



  
}

void loop() 
{
//  DateTime.now();  
  Serial.print(random(100,999));
  Serial.print(",");
  Serial.print(random(100,999));
  Serial.print(",");
  Serial.print(random(100,999));
  Serial.print(",");
  Serial.print(random(100,999));
  Serial.print(",");
  Serial.print(random(100,999));
  Serial.print(",");
  Serial.print(random(100,999));
  Serial.print(",");
  Serial.print(analogRead(PT_p));
  Serial.println();
  if(ctrl == 0)
  {
    digitalWrite(pinLed, HIGH); 
    ctrl = 1;
  }
  else
  {
    digitalWrite(pinLed, LOW); 
    ctrl = 0;
  }
  
  delay(1000);
}
