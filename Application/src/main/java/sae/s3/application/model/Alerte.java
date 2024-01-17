package sae.s3.application.model;

import java.util.Objects;

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

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;
        Alerte alerte = (Alerte) o;
        return Objects.equals(getDate(), alerte.getDate()) &&
                Objects.equals(getSalle(), alerte.getSalle()) &&
                Objects.equals(getType(), alerte.getType()) &&
                Objects.equals(getMessage(), alerte.getMessage());
    }

    @Override
    public int hashCode() {
        return Objects.hash(getDate(), getSalle(), getType(), getMessage());
    }

}
