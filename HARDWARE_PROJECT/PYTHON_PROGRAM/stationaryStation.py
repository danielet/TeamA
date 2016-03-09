#!/usr/bin/python

#PUT LICENSE LGPL


import serial
import datetime
import time
import random
import csv
import string
import hashlib

import urllib
import urllib2
import json

import socket
import fcntl
import struct
#MATTEO'LIBRARY
import readFiles

import random
#
#import signal
def getHwAddr(ifname):
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    info = fcntl.ioctl(s.fileno(), 0x8927,  struct.pack('256s', ifname[:15]))
    return ':'.join(['%02x' % ord(char) for char in info[18:24]])

def temperature(stepResolution, stepIntTemp, V20C):
	intTemp = (((((4096)/float(4096/2)/1000) * int(stepIntTemp))-V20C)*1000);
	temperatureValues= intTemp;
	return temperatureValues

def PM25Value(analogvalue):

	analogtotal = (analogvalue*(4096))/(float(4096/2)*1000);
    	hppcf = (240.0*pow(analogtotal,6) - 2491.3*pow(analogtotal,5) + 9448.7*pow(analogtotal,4) - 14840.0*pow(analogtotal,3) + 10684.0*pow(analogtotal,2) + 2211.8*(analogtotal) + 7.9623);
    	ugm3 = .518 + .00274 * hppcf;
	return ugm3

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
	return round(ppb,3)

def mainLoop(fileValuesa, ser, csv_file,  conf_values, userid ,mac_address, URL_REAL):

	timeinterval=1
	arrayLabel=["TIMESTAMP","CO_WE", "CO_AE", "O3_WE","O3_AE","NO2_WE", "NO2_AE","INT_TEMP"];
	Vref 	 		= int(conf_values[0]); 
	stepResolution 		= Vref/float(conf_values[1]);
	#TEMPERATURE SENSOR
	V20C			= float(conf_values[2])
	timesample2SendPacket 	= int(conf_values[-1])
	count 			= timesample2SendPacket;


	lat = 32.882570
	lng = -117.234609
	
	if(ser.isOpen()):
		print("SERIAL OPENED");
		ser.flushInput()

		csv_writer = csv.writer(csv_file)

		ctrlLoopTmp = 1;
		while(ctrlLoopTmp):
			ser.write("1");
			lineread 	= ser.readline().rstrip()
			arrayline 	= lineread.split(",")
			ts 		= time.time()
			listValue 	= [ts]
			timeFormatted = datetime.datetime.fromtimestamp(int(ts)).strftime('%Y/%m/%d %H:%M:%S')
			for valueSensor in arrayline:
				listValue.append(valueSensor);
			if((len(listValue) == 9) and not('' in listValue)):
				temp  = temperature(stepResolution, listValue[-1], V20C);
				CO_ppb=abs(volt2PPB(fileValues, stepResolution, float(listValue[1]), float(listValue[2]),'COA4', temp));
				NO2_ppb=abs(volt2PPB(fileValues, stepResolution, float(listValue[5]), float(listValue[6]), 'NO2A4', temp));
				NO2_O3_ppb=abs(volt2PPB(fileValues, stepResolution, float(listValue[3]), float(listValue[4]), 'O3A4', temp));
				O3_ppb = abs(NO2_O3_ppb - NO2_ppb)
				#SO2_ppb=volt2PPB(fileValues, stepResolution, 1024, 1024, 'SO2A4', temp);
				SO2_ppb=random.randint(0, 20)
				PM25=PM25Value(float(listValue[-2]));
				PM10=1;
				print (arrayLabel);
				print (listValue);
				print("CO ppb:" + str(round(CO_ppb, 3)));			
				print("O3 ppb:" + str(round(O3_ppb,3)));			
				print("NO2 ppb:" + str(round(NO2_ppb,3)));			
				print("PM2.5 u/m3:" + str(round(PM25,3)));			
				print("TEMP:" + str(temp));			
				chemicalQuantities2Print = [ts,CO_ppb, O3_ppb, NO2_ppb,PM25 ,temp];
				#IF BT CONNECTION OPEN THEN WRITE	
				csv_writer.writerow(chemicalQuantities2Print)
				count = count -1;
				if(count == 0 ):
					string2Send = str(CO_ppb)+","+str(O3_ppb)+","+str(SO2_ppb)+","+str(NO2_ppb)+","+str(PM25)+","+str(PM10)+","+str(temp);
					print("SEND DATA: " + string2Send);
					values = {'user_id' : userid , 'mac' : mac_address, 'time': timeFormatted , 'lat': lat , 'lng' : lng,
						'co': CO_ppb, 'so2': SO2_ppb, 'no2': NO2_ppb, 'o3' : O3_ppb, 'temp' : temp, 'pm2d5': PM25, 'hb':0}
					req = urllib2.Request(URL_REAL, json.dumps(values), headers={'Content-type': 'application/json', 'Accept': 'application/json'})
					response = urllib2.urlopen(req)
					html = response.read()
					response.close() 
					count  = timesample2SendPacket;
			
			time.sleep(timeinterval)
	else:
		print("SERIAL ERROR")
	print("OUT FROM MAIN")


