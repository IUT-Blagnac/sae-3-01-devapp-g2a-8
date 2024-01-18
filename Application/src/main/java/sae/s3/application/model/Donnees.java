package sae.s3.application.model;

public class Donnees {

    private String salle;
    private String date;
    private String temperature;
    private String humidite;
    private String co2;
    private String activite;

    public Donnees(String salle, String date, String temperature, String humidite, String co2, String activite){
        this.salle = salle;
        this.date = date;
        this.temperature = temperature;
        this.humidite = humidite;
        this.co2 = co2;
        this.activite = activite;
    }

    public String getSalle() {
        return salle;
    }

    public String getDate(){
        return this.date;
    }

    public String getTemperature() {
        return temperature;
    }

    public String getHumidite() {
        return humidite;
    }

    public String getCo2() {
        return co2;
    }

    public String getActivite() {
        return activite;
    }

    @Override
    public String toString() {
        return "Salle : " + this.salle + "\nDate : " + this.date + "\nTempérature : " + this.temperature +
                "\nHumidité : " + this.humidite + "\nCO2 : " + this.co2 + "\nActivité : "
                + this.activite;
    }
}
