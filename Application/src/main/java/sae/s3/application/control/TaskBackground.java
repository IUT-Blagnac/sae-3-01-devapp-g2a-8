package sae.s3.application.control;

import java.util.TimerTask;

import javafx.application.Platform;
import sae.s3.application.model.Alerte;
import sae.s3.application.model.Donnees;
import sae.s3.application.view.MainFrameController;

/**
 * La classe TaskBackground est un thread qui met à jour les données et alertes affichées.
 * @author Tristan Delthil
 */
public class TaskBackground extends TimerTask {

    private MainFrameController mf;

    private Donnees donnees;
    private Alerte alerte;

    /**
     * Constructeur de la classe TaskBackground.
     *
     * @param _mf               Le Contrôleur MainFrameController
     * @param _donnees          Les données initiales
     * @param _alerte           L'alerte initiale
     */
    public TaskBackground(MainFrameController _mf, Donnees _donnees, Alerte _alerte) {
        this.mf = _mf;
        this.donnees = _donnees;
        this.alerte = _alerte;
    }

    /**
     * Corps de la tâche lorsqu'elle est activée.
     */
    @Override
    public void run() {
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
