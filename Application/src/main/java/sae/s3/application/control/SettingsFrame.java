package sae.s3.application.control;

import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Modality;
import javafx.stage.Stage;
import sae.s3.application.tools.StageManagement;
import sae.s3.application.view.SettingsFrameController;

public class SettingsFrame {

    private Stage primaryStage;
    private SettingsFrameController settingsFrameController;

    /**
     * Constructeur de classe paramétré
     * @param _parentStage Stage source de l'appel au constructeur
     */
    public SettingsFrame(Stage _parentStage) {
        try {
            FXMLLoader loader = new FXMLLoader(SettingsFrameController.class.getResource("settings-frame.fxml"));
            BorderPane root = loader.load();

            Scene scene = new Scene(root, root.getPrefWidth() + 50, root.getPrefHeight() + 10);
            // CSS :
            // scene.getStylesheets().add(Application.class.getResource("application.css").toExternalForm());

            this.primaryStage = new Stage();
            this.primaryStage.initModality(Modality.WINDOW_MODAL);
            this.primaryStage.initOwner(_parentStage);
            StageManagement.manageCenteringStage(_parentStage, this.primaryStage);
            this.primaryStage.setScene(scene);
            this.primaryStage.setTitle("Gestion des paramètres");
            this.primaryStage.setResizable(false);

            this.settingsFrameController = loader.getController();
            this.settingsFrameController.initContext(this.primaryStage, this);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
