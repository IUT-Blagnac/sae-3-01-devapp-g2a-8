package sae.s3.application.model;

public class Donnees {

    private String salle;
    private double temperature;
    private double humidite;
    private int co2;
    private int activite;

    public Donnees(String salle, double temperature, double humidite, int co2, int activite){
        this.salle = salle;
        this.temperature = temperature;
        this.humidite = humidite;
        this.co2 = co2;
        this.activite = activite;
    }

    public String getSalle() {
        return salle;
    }

    public double getTemperature() {
        return temperature;
    }

    public double getHumidite() {
        return humidite;
    }

    public int getCo2() {
        return co2;
    }

    public int getActivite() {
        return activite;
    }

    @Override
    public String toString() {
        return "Salle : " + this.salle + "\nTempérature : " + this.temperature +
                "\nHumidité : " + this.humidite + "\nCO2 : " + this.co2 + "\nActivité : "
                + this.activite;
    }
}
