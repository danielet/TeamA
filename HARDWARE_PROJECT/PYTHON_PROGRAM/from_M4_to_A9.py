import bluetooth
import serial
import string
import random
import time

bd_addr = "5C:31:3E:DF:AC:9E"

port = 1

sock=bluetooth.BluetoothSocket(bluetooth.RFCOMM)
sock.connect((bd_addr,port))

ser = serial.Serial('/dev/ttyMCC', 115200, serial.EIGHTBITS, serial.PARITY_NONE, timeout=1)
time.sleep(1)

if(ser.isOpen()) :
	print "Opened"
	ser.flushInput()

running = True
while running :
	lineread = ser.readline().rstrip()

	if(lineread !="" and lineread !="\n") :
		arrayline = lineread
		print arrayline

	sock.send(arrayline)
sock.close()

