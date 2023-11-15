package sae.s3.application.control;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;
import sae.s3.application.view.MainFrameController;

import java.io.IOException;

/**
 * Classe de controleur de Dialogue de la fenêtre principale.
 *
 */
public class MainFrame extends Application {
    private Stage primaryStage;

    @Override
    public void start(Stage primaryStage) throws IOException {
        this.primaryStage = primaryStage;
        try{
            FXMLLoader fxmlLoader = new FXMLLoader(MainFrameController.class.getResource("main-frame.fxml"));
            Scene scene = new Scene(fxmlLoader.load(), 426, 321);
            primaryStage.setScene(scene);
            primaryStage.setTitle("Hello!");

            MainFrameController mainFrameController = fxmlLoader.getController();
            mainFrameController.initContext(primaryStage, this);
            mainFrameController.displayDialog();
        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }

    }

    /**
     * Méthode principale de lancement de l'application.
     */
    public static void runApp() {
        Application.launch();
    }

    public void choisirParametres(){
        SettingsFrame settingsFrame = new SettingsFrame(primaryStage);
        settingsFrame.doSettingsDialog();
    }

    public void afficherHistorique(){
        HistoriqueFrame historiqueFrame = new HistoriqueFrame(primaryStage);
        historiqueFrame.doHistoriqueDialog();
    }
}