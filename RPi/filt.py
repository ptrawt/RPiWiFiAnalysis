import datetime
import glob
import os
import mysql.connector
from mysql.connector import Error
now = datetime.datetime.now()

f = open("multicastAddress.txt", 'r')
lines = f.readlines()
multiAddr = []
for line in lines:
	multiAddr.append(line.strip())
f.close()


newRSSI = max(glob.iglob('Capfile/RSSI/*.csv'), key=os.path.getctime)
f = open(newRSSI, 'r')
lines = f.readlines()
lines = lines[2:]
stations = []
for line in lines:
	words = line.split(',')
	if(words[0] == 'Station MAC'):
		break
	if len(words) >= 13 and int(words[4]) > 0:
		if len(words[13]) is not 1:
			stations.append({"bssid": words[0].lstrip().lower()\
			, "essid": words[13].lstrip(), "rssi": words[8].lstrip()\
			, "traffic": 0, "user": [], "channel":words[3].lstrip()})
		else:
			stations.append({"bssid": words[0].lstrip().lower()\
			, "essid": "[Hidden]", "rssi": words[8].lstrip()\
			, "traffic": 0, "user": [], "channel":words[3].lstrip()})
f.close()

newMAC = max(glob.iglob('Capfile/Traffic/*.txt'), key=os.path.getctime)
f = open(newMAC, "r")
lines = f.readlines()
data = []
for i in lines:
	words = i.split()
	if len(words) == 4 and words[2] not in multiAddr:
		data.append({"source":words[0], "dest":words[1]\
		, "traffic": int(words[2]), "ap": words[3]})
f.close()

for i in data:
	for j in stations:
		if i["ap"] == j["bssid"]:
			j["traffic"] += i["traffic"]
			if i["source"] not in j["user"]:
				j["user"].append(i["source"])

filename = "Capfile/Output/"+now.strftime("%Y-%m-%d %H-%M")+".txt"
f = open(filename, "w")
f.write(now.strftime("%Y-%m-%d %H:%M")+":00\n")
for i in stations:
	f.write(str(i))
	f.write("\n")
f.close()

try:
	host =""
	database = ""
	user = ""
	password = ""
	f = open("config.txt","r")
	for i in f:
		tmp = i.split(' ')
		if tmp[0] == 'host':
			host = tmp[2]
		if tmp[0] == 'database':
			database = tmp[2]
		if tmp[0] == 'user':
			user = tmp[2]
		if tmp[0] == 'password':
			password = tmp[2]
	conn = mysql.connector.connect(host=host,database=database,user=user,password=password)
    if conn.is_connected():
		cursor = conn.cursor()
		for i in stations:
			query = "INSERT INTO data(time,bssid, ssid, user, channel,frequency\
				,rssi,data) \
				VALUES ('%s', '%s','%s', '%d', '%d','%s','%d', '%d' )" % \
				(now.strftime("%Y-%m-%d %H:%M")+":00",i["bssid"],i["essid"]\
				,int(len(i["user"])),int(i["channel"]),'2.4',int(i["rssi"]),\
				int(i["traffic"]))
			cursor.execute(query)
			conn.commit()
		cursor.close()
		conn.close()
except Error as e:
    print(e)
