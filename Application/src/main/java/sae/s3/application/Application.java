package sae.s3.application;

/**
 *
 * Classe principale de lancement.
 *
 */

import sae.s3.application.control.MainFrame;

import java.io.*;

/**
 * Démarrage de l'application DailyBank
 *
 */
public class Application {

    /**
     *  Lancement de la fenêtre principale.
     */
    public static void main(String[] args) {
        // Lance le script Python dans un thread séparé
        //Thread pythonThread = new Thread(Application::startPython);
        //pythonThread.start();

        // Lancer l'application JavaFX
        MainFrame.runApp();

        /*Runtime.getRuntime().addShutdownHook(new Thread(() -> {
            System.out.println("Fermeture de l'application. Arrêt du script Python.");
            pythonThread.interrupt();
        }));*/
    }

    /*private static void startPython(){
        try{
            String cheminScript = "src/main/resources/sae/s3/application/python/DonneesCapteurs.py";
            String cheminEcriture = "src/main/resources/sae/s3/application/python/";
            ProcessBuilder processBuilder = new ProcessBuilder("python3", cheminScript);
            //processBuilder.directory(new File(cheminEcriture));
            processBuilder.redirectErrorStream(true);
            Process process = processBuilder.start();

            InputStream inputStream = process.getInputStream();
            BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
            String line;
            while ((line = reader.readLine()) != null) {
                System.out.println("Sortie du script Python : " + line);
            }

            // Attendre la fin du script Python
            int exitCode = process.waitFor();
            System.out.println("Le script Python s'est terminé avec le code de sortie : " + exitCode);

            // Permet de fermer le programme python à l'arrêt de l'application
            Runtime.getRuntime().addShutdownHook(new Thread(() -> {
                System.out.println("Fermeture de l'application. Arrêt du script Python.");
                process.destroy();
            }));
        }catch (IOException e){
            e.printStackTrace();
        } catch (InterruptedException e) {
            throw new RuntimeException(e);
        }
    }*/
}
