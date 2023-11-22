import paho.mqtt.client as mqtt
import os
import json

#The callback for when the client receives a CONNACK response from the server.
def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))

    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("AM107/by-room/+/data")

#The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):

    message = msg.payload
    data = json.loads(message) 
    fDest = os.open('donnees.json', os.O_WRONLY | os.O_CREAT | os.O_TRUNC)

    salle = data[1]["room"]
    temp = data[0]["temperature"]
    hum = data[0]["humidity"]
    co2 = data[0]["co2"]
    act = data[0]["activity"]

    os.write(fDest, b'{\n')
    os.write(fDest, b'\t"Salle" : "')
    os.write(fDest, str.encode(salle))
    os.write(fDest, b'"')
    os.write(fDest, b',\n\t"Temperature" : ')
    os.write(fDest, str.encode(str(temp)))
    os.write(fDest, b',\n\t"Humidite" : ')
    os.write(fDest, str.encode(str(hum)))
    os.write(fDest, b',\n\t"CO2" : ')
    os.write(fDest, str.encode(str(co2)))
    os.write(fDest, b',\n\t"Activite" : ')
    os.write(fDest, str.encode(str(act)))
    os.write(fDest, b'\n}')

    print ("\n \n")
    print("Salle : ", data[1]["room"])
    print("Température : ", data[0]["temperature"])
    print("Humidité : ", data[0]["humidity"])
    print("CO2 : ", data[0]["co2"])
    print("Activité : ", data[0]["activity"])



client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("chirpstack.iut-blagnac.fr", 1883, 60)

client.loop_forever()