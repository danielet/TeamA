////DIGIT PART
////I HAVE TO CREATE A FUNCTION
void pickNumber(int x){
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
void clearLEDs()
{  
  digitalWrite(  2, LOW); // A
  digitalWrite(  3, LOW); // B
  digitalWrite(  4, LOW); // C
  digitalWrite(  5, LOW); // D
  digitalWrite(  6, LOW); // E
  digitalWrite(  7, LOW); // F
  digitalWrite(  8, LOW); // G
}

void one()
{
  digitalWrite( pinSegmentA, LOW);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, LOW);
  digitalWrite( pinSegmentE, LOW);
  digitalWrite( pinSegmentF, LOW);
  digitalWrite( pinSegmentG, LOW);
}

void two()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, LOW);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, HIGH);
  digitalWrite( pinSegmentF, LOW);
  digitalWrite( pinSegmentG, HIGH);
}

void three()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, LOW);
  digitalWrite( pinSegmentF, LOW);
  digitalWrite( pinSegmentG, HIGH);
}

void four()
{
  digitalWrite( pinSegmentA, LOW);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, LOW);
  digitalWrite( pinSegmentE, LOW);
  digitalWrite( pinSegmentF, HIGH);
  digitalWrite( pinSegmentG, HIGH);
}

void five()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, LOW);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, LOW);
  digitalWrite( pinSegmentF, HIGH);
  digitalWrite( pinSegmentG, HIGH);
}

void six()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, LOW);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, HIGH);
  digitalWrite( pinSegmentF, HIGH);
  digitalWrite( pinSegmentG, HIGH);
}

void seven()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, LOW);
  digitalWrite( pinSegmentE, LOW);
  digitalWrite( pinSegmentF, LOW);
  digitalWrite( pinSegmentG, LOW);
}

void eight()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, HIGH);
  digitalWrite( pinSegmentF, HIGH);
  digitalWrite( pinSegmentG, HIGH);
}

void nine()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, LOW);
  digitalWrite( pinSegmentF, HIGH);
  digitalWrite( pinSegmentG, HIGH);
}

void zero()
{
  digitalWrite( pinSegmentA, HIGH);
  digitalWrite( pinSegmentB, HIGH);
  digitalWrite( pinSegmentC, HIGH);
  digitalWrite( pinSegmentD, HIGH);
  digitalWrite( pinSegmentE, HIGH);
  digitalWrite( pinSegmentF, HIGH);
  digitalWrite( pinSegmentG, LOW);
}