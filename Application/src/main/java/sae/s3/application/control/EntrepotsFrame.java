package sae.s3.application.control;

import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Modality;
import javafx.stage.Stage;
import sae.s3.application.tools.StageManagement;
import sae.s3.application.view.EntrepotsFrameController;
import sae.s3.application.view.SettingsFrameController;

import java.util.Objects;

public class EntrepotsFrame {

    private Stage primaryStage;
    private EntrepotsFrameController entrepotsFrameController;

    /**
     * Constructeur de classe paramétré
     * @param _parentStage Stage source de l'appel au constructeur
     */
    public EntrepotsFrame(Stage _parentStage) {
        try {
            FXMLLoader loader = new FXMLLoader(EntrepotsFrameController.class.getResource("entrepots-frame.fxml"));

            Scene scene = new Scene(loader.load(), 800, 600);
            scene.getStylesheets().add(Objects.requireNonNull(getClass().getResource("/sae/s3/application/application.css")).toExternalForm());


            this.primaryStage = new Stage();
            this.primaryStage.initModality(Modality.WINDOW_MODAL);
            this.primaryStage.initOwner(_parentStage);
            StageManagement.manageCenteringStage(_parentStage, this.primaryStage);
            this.primaryStage.setScene(scene);
            this.primaryStage.setTitle("Gestion des paramètres");
            this.primaryStage.setResizable(false);

            this.entrepotsFrameController = loader.getController();
            this.entrepotsFrameController.initContext(this.primaryStage, this);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void doEntrepotsDialog(){
        this.entrepotsFrameController.displayDialog();
    }
}