def startStation(fileValues, userid ,mac_address, URL_REAL):

	#ser 		= serial.Serial('/dev/ttyMCC', 115200, serial.EIGHTBITS , serial.PARITY_NONE ,timeout=0)
	ser 	= serial.Serial('/dev/ttyMCC', 115200,timeout=0)
	print "Wait"
	time.sleep(1)
	conf_values	= fileValues.readConfiguration();	
	randomname      = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(4))
        filename        = hashlib.md5(randomname).hexdigest() + '.csv'
        dirName         = "/home/udooer/TeamA/HARDWARE_PROJECT/PYTHON_PROGRAM/OUTPUT_FILE/"
        csv_file        = open(dirName+filename, 'w')

	mainLoop(fileValues, ser, csv_file, conf_values, userid ,mac_address, URL_REAL)
	csv_file.close()
	ser.close()
######################################################################

if __name__ == "__main__":
	#READ FILES CONFIGURE
	pathconfig 	= '/home/udooer/TeamA/HARDWARE_PROJECT/PYTHON_PROGRAM/CONFIG_FILE';
	temperatureFile	= 'lookupTableSensors.csv';
	zeroOffsetFile 	= 'ZERO_A4_25000015.csv';
	MAIN_FILE_CONF 	= 'MAIN_CONF.csv'; 
	fileValues 	= readFiles.readFiles(pathconfig , temperatureFile,zeroOffsetFile, MAIN_FILE_CONF)
	userid 		= 'calit2@eng.ucsd.edu'
	pswd 		= 'ucsd'
	ts 		= time.time()
	timesession 	= datetime.datetime.fromtimestamp(int(ts)).strftime('%Y/%m/%d %H:%M:%S')
	
	mac_address=getHwAddr('wlan0')
	#1. LOGIN
	URL_LOGIN = 'http://airpollution.calit2.net/TeamC/php/receive_data/receive_insert_device.php'
	query_args 	= { 'data':userid+','+pswd +','+mac_address+',UDOO,0,0,0' }
	data 		= urllib.urlencode(query_args)

	request		= urllib2.Request(URL_LOGIN, data) 
	response = urllib2.urlopen(request)
	html = response.read()
	print html
	response.close()  # best practice to close the file
	#2. START SESSION	
	URL_SESSION 	='http://airpollution.calit2.net/TeamC/php/receive_data/receive_session_start.php'

	values = {'uid' : userid  , 'mac' : mac_address, 'time': timesession, 'smac' :'EC:11:27:6F:BB:54'}
	req = urllib2.Request(URL_SESSION, json.dumps(values), headers={'Content-type': 'application/json', 'Accept': 'application/json'})
	response = urllib2.urlopen(req)
	html = response.read()
	response.close() 
	print html

	URL_REAL 	='http://airpollution.calit2.net/TeamC/php/receive_data/receive_realtime_data.php'
	startStation(fileValues, userid ,mac_address, URL_REAL)	

