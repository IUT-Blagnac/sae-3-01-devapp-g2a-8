import datetime
import paho.mqtt.client as mqtt
import os
import json

#The callback for when the client receives a CONNACK response from the server.

def write_log(nomSalle, donneesHist):

    if not os.path.exists("historique.json"):
        date = list(donneesHist.keys())[0]

        fDest = os.open('historique.json', os.O_RDWR | os.O_CREAT | os.O_APPEND)
        os.write(fDest, b'{\n\t"')
        os.write(fDest, str.encode(nomSalle))
        os.write(fDest, b'": {\n')
        os.write(fDest, b'\t\t"')
        os.write(fDest, str.encode(date))
        os.write(fDest, b'": {\n')
        os.write(fDest, b'\t\t\t"Humidite": "')
        os.write(fDest, str.encode(donneesHist[date]["Humidite"]))
        os.write(fDest, b'",\n\t\t\t"CO2" : "')
        os.write(fDest, str.encode(donneesHist[date]["CO2"]))
        os.write(fDest, b'",\n\t\t\t"Activite" : "')
        os.write(fDest, str.encode(donneesHist[date]["Activite"]))
        os.write(fDest, b'",\n\t\t\t"Alerte" : "')
        os.write(fDest, str.encode(donneesHist[date]["Alerte"]))
        os.write(fDest, b'"\n\t\t}')
        os.write(fDest, b'\n\t}')
        os.write(fDest, b'\n}')
        os.close(fDest)

    else:
        with open('historique.json', 'r') as fichier_json:
            donnees_existantes = json.load(fichier_json)

        if len(donnees_existantes) == 0:
            donneesNvSalle = {nomSalle: donneesHist}
            donnees_existantes.update(donneesNvSalle)

        else:
            existe = False
            for cle, val in donnees_existantes.items():
                if cle == nomSalle:
                    donnees_existantes[nomSalle].update(donneesHist)
                    existe = True
                    break

            if not existe:
                donneesNvSalle = {nomSalle: donneesHist}
                donnees_existantes.update(donneesNvSalle)

        with open('historique.json', 'w') as fichier_json:
            json.dump(donnees_existantes, fichier_json, indent=4)

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

    if "room" in data[1]:
        salle = data[1]["room"]
        temp = data[0]["temperature"]
        hum = data[0]["humidity"]
        co2 = data[0]["co2"]
        act = data[0]["activity"]

        os.write(fDest, b'{\n\t"')
        os.write(fDest, str.encode(salle))
        os.write(fDest, b'": {\n')
        os.write(fDest, b'\t\t"')
        os.write(fDest, str.encode(datetime.datetime.now().strftime("%d/%m/%Y, %H:%M:%S")))
        os.write(fDest, b'": {\n')
        os.write(fDest, b'\t\t\t"Humidite": "')
        os.write(fDest, str.encode(str(hum)))
        os.write(fDest, b'",\n\t\t\t"CO2" : "')
        os.write(fDest, str.encode(str(co2)))
        os.write(fDest, b'",\n\t\t\t"Activite" : "')
        os.write(fDest, str.encode(str(act)))
        os.write(fDest, b'",\n\t\t\t"Alerte" : "')
        os.write(fDest, b'non')
        os.write(fDest, b'"\n\t\t}')
        os.write(fDest, b'\n\t}')
        os.write(fDest, b'\n}')
        os.close(fDest)

        donneesHist = {
            datetime.datetime.now().strftime("%d/%m/%Y, %H:%M:%S"): {
                "Humidite": str(hum),
                "CO2": str(co2),
                "Activite": str(act),
                "Alerte": "non"
            }
        }

        print ("\n \n")
        print("Salle : ", data[1]["room"])
        print("Température : ", data[0]["temperature"])
        print("Humidité : ", data[0]["humidity"])
        print("CO2 : ", data[0]["co2"])
        print("Activité : ", data[0]["activity"])

        write_log(salle, donneesHist)

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("chirpstack.iut-blagnac.fr", 1883, 60)

client.loop_forever()