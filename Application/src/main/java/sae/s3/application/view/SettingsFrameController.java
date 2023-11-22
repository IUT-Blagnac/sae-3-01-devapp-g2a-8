package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.SettingsFrame;
import sae.s3.application.tools.AlertUtilities;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Controller JavaFX de la view settings-frame.
 */
public class SettingsFrameController {

    private boolean affichageCo2=true;
    private boolean affichageHumidite=true;
    private boolean affichageTemperature=true;
    private boolean affichageActivite=true;
    private Stage  dialogStage;
    private float seuilCo2;
    private float seuilHumidite;
    private float seuilTemperature;
    private float seuilActivite;

    private int frequence;

    private SettingsFrame settingsFrame;
    private Stage primaryStage;

    /**
     * Initialisation du contrôleur de vue SettingsFrameController.
     *
     * @param _containingStage Stage qui contient le fichier xml contrôlé par
     *                         SettingsFrameController
     * @param _settingsFrame            Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou calcul
     */
    public void initContext(Stage _containingStage, SettingsFrame _settingsFrame) {
        this.primaryStage = _containingStage;
        this.settingsFrame = _settingsFrame;
        this.configure();
    }

    /*
     * Configuration de SettingsFrameController.
     * Fermeture par la croix.
     */
    private void configure() {
        this.primaryStage.setOnCloseRequest(this::closeWindow);
    }

    /*
     * Méthode de fermeture de la fenêtre par la croix.
     *
     */
    private void closeWindow(WindowEvent e) {
        this.doQuit();
        e.consume();
    }

    public void displayDialog(){
        this.primaryStage.showAndWait();
    }

    /*
     * Demande une confirmation puis ferme la fenêtre.
     */
    @FXML
    private void doQuit() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter les paramètres",
                "Êtes vous sur de vouloir quitter ?", null, Alert.AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }
    }

    // Partie FXML

    @FXML
    private Button valider;

    @FXML
    private RadioButton co2;
    @FXML
    private RadioButton temp;
    @FXML
    private RadioButton hum;
    @FXML
    private RadioButton act;

    @FXML
    private TextField textCo2;

    @FXML
    private TextField texthHum;

    @FXML
    private Label texteValid;
    @FXML
    private TextField textTemp;
    @FXML
    private TextField textAct;
    @FXML
    private TextField textFreq;

    private String trouverErreursSaisie() {
        String erreurs = "";
        String regex = "^\\d+(\\.\\d+)?$";

        // Créer le pattern
        Pattern pattern = Pattern.compile(regex);

        // Créer le matcher avec la chaîne d'entrée
        Matcher matcher = pattern.matcher(textAct.getText());

        // Vérifier si la chaîne correspond à la regex
        if (!matcher.matches()) {
            erreurs += "La saisie d'activité ne doit contenir que des chiffres\n";
        }
        matcher = pattern.matcher(textTemp.getText());
        if (!matcher.matches()) {
            erreurs += "La saisie de température ne doit contenir que des chiffres\n";
        }
        matcher = pattern.matcher(texthHum.getText());
        if (!matcher.matches()) {
            erreurs += "La saisie de l'humidité ne doit contenir que des chiffres\n";
        }
        matcher = pattern.matcher(textCo2.getText());
        if (!matcher.matches()) {
            erreurs += "La saisie du CO2 ne doit contenir que des chiffres\n";
        }
        regex = "^\\d+$";
        pattern = Pattern.compile(regex);
        matcher = pattern.matcher(textFreq.getText());
        if (!matcher.matches()) {
            erreurs += "La saisie de la fréquence ne doit contenir que des chiffres ou nombres entiers\n";
        }
        return erreurs;
    }

    @FXML
    protected void valider()  {
        String erreurs = this.trouverErreursSaisie();
        if (erreurs.length()>0) {
            System.out.println("Saisie incorrecte :");
            System.out.println(erreurs);
            Alert about= new Alert(Alert.AlertType.ERROR);
            about.setTitle("ERREURS");
            about.setHeaderText("Voici les erreurs:");
            about.setContentText(erreurs);
            about.initOwner(this.dialogStage);
            about.showAndWait();

        } else {

            if (co2.isSelected()) {
                affichageCo2 = true;
            } else {
                affichageCo2 = false;
            }
            if (temp.isSelected()) {
                affichageTemperature = true;
            } else {
                affichageTemperature = false;
            }
            if (act.isSelected()) {
                affichageActivite = true;
            } else {
                affichageActivite = false;
            }
            if (hum.isSelected()) {
                affichageHumidite = true;
            } else {
                affichageHumidite = false;
            }
            seuilCo2 = Float.parseFloat(textCo2.getText());
            seuilHumidite = Float.parseFloat(texthHum.getText());
            seuilTemperature = Float.parseFloat(textTemp.getText());
            seuilActivite = Float.parseFloat(textAct.getText());
            frequence = Integer.parseInt(textFreq.getText());
            this.texteValid.setText("Données enregistrées !");
            
        }
    }
}
