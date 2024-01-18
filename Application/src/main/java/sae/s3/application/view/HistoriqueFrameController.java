package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;
import javafx.scene.control.*;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.HistoriqueFrame;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;

import java.util.Comparator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Le contrôleur de vue HistoriqueFrameController gère l'interface utilisateur de l'historique
 * des alertes et des données.
 *
 * @author Tristan Delthil
 */
public class HistoriqueFrameController {

    private HistoriqueFrame historiqueFrame;
    private Stage primaryStage;

    /**
     * Initialisation du contrôleur de vue HistoriqueFrameController.
     *
     * @param _containingStage       Stage qui contient le fichier xml contrôlé par
     *                         HistoriqueFrameController
     * @param _historiqueFrame       Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou calcul
     */
    public void initContext(Stage _containingStage, HistoriqueFrame _historiqueFrame) {
        this.primaryStage = _containingStage;
        this.historiqueFrame = _historiqueFrame;
        this.configure();
    }

    /**
     * Configuration de HistoriqueFrameController.
     */
    private void configure() {
        this.primaryStage.setOnCloseRequest(this::closeWindow);
        this.chargerAlertes();
        this.chargerHistorique();
    }

    /**
     * Méthode de fermeture de la fenêtre par la croix.
     */
    private void closeWindow(WindowEvent e) {
        this.doQuit();
        e.consume();
    }

    /**
     * Affiche la fenêtre de l'historique.
     */
    public void displayDialog(){
        this.primaryStage.showAndWait();
    }

    /**
     * Demande une confirmation puis ferme la fenêtre.
     */
    @FXML
    private void doQuit() {
        this.primaryStage.close();
        /*if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter l'historique",
                "Êtes vous sur de vouloir quitter ?", null, Alert.AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }*/
    }

    // Partie FXML

    @FXML
    private TableView<Alerte> alertesTable;
    @FXML
    private TableView<Donnees> historiqueTable;
    @FXML
    private LineChart<String, Number> lineChart;

    /**
     * Chargement des alertes sur la fenêtre grâce à une Table.
     */
    private void chargerAlertes() {
        List<Alerte> alerteData = this.historiqueFrame.getAlertes();

        if (alerteData != null) {
            alertesTable.getItems().addAll(alerteData);
        }
    }

    /**
     * Chargement de l'historique des données sur la fenêtre grâce à une Table.
     */
    private void chargerHistorique() {
        List<Donnees> donneesHistorique = this.historiqueFrame.getDonneesHistorique();

        if(!donneesHistorique.isEmpty()){
            historiqueTable.getItems().addAll(donneesHistorique);
        }

        donneesHistorique.sort(Comparator.comparing(Donnees::getDate).reversed());
        Map<String, XYChart.Series<String, Number>> map = new HashMap<>();
        int nbSalles = 0;

        for (Donnees donnees : donneesHistorique) {
            String salle = donnees.getSalle();

            if (!map.containsKey(salle) && nbSalles < 10) {
                XYChart.Series<String, Number> series = new XYChart.Series<>();
                series.setName(salle);
                map.put(salle, series);
                nbSalles++;
            }

            if (map.containsKey(salle)) {
                XYChart.Series<String, Number> series = map.get(salle);
                String temp = donnees.getTemperature();

                if (!temp.isEmpty()) {
                    try {
                        double temperature = Double.parseDouble(temp);
                        series.getData().add(new XYChart.Data<>(donnees.getDate(), temperature));
                    } catch (NumberFormatException e) {
                        System.out.println("Donnée non récupérée.");
                    }
                }
            }
        }

        lineChart.getData().addAll(map.values());
    }
}