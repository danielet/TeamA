#!/usr/bin/python
import serial
import time
import random
import csv
import string
import hashlib


#THREAD PART
import threading 
#import thread

#BLUETOOTH LIBRARY
from bluetooth import *
#MATTEO'LIBRARY
import readFiles

def temperature(stepResolution, stepExtTemp, stepIntTemp, V20C):
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
			if(index < 10 and index >= 0):
				n = float(row[int(index)])
			else:
				n = 1;

	voltageWE 	= stepResolution * stepWE;
	voltageAE 	= stepResolution * stepAE;
	voltagePollution = (voltageWE - zeroVoltageWE) - n*(voltageAE - zeroVoltageAE);
	ppb	  = voltagePollution * ppbOvermV;
	return ppb

def mainLoop(fileValuesa, ser, csv_file, server_sock ,client_sock, conf_values):
	
	timeing2Wait=1
	
	timesample2SendPacket = int(conf_values[-1])
	count = timesample2SendPacket;
	arrayLabel=["TIMESTAMP","CO_WE", "CO_AE", "O3_WE","O3_AE","TEMP","EXT_TEMP"];
	Vref 	 	= int(conf_values[0]); 
	
	stepResolution 	= Vref/float(conf_values[1]);
	#TEMPERATURE SENSOR
	V20C		= float(conf_values[2])
	
	if(ser.isOpen()):
		print("SERIAL OPENED");
		ser.flushInput()

		csv_writer = csv.writer(csv_file)
		ctrlLoop = 1;
		while(ctrlLoop):
			ts 		= time.time()
			lineread 	= ser.readline().rstrip()
			arrayline 	= lineread.split(",")
			listValue 	= [ts]
			for valueSensor in arrayline:
				listValue.append(valueSensor);
				if((len(listValue) ==7) and not('' in listValue)):
					temp  = temperature(stepResolution, listValue[-1], listValue[-2], V20C)	;
					CO_ppb=volt2PPB(fileValues, stepResolution, float(listValue[1]), float(listValue[2]),'COA4', temp[1]);
					O3_ppb=volt2PPB(fileValues, stepResolution, float(listValue[3]), float(listValue[4]), 'O3A4', temp[1]);
					print (arrayLabel);
					print (listValue);
					print("CO ppb:" + str(CO_ppb));			
					print("O3 ppb:" + str(O3_ppb));			
					chemicalQuantities2Print = [ts,CO_ppb, O3_ppb, temp[1]];
					csv_writer.writerow(chemicalQuantities2Print)
					count = count -1;
					if(count == 0 ):
						print("SEND DATA: " + str(listValue));
						string2Send =str(CO_ppb)+","+str(O3_ppb)+","+str(temp[1]);
						try:
							client_sock.send(string2Send)
							count  = timesample2SendPacket;
						except BluetoothError as error:
							print "SOCKET CLOSE BY APP"
							ctrlLoop = 0
							break	
			
			time.sleep(timeing2Wait)
##############################################

##############################################

def controlFromBT(client):
	ctrlLoop = 1
	while(ctrlLoop):
		print("HERE 1")
		try:
			recv1 = client.recv(1024)
			print("HERE 2 " + str(recv1))
			ctrlLoop = 0
			print("%s "% recv1)
		except BluetoothError as error:
			ctrlLoop = 0
			break
##############################################

##############################################
def waitBluetoothConnection(fileValues):

	uuid = "00001101-0000-1000-8000-00805F9B34FB";

	while(1):
		conf_values	= fileValues.readConfiguration();	
		server_sock	= BluetoothSocket(RFCOMM)
		server_sock.bind(("",1))
		server_sock.listen(1)
	
		port 		= server_sock.getsockname()[1]
		advertise_service(server_sock , "TEST", service_id= uuid);
		print("WAIT BLUETOOTH CONNECTION");
		client_sock,address = server_sock.accept()
		print "Accepted connection from ",address

		ser 		= serial.Serial('/dev/ttyMCC', 115200, serial.EIGHTBITS , serial.PARITY_NONE ,timeout=1)

        	randomname      = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(4))
        	filename        = hashlib.md5(randomname).hexdigest() + '.csv'
        	dirName         = "./OUTPUT_FILE/"
        	csv_file        = open(dirName+filename, 'w')

		threads=[]	
		#mainLoop(fileValues, ser, csv_file, server_sock ,client_sock, conf_values) 
		t=threading.Thread(target=mainLoop,args=(fileValues, ser, csv_file, server_sock ,client_sock, conf_values))
		threads.append(t)
		t.start()
		t=threading.Thread(target=controlFromBT, args=(client_sock,))
		threads.append(t)
		t.start()
	
		for tt in threads:
			tt.join()
		
		ser.close()
		client_sock.close()
		csv_file.close()
		server_sock.close()
######################################################################

if __name__ == "__main__":
	#READ FILES CONFIGURE
	pathconfig 	= './CONFIG_FILE';
	temperatureFile	= 'lookupTableSensors.csv';
	zeroOffsetFile 	= 'ZERO_A4_25000014.csv';
	MAIN_FILE_CONF 	= 'MAIN_CONF.csv'; 
	fileValues 	= readFiles.readFiles(pathconfig , temperatureFile,zeroOffsetFile, MAIN_FILE_CONF)
	waitBluetoothConnection(fileValues)
	
