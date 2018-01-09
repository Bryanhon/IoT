
# Exam Project
The exam project needs :
* at least 2 hardware sensors on at least 1 standalone device that collect relatable information and send this information on different intervals per sensor (e.g. temperature once every 5 minutes, light value once every 2 minutes) to the webserver (i.e. collector page). At least one of the sensors collects value information (not just boolean on/off style of information). (You bring the device and demonstrate it for 2/20)
  -  Alternatively, you create a software solution that automaticly collects and generates useful information and sends this from a 24/7 running device on specific intervals (to fill the database).
* one collector page on the webserver that will registrate the information of the 2 different sensors in one MySQL table that at minimum registrates timestamp, value and sensorID. The different possible sensors are in another table that contains ID, name, last-known-timestamp and last-known-external-IP. (You show and explain the code for 4/20, the database needs at least more than 1 week of usefull information)
* "easy for the eyes" view page on the webserver that will generate the registrated information in a graph using jQuery. It contains at least the 2 information streams (i.e. lines) which can be dynamicly added or removed (using ajax). The graph is using the correct axis and combines the 2 information streams that is usefull to interprete (e.g. the 2 datalines should cross somewhere). It must be at least possible to filter the graph to only show a specific time periode (e.g. last 24h, last week). (You show and explain the code for 6/20, usefull collected information must be visible)

The additional points can be collected with self providing extra's (e.g. beautifull HTML / CSS, PHP object oriented style, security, more sensors, different hardware collectors, different graph tools, dynamic updatable table view, user registration, advanced options, ... ) Bottom line, everything on which you have invested time and did not get gradded. (You show me what you provided additionally and how it works and why you added it, this will be weighted at the end for the final 8/20)

---

## 2 Hardware sensors

DHT11 and LDR was used. 

```
DHT11 humidity measured every 2min.
DHT11 temperature measured every 5min.
LDR resistance measured every 3min.
```

## Uploading data to the database

Connection between the raspberry pi and the database is made with a library included in the scripts.

```python
import pymysql.cursors

connection = pymysql.connect(host="NOPE",
                             user='NOPE',
                             password='NOPE',
                             db='NOPE',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
                             
sql = "INSERT INTO `sensorData` VALUES (3, NOW(), %s);"
cursor.execute(sql, (value))
connection.commit()
connection.close()
```

## Easy on the eyes

Graph is pretty imo.

## PHP object oriented style

See PHP files.

## Secure

Made sure there is no possibilty for an SQL injection.

## Different Graph tool

Chart.js was used and had to be learned.
