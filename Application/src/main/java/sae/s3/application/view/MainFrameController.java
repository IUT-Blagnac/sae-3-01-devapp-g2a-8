package sae.s3.application.view;

import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.XYChart;
import javafx.scene.control.Alert;
import javafx.scene.control.Label;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.MainFrame;
import sae.s3.application.control.RunBackground;
import sae.s3.application.control.TaskBackground;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.tools.AlertUtilities;

import java.util.Objects;
import java.util.Timer;


public class MainFrameController {

    private Stage primaryStage;
    private MainFrame mainFrame;
    private Donnees donnees;
    private Alerte alerte;

    private TaskBackground tb;
    private Timer timer;

    private RunBackground rb;


    /**
     * Initialisation du contrôleur de vue SettingsFrameController.
     *
     * @param _containingStage Stage qui contient le fichier xml contrôlé par
     *                         SettingsFrameController
     * @param _mainFrame            Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou calcul
     */
    public void initContext(Stage _containingStage, MainFrame _mainFrame) {
        this.primaryStage = _containingStage;
        this.mainFrame = _mainFrame;
        this.configure();
        SettingsFrameController.updateSelectedButtonsList();
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
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter l'application",
                "Êtes vous sur de vouloir quitter ?", null, Alert.AlertType.CONFIRMATION)) {
            this.rb.stopIt();
            this.timer.cancel();
            this.primaryStage.close();
        }
    }

    public void displayDialog() {
        this.primaryStage.show();

        donnees = mainFrame.getDonnees();

        String affichage = "Aucune donnée";

        if (donnees != null) {
            affichage = "Salle : " + donnees.getSalle() + "\nDate : " + donnees.getDate();

            XYChart.Series<String, Number> series = new XYChart.Series<>();
            series.getData().add(new XYChart.Data<>("Température", Double.parseDouble(donnees.getTemperature())));
            series.getData().add(new XYChart.Data<>("CO2", Double.parseDouble(donnees.getCo2())));
            series.getData().add(new XYChart.Data<>("Humidité", Double.parseDouble(donnees.getHumidite())));
            series.getData().add(new XYChart.Data<>("Activité", Double.parseDouble(donnees.getActivite())));

            this.barChart.getData().add(series);

            this.rb = new RunBackground(this, series.getData().size(), this.donnees, this.alerte);

            Thread t = new Thread(this.rb);

            t.start();

            this.tb = new TaskBackground(this, series.getData().size(), this.donnees, this.alerte);

            this.timer = new Timer();

            this.timer.scheduleAtFixedRate(
                    this.tb,
                    1000L,
                    2000L);
        }
    }

    /*public void displayDialog(){
        this.primaryStage.show();
        donnees = mainFrame.getDonnees();
        String affichage = "Aucune donnée";
        if(donnees != null){
            affichage = "Salle : " + donnees.getSalle() + "\nDate : " + donnees.getDate();
            if(!donnees.getTemperature().isEmpty()) {
                affichage += "\nTempérature : " + donnees.getTemperature();
            }
            if(!donnees.getCo2().isEmpty()) {
                affichage += "\nCO2 : " + donnees.getCo2();
            }
            if(!donnees.getHumidite().isEmpty()) {
                affichage += "\nHumidité : " + donnees.getHumidite();
            }
            if(!donnees.getActivite().isEmpty()) {
                affichage += "\nActivité : " + donnees.getActivite();
            }
        }
        affichageDonnees.setText(affichage);

        //displayGraph(donnees);
    }*/

    @FXML
    private BarChart<String, Number> barChart;
    @FXML
    private Label affichageDonnees;
    @FXML
    private Label lblHum;
    @FXML
    private Label lblCO2;
    @FXML
    private Label lblActivite;
    @FXML
    private Label lblTemp;

    public void displayGraph(Donnees donnees) {
        barChart.getData().clear();

        XYChart.Series<String, Number> series = new XYChart.Series<>();
        if (!donnees.getTemperature().isEmpty()) {
            series.getData().add(new XYChart.Data<>("Température", Double.parseDouble(donnees.getTemperature())));
        }

        if (!donnees.getHumidite().isEmpty()) {
            series.getData().add(new XYChart.Data<>("Humidité", Double.parseDouble(donnees.getHumidite())));
        }

        barChart.getData().add(series);
    }

    public Donnees miseAJourDonnees(){
        return mainFrame.getDonnees();
    }

    public Alerte miseAJourAlertes(){
        return mainFrame.getDerniereAlerte();
    }

    public void miseAJour(Donnees donnees, Alerte alerte) {
        this.barChart.getData().clear();
        XYChart.Series<String, Number> series = new XYChart.Series<>();
        series.getData().add(new XYChart.Data<>("Humidité", Double.parseDouble(donnees.getHumidite())));
        series.getData().add(new XYChart.Data<>("CO2", Double.parseDouble(donnees.getCo2())));
        series.getData().add(new XYChart.Data<>("Activité", Double.parseDouble(donnees.getActivite())));
        series.getData().add(new XYChart.Data<>("Température", Double.parseDouble(donnees.getTemperature())));

        barChart.getData().add(series);

        XYChart.Data<String, Number> barChart;
        ObservableList<XYChart.Data<String, Number>> seriesData;

        seriesData = series.getData();

        this.affichageDonnees.setText(donnees.getSalle());

        barChart = seriesData.get(0);
        this.lblHum.setText(barChart.getXValue() + " : " + barChart.getYValue());
        barChart = seriesData.get(1);
        this.lblCO2.setText(barChart.getXValue() + " : " + barChart.getYValue());
        barChart = seriesData.get(2);
        this.lblActivite.setText(barChart.getXValue() + " : " + barChart.getYValue());
        barChart = seriesData.get(3);
        this.lblTemp.setText(barChart.getXValue() + " : " + barChart.getYValue());

        System.out.println("Mise à jour de humidité : " + donnees.getHumidite());
        System.out.println("Mise à jour de CO2 : " + donnees.getCo2());
        System.out.println("Mise à jour de activité : " + donnees.getActivite());
        System.out.println("Mise à jour de température : " + donnees.getTemperature());

        if (alerte != null && !Objects.equals(alerte, this.alerte)) {
            System.out.println("Alerte actuelle : " + this.alerte);
            System.out.println("Nouvelle alerte : " + alerte);
            System.out.println("Comparaison : " + !Objects.equals(alerte, this.alerte));

            String msgAlerte = alerte.getMessage();
            System.out.println("Nouvelle alerte détectée. Affichage de l'alerte : " + alerte.getDate() + alerte.getSalle());
            AlertUtilities.showAlert(this.primaryStage, "Alerte !",
                    msgAlerte, null, Alert.AlertType.CONFIRMATION);
            this.alerte = alerte;
        } else {
            System.out.println("Pas de nouvelle alerte à afficher.");
        }
    }

    @FXML
    protected void ouvrirParam() {
        this.mainFrame.choisirParametres();
    }

    @FXML
    protected void ouvrirHist() {
        this.mainFrame.afficherHistorique();
    }

    @FXML
    protected void ouvrirEntrepots() {
        this.mainFrame.choisirEntrepots();
    }
}