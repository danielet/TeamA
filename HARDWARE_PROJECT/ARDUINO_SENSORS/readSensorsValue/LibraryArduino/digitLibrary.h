#ifndef DigitLibray_h


#define DigitLibray_h

class SegmentDevice{
	

	public:
		7SegmentDevice(int * pinsSegments , int * pinsDigits );
		assignPin_Segment(int * pins);
		assignPin_Digit(int * pins);
		void clearLEDs();
		pickNumber(int number);
	private:
		int _arrayPin_segment[7];
		int _arrayPin_digit[4];


}


#endif