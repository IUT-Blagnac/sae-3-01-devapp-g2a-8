package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.HistoriqueFrame;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.tools.AlertUtilities;

import java.util.List;

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
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter l'historique",
                "Êtes vous sur de vouloir quitter ?", null, Alert.AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }
    }

    // Partie FXML

    @FXML
    private TableView<Alerte> alertesTable;
    @FXML
    private TableView<Donnees> historiqueTable;

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
    private void chargerHistorique(){
        List<Donnees> donneesHistorique = this.historiqueFrame.getDonneesHistorique();

        if(!donneesHistorique.isEmpty()){
            historiqueTable.getItems().addAll(donneesHistorique);
        }
    }
}
