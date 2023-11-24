package sae.s3.application.control;

import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Stage;
import sae.s3.application.model.Donnees;
import sae.s3.application.view.MainFrameController;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.Objects;

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
            Scene scene = new Scene(fxmlLoader.load(), 1000, 800);
            scene.getStylesheets().add(Objects.requireNonNull(getClass().getResource("/sae/s3/application/application.css")).toExternalForm());
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

    public Donnees getDonnees() {
        String cheminFichier = "/sae/s3/application/python/donnees.json";

        Donnees donnees = null;
        try (InputStream inputStream = MainFrame.class.getResourceAsStream(cheminFichier);
             InputStreamReader reader = new InputStreamReader(inputStream)) {

            JsonObject jsonObject = JsonParser.parseReader(reader).getAsJsonObject();
            if (jsonObject.has("Salle")) {
                String salle = jsonObject.get("Salle").getAsString();
                double temperature = jsonObject.get("Temperature").getAsDouble();
                double humidite = jsonObject.get("Humidite").getAsDouble();
                int co2 = jsonObject.get("CO2").getAsInt();
                int activite = jsonObject.get("Activite").getAsInt();

                donnees = new Donnees(salle, temperature, humidite, co2, activite);

                System.out.println("Salle : " + salle);
                System.out.println("Température : " + temperature);
                System.out.println("Humidité : " + humidite);
                System.out.println("CO2 : " + co2);
                System.out.println("Activité : " + activite);
            } else {
                System.out.println("La clé 'Salle' n'existe pas dans le fichier JSON.");
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return donnees;
    }
}