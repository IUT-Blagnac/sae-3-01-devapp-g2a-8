package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.EntrepotsFrame;
import sae.s3.application.control.SettingsFrame;
import sae.s3.application.tools.AlertUtilities;

import java.io.*;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Properties;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Controller JavaFX de la view settings-frame.
 */
public class EntrepotsFrameController {



    private EntrepotsFrame entrepotsFrame;
    private Stage primaryStage;

    private static final String CONFIG_FILE_PATH = "src/main/resources/sae/s3/application/python/config.ini";

    /**
     * Initialisation du contrôleur de vue SettingsFrameController.
     *
     * @param _containingStage Stage qui contient le fichier xml contrôlé par
     *                         SettingsFrameController
     * @param _entrepotsFrame            Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou calcul
     */
    public void initContext(Stage _containingStage, EntrepotsFrame _entrepotsFrame) {
        this.primaryStage = _containingStage;
        this.entrepotsFrame = _entrepotsFrame;
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



}
