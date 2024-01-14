import datetime
import paho.mqtt.client as mqtt
import os
import json
import configparser
from threading import Timer

# Données globales
donneesHist = []
config = configparser.ConfigParser()
temperature_max = config
humidity_max = config
co2_max = config
activity_max = config
temperature_min = config
humidity_min = config
co2_min = config
activity_min = config
frequenceDonnees = config
salle_config = config
frequenceConfig = 15.0
dictBoolDonnees = {}


# Lecture du fichier configuration
def read_config():
    global temperature_max
    global humidity_max
    global co2_max
    global activity_max
    global temperature_min
    global humidity_min
    global co2_min
    global activity_min
    global frequenceDonnees
    global salle_config
    global dictBoolDonnees

    config.read("config.ini")

    temperature_max = config.getfloat('Seuils', 'temperature_max')
    humidity_max = config.getfloat('Seuils', 'humidity_max')
    co2_max = config.getfloat('Seuils', 'co2_max')
    activity_max = config.getfloat('Seuils', 'activity_max')
    temperature_min = config.getfloat('Seuils', 'temperature_min')
    humidity_min = config.getfloat('Seuils', 'humidity_min')
    co2_min = config.getfloat('Seuils', 'co2_min')
    activity_min = config.getfloat('Seuils', 'activity_min')
    frequenceDonnees = config.getfloat('Frequences', 'frequence')
    salle_config = list(config['Salles']['salle'].split(","))
    dictBoolDonnees = {"Activite": config.getboolean('Donnees', 'activity'),
                       "CO2": config.getboolean('Donnees', 'co2'),
                       "Temperature": config.getboolean('Donnees', 'temperature'),
                       "Humidite": config.getboolean('Donnees', 'humidity')
                       }

    # Minuteur pour relancer read_config dans un temps défini
    minuteurConfig = Timer(frequenceConfig, read_config)
    minuteurConfig.start()


# Ecriture des données dans le fichier historique.json
def write_log():
    global donneesHist

    for data in donneesHist:
        salle = data["Salle"]
        date = data["Date"]
        temp = data["Temperature"]
        hum = data["Humidite"]
        co2 = data["CO2"]
        act = data["Activite"]
        donnees = {date: {"Humidite": hum, "Temperature": temp, "CO2": co2, "Activite": act}}

        # Création du fichier historique s'il n'existe pas
        if not os.path.exists("historique.json"):

            fDest = os.open('historique.json', os.O_RDWR | os.O_CREAT | os.O_APPEND)
            os.write(fDest, b'{\n\t"')
            os.write(fDest, str.encode(salle))
            os.write(fDest, b'": {\n')
            os.write(fDest, b'\t\t"')
            os.write(fDest, str.encode(date))
            os.write(fDest, b'": {\n')
            os.write(fDest, b'\t\t\t"Humidite": "')
            os.write(fDest, str.encode(hum))
            os.write(fDest, b'",\n\t\t\t"CO2" : "')
            os.write(fDest, str.encode(co2))
            os.write(fDest, b'",\n\t\t\t"Activite" : "')
            os.write(fDest, str.encode(act))
            os.write(fDest, b'",\n\t\t\t"Temperature" : "')
            os.write(fDest, str.encode(temp))
            os.write(fDest, b'"\n\t\t}')
            os.write(fDest, b'\n\t}')
            os.write(fDest, b'\n}')
            os.close(fDest)

        # Ajout des données dans le fichier historique s'il existe
        else:
            with open('historique.json', 'r') as fichier_json:
                donnees_existantes = json.load(fichier_json)

            if len(donnees_existantes) == 0:
                donneesNvSalle = {salle: donnees}
                donnees_existantes.update(donneesNvSalle)

            else:
                existe = False
                for cle, val in donnees_existantes.items():
                    if cle == salle:
                        donnees_existantes[salle].update(donnees)
                        existe = True
                        break

                if not existe:
                    donneesNvSalle = {salle: donnees}
                    donnees_existantes.update(donneesNvSalle)

            with open('historique.json', 'w') as fichier_json:
                json.dump(donnees_existantes, fichier_json, indent=4)

    donneesHist = []

    # Minuteur pour relancer write_log dans un temps défini
    minuteurHistorique = Timer(frequenceDonnees, write_log)
    minuteurHistorique.start()

# Instructions à suivre lors de la connexion
def on_connect(client, userdata, flags, rc):
    print("Connected with result code " + str(rc))
    client.subscribe(f"AM107/by-room/+/data")


# Instructions à suivre lors de la réception de données
def on_message(client, userdata, msg):
    global donneesHist
    global dictBoolDonnees
    message = msg.payload
    data = json.loads(message)
    if "room" in data[1]:

        salleActuelle = data[1]["room"]
        if salle_config == "+" or salleActuelle in salle_config:

            fDest = os.open('donnees.json', os.O_WRONLY | os.O_CREAT | os.O_TRUNC)

            salle = data[1]["room"]
            if dictBoolDonnees["Temperature"] is True:
                temp = data[0]["temperature"]
            else:
                temp = ""
            if dictBoolDonnees["Humidite"] is True:
                hum = data[0]["humidity"]
            else:
                hum = ""
            if dictBoolDonnees["CO2"] is True:
                co2 = data[0]["co2"]
            else:
                co2 = ""
            if dictBoolDonnees["Activite"] is True:
                act = data[0]["activity"]
            else:
                act = ""

            # Ecriture des données dans le fichier donnees
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

            # Actualisation du dictionnaire de l'historique
            dictDonnees = {"Salle": salle,
                           "Date": datetime.datetime.now().strftime("%d/%m/%Y, %H:%M:%S"),
                           "Humidite": str(hum),
                           "CO2": str(co2),
                           "Activite": str(act),
                           "Temperature": str(temp)
                           }

            donneesHist.append(dictDonnees)

            # Print des données reçues dans la console
            print("\n \n")
            print("Salle : ", data[1]["room"])
            print("Température : ", data[0]["temperature"])
            print("Humidité : ", data[0]["humidity"])
            print("CO2 : ", data[0]["co2"])
            print("Activité : ", data[0]["activity"])

        # Appel des alertes
        if data[0]["temperature"] > temperature_max:
            ajouter_alerte(salleActuelle, "temperature_max", "alerte.json")
        if data[0]["humidity"] > humidity_max:
            ajouter_alerte(salleActuelle, "humidity_max", "alerte.json")
        if data[0]["co2"] > co2_max:
            ajouter_alerte(salleActuelle, "co2", "alerte.json")
        if data[0]["activity"] > activity_max:
            ajouter_alerte(salleActuelle, "activity_max", "alerte.json")
        if data[0]["temperature"] < temperature_min:
            ajouter_alerte(salleActuelle, "temperature_min", "alerte.json")
        if data[0]["humidity"] < humidity_min:
            ajouter_alerte(salleActuelle, "humidity_min", "alerte.json")
        if data[0]["co2"] < co2_min:
            ajouter_alerte(salleActuelle, "co2_min", "alerte.json")
        if data[0]["activity"] > activity_min:
            ajouter_alerte(salleActuelle, "activity_min", "alerte.json")


# Ajout d'une alerte
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



read_config()
# Connexion MQTT
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("chirpstack.iut-blagnac.fr", 1883, 60)

# Minuteur pour lancer write_log dans un temps défini
minuteurHistorique = Timer(frequenceDonnees, write_log)
minuteurHistorique.start()

client.loop_forever()
