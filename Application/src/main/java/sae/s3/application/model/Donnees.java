package sae.s3.application.model;

/**
 * La classe Donnees représente des données associées à une salle, une date, une température, une humidité,
 * un niveau de CO2 et une activité.
 *
 * @author Tristan Delthil
 */
public class Donnees {

    private String salle;
    private String date;
    private String temperature;
    private String humidite;
    private String co2;
    private String activite;

    /**
     * Constructeur de la classe Donnees.
     *
     * @param salle       Salle associée aux données
     * @param date        Date des données
     * @param temperature Température associée aux données
     * @param humidite    Humidité associée aux données
     * @param co2         Niveau de CO2 associé aux données
     * @param activite     Activité associée aux données
     */
    public Donnees(String salle, String date, String temperature, String humidite, String co2, String activite){
        this.salle = salle;
        this.date = date;
        this.temperature = temperature;
        this.humidite = humidite;
        this.co2 = co2;
        this.activite = activite;
    }

    /**
     * Permet de récupérer la salle associée aux données.
     *
     * @return la salle associée aux données
     */
    public String getSalle() {
        return salle;
    }

    /**
     * Permet de récupérer la date des données.
     *
     * @return la date des données
     */
    public String getDate(){
        return this.date;
    }

    /**
     * Permet de récupérer la température associée aux données.
     *
     * @return la température associée aux données
     */
    public String getTemperature() {
        return temperature;
    }

    /**
     * Permet de récupérer l'humidité associée aux données.
     *
     * @return l'humidité associée aux données
     */
    public String getHumidite() {
        return humidite;
    }

    /**
     * Permet de récupérer le niveau de CO2 associé aux données.
     *
     * @return le niveau de CO2 associé aux données
     */
    public String getCo2() {
        return co2;
    }

    /**
     * Permet de récupérer l'activité associée aux données.
     *
     * @return l'activité associée aux données
     */
    public String getActivite() {
        return activite;
    }

    /**
     * Permet d'obtenir une représentation textuelle des données.
     *
     * @return un String représentant les données
     */
    @Override
    public String toString() {
        return "Salle : " + this.salle + "\nDate : " + this.date + "\nTempérature : " + this.temperature +
                "\nHumidité : " + this.humidite + "\nCO2 : " + this.co2 + "\nActivité : "
                + this.activite;
    }
}
