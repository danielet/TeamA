import bluetooth


target_address = None

nearby_devices = bluetooth.discover_devices()

for bdaddr in nearby_devices:
	print bdaddr
	target_address = bdaddr

	if target_address == "EC:11:27:6F:BB:54":
		print "connect"
		break


