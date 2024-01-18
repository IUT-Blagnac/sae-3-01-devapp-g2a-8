package sae.s3.application.model;

public class Alerte {

    private String date;
    private String salle;
    private String type;
    private String message;

    public Alerte(String date, String salle, String type, String message) {
        this.date = date;
        this.salle = salle;
        this.type = type;
        this.message = message;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getSalle() {
        return salle;
    }

    public void setSalle(String salle) {
        this.salle = salle;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
