#!/usr/bin/python
import serial
import time
import random
import csv
import string
import hashlib


#BLUETOOTH LIBRARY
#import bluetooth
from bluetooth import *
#MATTEO'LIBRARY
import readFiles

def temperature(stepResolution, stepExtTemp, stepIntTemp, V20C):
	#print stepIntTemp	
	extTemp = ((stepResolution * int(stepExtTemp))-500)/10;
	intTemp = (((stepResolution * int(stepIntTemp)* 0.001)-V20C)/0.001)-20;

	temperatureValues= [extTemp, intTemp];
	label= ['External','Internal'];
	print(label);
	print(temperatureValues);
	return temperatureValues


def volt2PPB(fileValues,stepResolution, stepWE, stepAE, pollution, temperature):

	zeroVoltageWE 	= 0;
	zeroVoltageAE	= 0;
	ppbOvermV	= 0;
	n 		= 0;
	for row in fileValues.readZeroVoltageOffset():
		if(row[0] == pollution):
			zeroVoltageWE 	= int(row[1]);
			zeroVoltageAE	= int(row[2]);
			ppbOvermV	= float(row[3]);
	for row in fileValues.readTemperatureTable():
		if(row[0]==pollution):
			index = (int(round(temperature)+30)/10)+1
			n = float(row[int(index)])
#			n=1.18
			#print n	


	voltageWE 	= stepResolution * stepWE;
	voltageAE 	= stepResolution * stepAE;
	
	voltagePollution = (voltageWE - zeroVoltageWE) - n*(voltageAE - zeroVoltageAE);

	ppb	  = voltagePollution * ppbOvermV;
	return ppb

def mainLoop(fileValuesa, ser, csv_file, sock):

	timesample2SendPacket = 5
	count = timesample2SendPacket;
	
	arrayLabel=["TIMESTAMP","CO_WE", "CO_AE", "O3_WE","O3_AE","TEMP","EXT_TEMP"];
	Vref 	 	= 3300; 
	
	stepResolution 	= Vref/float(4096);
	#TEMPERATURE SENSOR
	V20C		= 0.297
	
	if(ser.isOpen()):
		print("SERIAL OPENED");
		ser.flushInput()

		csv_writer = csv.writer(csv_file)
		ctrlLoop = 1;
		while(ctrlLoop):
			ts = time.time()
			lineread = ser.readline().rstrip()
#			try:
			arrayline = lineread.split(",")
			listValue =[ts]
			for valueSensor in arrayline:
				listValue.append(valueSensor);
				#print('HERE' + str(len(listValue)))			
				if(len(listValue) ==7):
					csv_writer.writerow(listValue)
					count = count -1;
					temp = temperature(stepResolution, listValue[-1], listValue[-2], V20C)	;
				
					CO_ppb=volt2PPB(fileValues, stepResolution, float(listValue[1]), float(listValue[2]),'COA4', temp[1]);
					O3_ppb=volt2PPB(fileValues, stepResolution, float(listValue[3]), float(listValue[4]), 'O3A4', temp[1]);
					print (arrayLabel);
					print (listValue);
					print("CO ppb:" + str(CO_ppb));			
					print("O3 ppb:" + str(O3_ppb));			
					if(count == 0):

						print("SEND DATA: " + str(listValue));
						string2Send =str(CO_ppb)+","+str(O3_ppb)+","+str(temp[1]);
						sock.send(string2Send)
						count  = timesample2SendPacket;
			
			time.sleep(1)
			#except ser.SerialTimeoutException:
			#	print('Data Could Not Be Read')
#			except:
#				print "disconnect with client server"
				#ctrlLoop = 0;
#				continue


##############################################
######################################################################

if __name__ == "__main__":
	#READ FILES CONFIGURE
	pathconfig = './CONFIG_FILE';
	temperatureFile='lookupTableSensors.csv';
	zeroOffsetFile ='ZERO_A4_25000014.csv';
	fileValues = readFiles.readFiles(pathconfig , temperatureFile,zeroOffsetFile)




	uuid = "00001101-0000-1000-8000-00805F9B34FB";
	#uuid = "94f39d29-7d6d-437d-973b-fba39e49d4ee";
	#port = 1
	
	server_sock=BluetoothSocket(RFCOMM)
	server_sock.bind(("",1))
	server_sock.listen(1)
	
	port = server_sock.getsockname()[1]
	advertise_service(server_sock , "TEST", service_id= uuid);

	client_sock,address = server_sock.accept()
	print "Accepted connection from ",address

	
	
	ser = serial.Serial('/dev/ttyMCC', 115200, serial.EIGHTBITS , serial.PARITY_NONE ,timeout=1)

        randomname      = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(4))
        filename        = hashlib.md5(randomname).hexdigest() + '.csv'
        dirName         = "./OUTPUT_FILE/"
        csv_file        = open(dirName+filename, 'w')

	
	mainLoop(fileValues, ser, csv_file, client_sock) 
