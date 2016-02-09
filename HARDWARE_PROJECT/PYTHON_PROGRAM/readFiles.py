import csv



class readFiles:
	fileTemp 	= ''
	fileOffset = ''
	def __init__(self, pathname, filenameTemperature, filenameOffset ):
		self.fileTemp =  pathname+'/'+filenameTemperature;
		self.fileOffset =  pathname+'/'+filenameOffset;

	def readTemperatureTable(self):
		print self.fileOffset
		with open(self.fileTemp, 'rb') as csvfile:
			tempTable = csv.reader(csvfile, delimiter=',')
			#return tempTable
			table={}
			for row in zeroValues:
				table.append(row)
			#	print row
			return table


	def readZeroVoltageOffset(self):
		with open(self.fileOffset, 'rb') as csvfile:
			zeroValues = csv.reader(csvfile, delimiter=',')
			table=[]
			for row in zeroValues:
				table.append(row)
				print row
			return table

