package sae.s3.application.control;

import javafx.application.Platform;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.view.MainFrameController;

/**
 * La classe RunBackground est un thread qui met à jour les données et alertes affichées.
 * @author Tristan Delthil
 */
public class RunBackground implements Runnable {

    // Contrôle de l'exécution du thread : isRun == true => s'exécute
    private boolean isRun;

    private MainFrameController mf;
    // Nombre de quartiers dans le BarChart
    private int nbBarsOfBarChart;

    private Donnees donnees;
    private Alerte alerte;

    /**
     * Initialisation de RunBackground.
     *
     * @param _mf               Le Contrôleur MainFrameController
     * @param _nbBarsOfBarChart Nombre de quartiers dans le BarChart
     * @param _donnees          Les données initiales
     * @param _alerte           L'alerte initiale
     */
    public RunBackground(MainFrameController _mf, int _nbBarsOfBarChart, Donnees _donnees, Alerte _alerte) {
        this.mf = _mf;
        this.nbBarsOfBarChart = _nbBarsOfBarChart;
        this.isRun = true;
        this.donnees = _donnees;
        this.alerte = _alerte;
    }

    /**
     * Corps du thread. Met à jour les données et les alertes.
     */
    @Override
    public void run() {
        // Tant que le thread courant s'exécute
        while (this.isRun) {

            // Ce Runnable sera exécuté par le thread GUI "dès que possible"
            Platform.runLater(new Runnable() {
                @Override
                public void run() {
                    donnees = RunBackground.this.mf.miseAJourDonnees();
                    alerte = RunBackground.this.mf.miseAJourAlertes();

                    RunBackground.this.mf.miseAJour(donnees, alerte);
                }
            });

            System.out.println("RunBackground");

            try {
                Thread.sleep(3000L);
            } catch (InterruptedException e) {
            }
        }
    }

    /**
     * Méthode pour arrêter le thread courant.
     */
    public void stopIt() {
        this.isRun = false;
    }

}
