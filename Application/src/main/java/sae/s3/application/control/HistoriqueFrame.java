package sae.s3.application.control;

import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Modality;
import javafx.stage.Screen;
import javafx.stage.Stage;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.tools.StageManagement;
import sae.s3.application.view.HistoriqueFrameController;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
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

            Screen screen = Screen.getPrimary();

            Scene scene = new Scene(loader.load(), screen.getBounds().getWidth(), screen.getBounds().getHeight());
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

    public List<Donnees> getDonneesHistorique() {
        List<Donnees> donneesList = new ArrayList<>();

        String cheminFichier = "/sae/s3/application/python/historique.json";

        try (InputStream inputStream = MainFrame.class.getResourceAsStream(cheminFichier)) {
            assert inputStream != null;
            try (InputStreamReader reader = new InputStreamReader(inputStream)) {

                JsonObject historiqueObject = JsonParser.parseReader(reader).getAsJsonObject();

                for (Map.Entry<String, JsonElement> salleEntry : historiqueObject.entrySet()) {
                    String salle = salleEntry.getKey();
                    JsonObject datesData = salleEntry.getValue().getAsJsonObject();

                    for (Map.Entry<String, JsonElement> dateEntry : datesData.entrySet()) {
                        String date = dateEntry.getKey();
                        JsonObject values = dateEntry.getValue().getAsJsonObject();

                        String temperature = values.get("Temperature").getAsString();
                        String humidite = values.get("Humidite").getAsString();
                        String co2 = values.get("CO2").getAsString();
                        String activite = values.get("Activite").getAsString();

                        Donnees donnees = new Donnees(salle, date, temperature, humidite, co2, activite);
                        donneesList.add(donnees);
                    }
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return donneesList;
    }


    public List<Alerte> getAlertes() {
        List<Alerte> alertesList = new ArrayList<>();

        String cheminFichier = "/sae/s3/application/python/alerte.json";

        try (InputStream inputStream = MainFrame.class.getResourceAsStream(cheminFichier)) {
            assert inputStream != null;
            try (InputStreamReader reader = new InputStreamReader(inputStream)) {

                JsonArray jsonArray = JsonParser.parseReader(reader).getAsJsonArray();

                if(jsonArray != null && !jsonArray.isJsonNull()){
                    for (JsonElement element : jsonArray) {
                        if(element != null && element.isJsonObject()){
                            JsonObject alerteObject = element.getAsJsonObject();
                            String date = alerteObject.get("Date").getAsString();
                            String salle = alerteObject.get("Salle").getAsString();
                            String type = alerteObject.get("Type").getAsString();
                            String message = alerteObject.get("Message").getAsString();

                            Alerte alerteData = new Alerte(date, salle, type, message);
                            alertesList.add(alerteData);
                        }
                    }
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return alertesList;
    }
}
