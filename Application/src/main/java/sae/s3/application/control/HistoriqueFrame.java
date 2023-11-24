package sae.s3.application.control;

import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Modality;
import javafx.stage.Stage;
import sae.s3.application.tools.StageManagement;
import sae.s3.application.view.HistoriqueFrameController;

import java.util.Objects;

public class HistoriqueFrame {

    private Stage primaryStage;
    private HistoriqueFrameController historiqueFrameController;

    /**
     * Constructeur de classe paramétré
     * @param _parentStage Stage source de l'appel au constructeur
     */
    public HistoriqueFrame(Stage _parentStage) {
        try {
            FXMLLoader loader = new FXMLLoader(HistoriqueFrameController.class.getResource("historique-frame.fxml"));

            Scene scene = new Scene(loader.load(), 560, 420);
            scene.getStylesheets().add(Objects.requireNonNull(getClass().getResource("/sae/s3/application/application.css")).toExternalForm());
            // CSS :
            // scene.getStylesheets().add(Application.class.getResource("application.css").toExternalForm());

            this.primaryStage = new Stage();
            this.primaryStage.initModality(Modality.WINDOW_MODAL);
            this.primaryStage.initOwner(_parentStage);
            StageManagement.manageCenteringStage(_parentStage, this.primaryStage);
            this.primaryStage.setScene(scene);
            this.primaryStage.setTitle("Historique des données");
            this.primaryStage.setResizable(false);

            this.historiqueFrameController = loader.getController();
            this.historiqueFrameController.initContext(this.primaryStage, this);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void doHistoriqueDialog(){
        this.historiqueFrameController.displayDialog();
    }
}
