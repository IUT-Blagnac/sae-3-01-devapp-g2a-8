package sae.s3.application.control;

import javafx.application.Platform;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.view.HistoriqueFrameController;
import sae.s3.application.view.MainFrameController;

import java.util.Objects;

// Code d'un thread qui met à jour aléatoirement un quartier du PieChart.

public class RunBackground implements Runnable {

    // Contrôle de l'exécution du thread : isRun == true => s'exécute
    private boolean isRun;

    // Controller pour la mise à jour des PieChart
    private MainFrameController mf;
    // Nombre de quartiers dans le BarChart
    private int nbBarsOfBarChart;

    private Donnees donnees;
    private Alerte alerte;

    // Constructeur
    // _mf : le controller contenant le PieChart
    // _nbBarsOfBarChart : nombre de quartiers dans le BarChart
    public RunBackground(MainFrameController _mf, int _nbBarsOfBarChart, Donnees _donnees, Alerte _alerte) {
        this.mf = _mf;
        this.nbBarsOfBarChart = _nbBarsOfBarChart;
        this.isRun = true;
        this.donnees = _donnees;
        this.alerte = _alerte;
    }

    // Corps du thread
    @Override
    public void run() {
        // Tant que le thread courant s'exécute
        while (this.isRun) {
            // Paramètres de la mise à jour d'un quartier au hasard du PieChart

            // Mise en file d'attente (dans un Runnable) de la mise à jour du PieChart via mf.miseAJourPieChart()
            // Ce Runnable sera exécuté par le thread GUI "dès que possible"
            Platform.runLater(new Runnable() {
                @Override
                public void run() {
                    donnees = RunBackground.this.mf.miseAJourDonnees();
                    alerte = RunBackground.this.mf.miseAJourAlertes();

                    RunBackground.this.mf.miseAJour(donnees, alerte);
                }
            });

            // Documentation de Platform.runLater ()
            // If you need to update a GUI component from a non-GUI thread, you can use that to put your update in a queue and it will be handled by the GUI thread as soon as possible.

            System.out.println("RunBackground");

            // Le thread courant se met en attente 3 secondes (il "s'endort" et ne prend plus le processeur)
            try {
                Thread.sleep(3000L);
            } catch (InterruptedException e) {
            }
        }
    }

    // Méthode pour arrêter le thread courant (c'est à dire que la méthode run() se termine)
    public void stopIt() {
        this.isRun = false;
    }

}
