package sae.s3.application.control;

import com.google.gson.*;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Stage;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.view.MainFrameController;

import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.*;

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
            Scene scene = new Scene(fxmlLoader.load(), 1001, 600);
            scene.getStylesheets().add(Objects.requireNonNull(getClass().getResource("/sae/s3/application/application.css")).toExternalForm());
            primaryStage.setScene(scene);
            primaryStage.setTitle("Données des entrepôts");

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

    public void choisirEntrepots(){
        EntrepotsFrame entrepotsFrame = new EntrepotsFrame(primaryStage);
        entrepotsFrame.doEntrepotsDialog();
    }

    public void afficherHistorique(){
        HistoriqueFrame historiqueFrame = new HistoriqueFrame(primaryStage);
        historiqueFrame.doHistoriqueDialog();
    }

    public Donnees getDonnees() {

        String cheminFichier = "/sae/s3/application/python/donnees.json";

        try (InputStream inputStream = MainFrame.class.getResourceAsStream(cheminFichier)) {
            assert inputStream != null;
            try (InputStreamReader reader = new InputStreamReader(inputStream)) {

                JsonObject jsonObject = JsonParser.parseReader(reader).getAsJsonObject();
                String salle = jsonObject.keySet().iterator().next();

                JsonObject salleData = jsonObject.getAsJsonObject(salle);
                String date = salleData.entrySet().iterator().next().getKey();
                JsonObject values = salleData.getAsJsonObject(date);

                return new Donnees(salle, date, values.get("Temperature").getAsString(),
                        values.get("Humidite").getAsString(),
                        values.get("CO2").getAsString(),
                        values.get("Activite").getAsString());
            }
        } catch (IOException e) {
            e.printStackTrace();
            return null;
        }
    }

    public Alerte getDerniereAlerte() {
        Alerte derniereAlerte = null;

        String cheminFichier = "/sae/s3/application/python/alerte.json";

        try (InputStream inputStream = MainFrame.class.getResourceAsStream(cheminFichier)) {
            assert inputStream != null;
            try (InputStreamReader reader = new InputStreamReader(inputStream)) {

                JsonArray jsonArray = JsonParser.parseReader(reader).getAsJsonArray();

                if (jsonArray != null && !jsonArray.isJsonNull() && !jsonArray.isEmpty()) {
                    JsonElement dernierElement = jsonArray.get(0);
                    if (dernierElement != null && dernierElement.isJsonObject()) {
                        JsonObject alerteObject = dernierElement.getAsJsonObject();
                        String date = alerteObject.get("Date").getAsString();
                        String salle = alerteObject.get("Salle").getAsString();
                        String type = alerteObject.get("Type").getAsString();
                        String message = alerteObject.get("Message").getAsString();

                        derniereAlerte = new Alerte(date, salle, type, message);
                    }
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return derniereAlerte;
    }

}