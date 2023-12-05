import datetime
import paho.mqtt.client as mqtt
import os
import json
import configparser

# Lecture du fichier de configuration
config = configparser.ConfigParser()
config.read("config.ini")

temperature_max = config.getfloat('Seuils', 'temperature_max')
humidity_max = config.getfloat('Seuils', 'humidity_max')
co2_max = config.getfloat('Seuils', 'co2_max')
activity_max = config.getfloat('Seuils', 'activity_max')
temperature_min = config.getfloat('Seuils', 'temperature_min')
humidity_min = config.getfloat('Seuils', 'humidity_min')
co2_min = config.getfloat('Seuils', 'co2_min')
activity_min = config.getfloat('Seuils', 'activity_min')
frequence = config.getfloat('Frequences', 'frequence')
salle_config = config['Salles']['salle']

# Ecriture des données dans le fichier historique.json
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
        os.write(fDest, b'",\n\t\t\t"Temperature" : "')
        os.write(fDest, str.encode(donneesHist[date]["Temperature"]))
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
    client.subscribe(f"AM107/by-room/{salle_config}/data")

# Réception des données
def on_message(client, userdata, msg):

    message = msg.payload
    data = json.loads(message)
    fDest = os.open('donnees.json', os.O_WRONLY | os.O_CREAT | os.O_TRUNC)
    salleActuelle = data[1]["room"]

    if "room" in data[1]:
        if salle_config == "+" or salle_config == salleActuelle :
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
            os.write(fDest, b'",\n\t\t\t"Temperature" : "')
            os.write(fDest, str.encode(str(temp)))
            os.write(fDest, b'"\n\t\t}')
            os.write(fDest, b'\n\t}')
            os.write(fDest, b'\n}')
            os.close(fDest)

            donneesHist = {
                datetime.datetime.now().strftime("%d/%m/%Y, %H:%M:%S"): {
                    "Humidite": str(hum),
                    "CO2": str(co2),
                    "Activite": str(act),
                    "Temperature": str(temp)
                }
            }

            print ("\n \n")
            print("Salle : ", data[1]["room"])
            print("Température : ", data[0]["temperature"])
            print("Humidité : ", data[0]["humidity"])
            print("CO2 : ", data[0]["co2"])
            print("Activité : ", data[0]["activity"])

            write_log(salle, donneesHist)
        

        if data[0]["temperature"] > temperature_max:
            ajouter_alerte(salle, "temperature_max", "alerte.json")
        if data[0]["humidity"] > humidity_max:
            ajouter_alerte(salle, "humidity_max", "alerte.json")
        if data[0]["co2"] > co2_max:
            ajouter_alerte(salle, "co2", "alerte.json")
        if data[0]["activity"] > activity_max:
            ajouter_alerte(salle, "activity_max", "alerte.json")
        if data[0]["temperature"] < temperature_min:
            ajouter_alerte(salle, "temperature_min", "alerte.json")
        if data[0]["humidity"] < humidity_min:
            ajouter_alerte(salle, "humidity_min", "alerte.json")
        if data[0]["co2"] < co2_min:
            ajouter_alerte(salle, "co2_min", "alerte.json")
        if data[0]["activity"] > activity_min:
            ajouter_alerte(salle, "activity_min", "alerte.json")


def ajouter_alerte(salle, type_alerte, fichier_alerte):
    date_courante = datetime.datetime.now().strftime('%d/%m/%Y, %H:%M:%S')
    alerte = {
        "Date": date_courante,
        "Salle": salle,
        "Type": type_alerte,
        "Message": f"Le seuil maximal de {type_alerte} a été dépassé."
    }

    try:
        fichier_alerte_write = os.open(fichier_alerte, os.O_WRONLY | os.O_CREAT | os.O_APPEND)

        try:
            fichier_alerte_read = os.open(fichier_alerte, os.O_RDONLY)
            alertes_existantes = json.load(os.fdopen(fichier_alerte_read, 'r'))
        except (json.decoder.JSONDecodeError, FileNotFoundError):
            alertes_existantes = []

        alertes_existantes.insert(0, alerte.copy())

        os.ftruncate(fichier_alerte_write, 0)
        os.write(fichier_alerte_write, json.dumps(alertes_existantes, indent=2).encode())

        os.close(fichier_alerte_write)

    except Exception as e:
        print(f"Erreur lors de la création du fichier d'alerte : {e}")


client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("chirpstack.iut-blagnac.fr", 1883, 60)

client.loop_forever()