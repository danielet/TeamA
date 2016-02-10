#ifndef DigitLibray_h


#define DigitLibray_h
#include <Arduino.h>
class SegmentDevice{
	

	public:
		SegmentDevice(int * pinsSegments , int * pinsDigits );
		SegmentDevice();
		void assignPin_Segment(int * pins);
		void assignPin_Digit(int * pins);
		void clearLEDs();
		void pickNumber(int number);
	private:
		int _arrayPin_segment[8];
		int _arrayPin_digit[5];
		void zero();
		void one();
		void two();
		void three();
		void four();
		void five();
		void six();
		void seven();
		void eight();
		void nine();


};


#endif