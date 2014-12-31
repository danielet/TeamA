import csv



class readFiles:
	fileTemp		= ''
	fileOffset 		= ''
	fileConfiguration 	= ''
	def __init__(self, pathname, filenameTemperature, filenameOffset, filenameConfiguration ):
		self.fileTemp 		=  pathname+'/'+filenameTemperature;
		self.fileOffset 	=  pathname+'/'+filenameOffset;
		self.fileConfiguration 	=  pathname+'/'+filenameConfiguration;

	def readTemperatureTable(self):
		#print self.fileOffset
		with open(self.fileTemp, 'rb') as csvfile:
			tempTable = csv.reader(csvfile, delimiter=',')
			table=[]
			for row in tempTable:
				table.append(row)
			return table


	def readZeroVoltageOffset(self):
		with open(self.fileOffset, 'rb') as csvfile:
			zeroValues = csv.reader(csvfile, delimiter=',')
			table=[]
			for row in zeroValues:
				table.append(row)
			return table

	def readConfiguration(self):
		with open(self.fileConfiguration, 'rb') as csvfile:
			confValues = csv.reader(csvfile, delimiter=',')
			count = 0
			for row in confValues:
				if(count == 1):
					 return row
				count = count + 1;
