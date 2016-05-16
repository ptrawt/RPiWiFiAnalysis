#!/bin/bash

line=$(head -n 1 'config.txt')
line=$(grep -o "[0-9]" <<< "$line")
declare -i intTime
intTime=1
intTime=(intTime*60)-15

cd /home/pi/Project
while :
do
airmon-ng start wlan0
cd Capfile/Traffic
tshark -S -l -i wlan0mon -a duration:$intTime -R 'wlan.fc.type eq 2' -T fields -e wlan.sa -e wlan.da -e frame.len -e wlan.ta > mac.txt
cd ../RSSI
airodump-ng -i wlan0mon -w capRSSI -o csv &
sleep 10
killall airodump-ng &
clear
airmon-ng stop wlan0mon
ifdown --force wlan0
ifup wlan0
sleep 35
cd /home/pi/Project
python filt.py
done &
