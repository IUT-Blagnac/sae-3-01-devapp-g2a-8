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

/**
 * Le contrôleur de la vue principale de l'application.
 * Il gère l'affichage des données en temps réel et les mises à jour graphiques.
 *
 * @author Tristan Delthil
 */
public class MainFrameController {

    private Stage primaryStage;
    private MainFrame mainFrame;
    private Donnees donnees;
    private Alerte alerte;

    private TaskBackground tb;
    private Timer timer;

    private RunBackground rb;


    /**
     * Initialisation du contrôleur de vue MainFrameController.
     *
     * @param _containingStage Stage qui contient le fichier xml contrôlé par
     *                         MainFrameController
     * @param _mainFrame            Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou calcul
     */
    public void initContext(Stage _containingStage, MainFrame _mainFrame) {
        this.primaryStage = _containingStage;
        this.mainFrame = _mainFrame;
        this.configure();
        SettingsFrameController.updateSelectedButtonsList();
    }

    /**
     * Configuration de SettingsFrameController.
     * Fermeture par la croix.
     */
    private void configure() {
        this.primaryStage.setOnCloseRequest(this::closeWindow);
    }

    /**
     * Méthode de fermeture de la fenêtre par la croix.
     *
     */
    private void closeWindow(WindowEvent e) {
        this.doQuit();
        e.consume();
    }

    /**
     * Demande une confirmation puis ferme la fenêtre.
     */
    @FXML
    private void doQuit() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter l'application",
                "Êtes vous sur de vouloir quitter ?", null, Alert.AlertType.CONFIRMATION)) {
            //this.rb.stopIt();
            this.timer.cancel();
            this.primaryStage.close();
        }
    }

    /**
     * Affiche la fenêtre principale et initialise les données.
     */
    public void displayDialog() {
        this.primaryStage.show();

        donnees = mainFrame.getDonnees();
        alerte = mainFrame.getDerniereAlerte();

        miseAJour(donnees, alerte);

        this.tb = new TaskBackground(this, this.donnees, this.alerte);

        this.timer = new Timer();

        this.timer.scheduleAtFixedRate(
                this.tb,
                1000L,
                5000L);

    }

    // Partie FXML

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

    /**
     * Affiche le graphique des données.
     *
     * @param donnees Les données à afficher
     */
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

    /**
     * Met à jour les données.
     *
     * @return Les données mises à jour
     */
    public Donnees miseAJourDonnees(){
        return mainFrame.getDonnees();
    }

    /**
     * Met à jour les alertes.
     *
     * @return La dernière alerte mise à jour
     */
    public Alerte miseAJourAlertes(){
        return mainFrame.getDerniereAlerte();
    }

    /**
     * Effectue une mise à jour complète des données et des alertes.
     *
     * @param donnees Les données à afficher
     * @param alerte  La dernière alerte à afficher
     */
    public void miseAJour(Donnees donnees, Alerte alerte) {
        this.barChart.getData().clear();
        XYChart.Series<String, Number> series = new XYChart.Series<>();

        if(!donnees.getHumidite().isEmpty()){
            series.getData().add(new XYChart.Data<>("Humidité", Double.parseDouble(donnees.getHumidite())));
            this.lblHum.setText("Humidité : " + donnees.getHumidite());
        }else{
            this.lblHum.setText("Humidité : Donnée non récupérée.");
        }
        if(!donnees.getCo2().isEmpty()){
            series.getData().add(new XYChart.Data<>("CO2", Double.parseDouble(donnees.getCo2())));
            this.lblCO2.setText("CO2 : " + donnees.getCo2());
        }else{
            this.lblCO2.setText("CO2 : Donnée non récupérée.");
        }
        if(!donnees.getActivite().isEmpty()){
            series.getData().add(new XYChart.Data<>("Activité", Double.parseDouble(donnees.getActivite())));
            this.lblActivite.setText("Activité : " + donnees.getActivite());
        }else{
            this.lblActivite.setText("Activité : Donnée non récupérée.");
        }
        if(!donnees.getTemperature().isEmpty()){
            series.getData().add(new XYChart.Data<>("Température", Double.parseDouble(donnees.getTemperature())));
            this.lblTemp.setText("Température : " + donnees.getTemperature());
        }else{
            this.lblTemp.setText("Température : Donnée non récupérée.");
        }

        barChart.getData().add(series);

        this.affichageDonnees.setText(donnees.getSalle());

        System.out.println("Mise à jour de humidité : " + donnees.getHumidite());
        System.out.println("Mise à jour de CO2 : " + donnees.getCo2());
        System.out.println("Mise à jour de activité : " + donnees.getActivite());
        System.out.println("Mise à jour de température : " + donnees.getTemperature());

        if (alerte != null && !Objects.equals(alerte, this.alerte)) {
            this.alerte = alerte;
            System.out.println("Alerte actuelle : " + this.alerte);
            System.out.println("Nouvelle alerte : " + alerte);
            System.out.println("Comparaison : " + !Objects.equals(alerte, this.alerte));

            String msgAlerte = alerte.getMessage();
            System.out.println("Nouvelle alerte détectée. Affichage de l'alerte : " + alerte.getDate() + alerte.getSalle() + alerte.getType());
            AlertUtilities.showAlert(this.primaryStage, "Alerte !",
                    msgAlerte, null, Alert.AlertType.WARNING);
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