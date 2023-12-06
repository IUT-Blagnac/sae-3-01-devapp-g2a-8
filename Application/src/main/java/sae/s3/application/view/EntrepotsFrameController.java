package sae.s3.application.view;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.geometry.Insets;
import javafx.scene.control.*;
import javafx.scene.layout.GridPane;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import sae.s3.application.control.EntrepotsFrame;
import sae.s3.application.control.SettingsFrame;
import sae.s3.application.tools.AlertUtilities;

import java.io.*;
import java.net.URL;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Controller JavaFX de la view settings-frame.
 */
public class EntrepotsFrameController {



    private EntrepotsFrame entrepotsFrame;
    private Stage primaryStage;

    private static final String CONFIG_FILE_PATH = "src/main/resources/sae/s3/application/python/config.ini";

    /**
     * Initialisation du contrôleur de vue SettingsFrameController.
     *
     * @param _containingStage Stage qui contient le fichier xml contrôlé par
     *                         SettingsFrameController
     * @param _entrepotsFrame            Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou calcul
     */
    public void initContext(Stage _containingStage, EntrepotsFrame _entrepotsFrame) {
        this.primaryStage = _containingStage;
        this.entrepotsFrame = _entrepotsFrame;
        createToggleButtons();
        this.configure();
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

    public void displayDialog(){
        this.primaryStage.showAndWait();
    }

    /*
     * Demande une confirmation puis ferme la fenêtre.
     */
    @FXML
    private void doQuit() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter les paramètres",
                "Êtes vous sur de vouloir quitter et valider les salles ?", null, Alert.AlertType.CONFIRMATION)) {

            this.updateConfigValues();
            this.primaryStage.close();
        }
    }

    private List<String> buttonNames = Arrays.asList(
            "C004", "B106", "E003", "Serveurs", "E209", "B234", "E207", "E103", "hallAmphi",
            "B103", "B113", "B217", "E106", "B212", "E102", "FoyerPersonnel", "B201", "amphi1",
            "E208", "hallEntreePrincipale", "E206", "B112", "E210", "E105", "B111", "B110",
            "B109", "E100", "E007", "salleConseil", "E104", "B203", "B003", "localVelo", "B108",
            "E006", "C006", "E004", "B202", "E001", "E101"
    );
    private List<String> selectedButtonLabels = new ArrayList<>(); // Liste pour stocker les textes des boutons sélectionnés

    @FXML
    private GridPane gridPane; // Assurez-vous d'avoir un GridPane dans votre FXML avec l'id correspondant


    public void initialize(URL url, ResourceBundle resourceBundle) {
        createToggleButtons();
    }

    private void createToggleButtons() {
        int numButtons = buttonNames.size();
        int columns = 7; // Vous pouvez ajuster le nombre de colonnes en fonction de vos besoins

        double buttonHeight = 40; // Ajustez la hauteur des boutons selon vos besoins

        gridPane.setHgap(5); // Espace horizontal réduit entre les boutons
        gridPane.setVgap(5); // Espace vertical réduit entre les boutons
        gridPane.setPadding(new Insets(10, 10, 10, 10)); // Marge autour du GridPane avec 10 de padding de tous les côtés

        for (int i = 0; i < numButtons; i++) {
            ToggleButton toggleButton = new ToggleButton(buttonNames.get(i)); // Utiliser le nom de la liste
            toggleButton.setMinHeight(buttonHeight);
            toggleButton.setPrefHeight(buttonHeight);
            toggleButton.setMaxHeight(buttonHeight);

            int row = i / columns;
            int col = i % columns;
            gridPane.add(toggleButton, col, row);
            toggleButton.setOnAction(this::handleButtonClick);
        }
    }

    private void handleButtonClick(ActionEvent event) {
        if (event.getSource() instanceof ToggleButton) {
            ToggleButton clickedButton = (ToggleButton) event.getSource();
            String buttonText = clickedButton.getText();

            if (clickedButton.isSelected()) {
                // Ajouter le texte du bouton à la liste si le bouton est sélectionné
                selectedButtonLabels.add(buttonText);
            } else {
                // Retirer le texte du bouton de la liste si le bouton est désélectionné
                selectedButtonLabels.remove(buttonText);
            }

            // Vous pouvez faire quelque chose avec la liste mise à jour ici
            System.out.println("Boutons sélectionnés : " + selectedButtonLabels);
        }
    }

    private Map<String, Properties> loadConfigFromFile() {
        Map<String, Properties> configMap = new LinkedHashMap<>();

        try (BufferedReader reader = new BufferedReader(new FileReader(CONFIG_FILE_PATH))) {
            String currentSection = null;
            Properties currentProperties = null;

            String line;
            while ((line = reader.readLine()) != null) {
                line = line.trim();
                if (line.startsWith("[") && line.endsWith("]")) {
                    currentSection = line;
                    currentProperties = new Properties();
                    configMap.put(currentSection, currentProperties);
                } else if (line.contains("=") && currentProperties != null) {
                    String[] parts = line.split("=");
                    currentProperties.setProperty(parts[0].trim(), parts[1].trim());
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return configMap;
    }
    private void saveConfigToFile(Map<String, Properties> configMap) {
        try (BufferedWriter writer = new BufferedWriter(new FileWriter(CONFIG_FILE_PATH))) {
            for (Map.Entry<String, Properties> entry : configMap.entrySet()) {
                writer.write(entry.getKey());
                writer.newLine();

                Properties properties = entry.getValue();
                for (Map.Entry<Object, Object> propertyEntry : properties.entrySet()) {
                    writer.write(propertyEntry.getKey() + " = " + propertyEntry.getValue());
                    writer.newLine();
                }

                writer.newLine(); // Ligne vide entre les sections
            }
        } catch (IOException e) {
            e.printStackTrace();  // Gérer les exceptions de manière appropriée dans votre application
        }
    }
    private void updateConfigValues() {
        Map<String, Properties> configMap = loadConfigFromFile();



        Properties frequencesProperties = configMap.get("[Salles]");
        if (frequencesProperties != null) {
            frequencesProperties.setProperty("salle", String.valueOf(this.selectedButtonLabels));
        }



        // Sauvegarder les modifications dans le fichier
        saveConfigToFile(configMap);
    }





}
