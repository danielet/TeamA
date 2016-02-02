import serial
import time
import random
import csv
import string
import hashlib

ser = serial.Serial('/dev/ttyMCC', 115200, serial.EIGHTBITS , serial.PARITY_NONE ,timeout=1)
ranstr = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(4))
string = ranstr
filename = hashlib.md5(string).hexdigest() + '.csv'

csv_file = open(filename, 'w')
time.sleep(1)
if(ser.isOpen()):
	print("OPENED");
	ser.flushInput()
csv_writer = csv.writer(csv_file)

while(1):
	ts = time.time()
	lineread = ser.readline().rstrip()
	try:
		arrayline = lineread.split(",")
		print arrayline
		tt = (ts, arrayline)
		csv_writer.writerow(tt)
		time.sleep(1)
	except ser.SerialTimeoutException:
		print('Data Could Not Be Read')
		time.sleep(1)

