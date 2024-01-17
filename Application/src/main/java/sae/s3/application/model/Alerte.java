package sae.s3.application.model;

import java.util.Objects;

/**
 * La classe Alerte représente une alerte composée d'une date, une salle, un type, et un message.
 *
 * @author Tristan Delthil
 */
public class Alerte {

    private String date;
    private String salle;
    private String type;
    private String message;

    /**
     * Constructeur de la classe Alerte.
     *
     * @param date    Date de l'alerte
     * @param salle   Salle associée à l'alerte
     * @param type    Type de l'alerte
     * @param message Message de l'alerte
     */
    public Alerte(String date, String salle, String type, String message) {
        this.date = date;
        this.salle = salle;
        this.type = type;
        this.message = message;
    }

    /**
     * Permet de récupérer la date de l'alerte.
     *
     * @return la date de l'alerte
     */
    public String getDate() {
        return date;
    }

    /**
     * Permet de récupérer la salle associée à l'alerte.
     *
     * @return la salle associée à l'alerte
     */
    public String getSalle() {
        return salle;
    }

    /**
     * Permet de récupérer le type de l'alerte.
     *
     * @return le type de l'alerte
     */
    public String getType() {
        return type;
    }

    /**
     * Permet de récupérer le message de l'alerte.
     *
     * @return le message de l'alerte
     */
    public String getMessage() {
        return message;
    }

    /**
     * Permet de comparer deux objets de type Alerte.
     *
     * @param o l'objet à comparer avec l'instance actuelle
     * @return true si les objets sont égaux, false sinon
     */
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

    /**
     * Permet de calculer le code de hachage de l'objet Alerte.
     *
     * @return le code de hachage de l'objet
     */
    @Override
    public int hashCode() {
        return Objects.hash(getDate(), getSalle(), getType(), getMessage());
    }

}
