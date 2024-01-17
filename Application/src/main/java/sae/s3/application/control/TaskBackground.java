package sae.s3.application.control;

import java.util.Objects;
import java.util.TimerTask;

import javafx.application.Platform;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.view.MainFrameController;

//Code d'une tâche gérée par Timer qui met à jour aléatoirement un quartier du PieChart.

public class TaskBackground extends TimerTask {

    // Controller pour la mise à jour des PieChart
    private MainFrameController mf;

    // Nombre de quartiers dans le BarChart
    private int nbBarsOfBarChart;
    private Donnees donnees;
    private Alerte alerte;

    // Constructeur
    // _mf : le controller contenant le PieChart
    // _nbBarsOfBarChart : nombre de quartiers dans le BarChart
    public TaskBackground(MainFrameController _mf, int _nbBarsOfBarChart, Donnees _donnees, Alerte _alerte) {
        this.mf = _mf;
        this.nbBarsOfBarChart = _nbBarsOfBarChart;
        this.donnees = _donnees;
        this.alerte = _alerte;
    }

    // Corps de la tâche lorsque elle est activée
    @Override
    public void run() {
        // Mise en file d'attente (dans un Runnable) de la mise à jour du PieChart via mf.miseAJourPieChart()
        // Ce Runnable sera exécuté par le thread GUI "dès que possible"
        Platform.runLater(new Runnable() {
            @Override
            public void run() {
                donnees = TaskBackground.this.mf.miseAJourDonnees();
                alerte = TaskBackground.this.mf.miseAJourAlertes();

                TaskBackground.this.mf.miseAJour(donnees, alerte);
            }
        });

        // Documentation de Platform.runLater ()
        // If you need to update a GUI component from a non-GUI thread, you can use that to put your update in a queue and it will be handled by the GUI thread as soon as possible.

        System.out.println("TaskBackground");
    }
}
