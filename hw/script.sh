#!/bin/sh

nohup sudo python /home/pi/IoT/dbsen1.py &>/dev/null &
nohup sudo python /home/pi/IoT/dbsen2.py &>/dev/null &
nohup sudo python /home/pi/IoT/dbsen3.py &>/dev/null &
