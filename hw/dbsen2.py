#!/usr/bin/python

import pymysql.cursors
import time
import datetime
import dht11
import RPi.GPIO as GPIO
import commands
import os

# initialize GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.cleanup()

# read data using pin 4
instance = dht11.DHT11(pin=4)

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

	result = instance.read()

	if result.is_valid():
		try:	
			#print("Uploading data...")
    			with connection.cursor() as cursor:
        			# Create a new record
        			sql = "INSERT INTO `sensorData` VALUES (2, NOW(), %s);"
				sql1 = "UPDATE `sensors` SET lastSeen = NOW(), lastKnownIP = %s WHERE sensor_id = 2;"
        			cursor.execute(sql, (result.humidity))
        			cursor.execute(sql1, (commands.getoutput('hostname -I')))

    			# connection is not autocommit by default. So you must commit to save
    			# your changes.
    			connection.commit()
    		finally:
    			connection.close()
			#print("Upload succes!")
			time.sleep(120)
