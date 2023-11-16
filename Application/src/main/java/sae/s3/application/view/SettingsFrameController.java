package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.SettingsFrame;
import sae.s3.application.tools.AlertUtilities;

/**
 * Controller JavaFX de la view settings-frame.
 */
public class SettingsFrameController {

    private boolean affichageCo2=true;
    private boolean affichageHumidite=true;
    private boolean affichageTemperature=true;
    private boolean affichageActivite=true;

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
    private TextField textTemp;
    @FXML
    private TextField textAct;
    @FXML
    private TextField textFreq;

    private String trouverErreursSaisie() {
        String erreurs = "";
        
        return erreurs;
    }

    @FXML
    protected void valider() {
        if(co2.isSelected()){
            affichageCo2=true;
        }else{
            affichageCo2=false;
        }
        if(temp.isSelected()){
            affichageTemperature=true;
        }else{
            affichageTemperature=false;
        }
        if(act.isSelected()){
            affichageActivite=true;
        }else{
            affichageActivite=false;
        }
        if(hum.isSelected()){
            affichageHumidite=true;
        }else{
            affichageHumidite=false;
        }
        seuilCo2= Float.parseFloat(textCo2.getText());
        seuilHumidite= Float.parseFloat(texthHum.getText());
        seuilTemperature= Float.parseFloat(textTemp.getText());
        seuilActivite= Float.parseFloat(textAct.getText());
        frequence=Integer.parseInt(textFreq.getText());

    }
}
