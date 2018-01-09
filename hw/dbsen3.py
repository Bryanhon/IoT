#!/usr/bin/python

import pymysql.cursors
import time
import datetime
import RPi.GPIO as GPIO
import commands
import os

# initialize GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.cleanup()

pin = 12

def rc_time (pin):
	count = 0

	GPIO.setup(pin, GPIO.OUT)
	GPIO.output(pin, GPIO.LOW)
	time.sleep(0.1)

	GPIO.setup(pin, GPIO.IN)

	while (GPIO.input(pin) == GPIO.LOW):
		count += 1

	return count

while True:
	os.system("clear")
	#print("Last attempt: " + str(datetime.datetime.now()))

	# Connect to the database
	connection = pymysql.connect(host="NOPE",
                             user='NOPE',
                             password='NOPE',
                             db='NOPE',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)

	try:	
		#print("Uploading data...")
    		with connection.cursor() as cursor:
			print(rc_time(pin))
			if (rc_time(pin) < 1000):
				value = 100
			elif (rc_time(pin) > 1000 and rc_time(pin) < 8000):
				value = 50
			else:
				value = 5
	
        		# Create a new record
        		sql = "INSERT INTO `sensorData` VALUES (3, NOW(), %s);"
			sql1 = "UPDATE `sensors` SET lastSeen = NOW(), lastKnownIP = %s WHERE sensor_id = 3;"
			cursor.execute(sql, (value))
			cursor.execute(sql1, (commands.getoutput('hostname -I')))
    		# connection is not autocommit by default. So you must commit to save
    		# your changes.
    		connection.commit()
    	finally:
    		connection.close()
		#print("Upload succes!")
		time.sleep(180)
