package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.MenuButton;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.SettingsFrame;
import sae.s3.application.tools.AlertUtilities;

/**
 * Controller JavaFX de la view settings-frame.
 */
public class SettingsFrameController {

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
    private Label welcomeText;

    @FXML
    private Button prmtr;

    @FXML
    private Button hstrq;

    @FXML
    private MenuButton entrpts;

    @FXML
    protected void onHelloButtonClick() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }


    @FXML
    protected void ouvrirParam() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }

    @FXML
    protected void ouvrirHist() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }
}
