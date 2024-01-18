package sae.s3.application.view;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.geometry.Insets;
import javafx.scene.Node;
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
 * Contrôleur JavaFX de la vue EntrepotsFrame.
 */
public class EntrepotsFrameController {

    private EntrepotsFrame entrepotsFrame;
    private Stage primaryStage;

    private static final String CONFIG_FILE_PATH = "src/main/resources/sae/s3/application/python/config.ini";

    /**
     * Initialise le contrôleur de vue EntrepotsFrameController.
     *
     * @param _containingStage Stage qui contient le fichier XML contrôlé par
     *                         EntrepotsFrameController.
     * @param _entrepotsFrame  Contrôleur de Dialogue qui réalisera les opérations
     *                         de navigation ou de calcul.
     */
    public void initContext(Stage _containingStage, EntrepotsFrame _entrepotsFrame) {
        this.primaryStage = _containingStage;
        this.entrepotsFrame = _entrepotsFrame;
        createButtons();
        this.configure();
    }

    /**
     * Configuration du contrôleur EntrepotsFrameController.
     * Fermeture par la croix.
     */
    private void configure() {
        this.primaryStage.setOnCloseRequest(this::closeWindow);
    }

    /**
     * Méthode de fermeture de la fenêtre par la croix.
     */
    private void closeWindow(WindowEvent e) {
        this.doQuit();
        e.consume();
    }

    /**
     * Affiche la boîte de dialogue des paramètres.
     */
    public void displayDialog() {
        this.primaryStage.showAndWait();
    }

    /**
     * Demande une confirmation puis ferme la fenêtre.
     */
    @FXML
    private void doQuit() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter les paramètres",
                "Êtes-vous sûr de vouloir quitter et valider les salles ?", null, Alert.AlertType.CONFIRMATION)) {

            this.updateConfigValues();
            this.primaryStage.close();
            System.out.println(SettingsFrameController.selectedButtonLabels);

        }
    }

    /**
     * Liste des noms des boutons pour la création des boutons.
     */
    private List<String> buttonNames = Arrays.asList(
            "C004", "B106", "E003", "Serveurs", "E209", "B234", "E207", "E103", "hall-amphi",
            "B103", "B113", "B217", "E106", "B212", "E102", "Foyer-personnels", "B201", "amphi1",
            "E208", "hall-entrée-principale", "E206", "B112", "E210", "E105", "B111", "B110",
            "B109", "E100", "E007", "salleConseil", "E104", "B203", "B003", "Local-velo", "B108",
            "E006", "C006", "E004", "B202", "E001", "E101"
    );

    @FXML
    private GridPane gridPane;
    @FXML
    private Button selectAllButton;

    /**
     * Crée les boutons en fonction des noms de boutons préalablement définis.
     */
    private void createButtons() {
        int numButtons = buttonNames.size();
        int columns = 7;

        double buttonHeight = 40;

        gridPane.setHgap(5);
        gridPane.setVgap(5);
        gridPane.setPadding(new Insets(10, 10, 10, 10));

        selectAllButton = new Button("Sélectionner tout");
        selectAllButton.setOnAction(this::handleSelectAllButtonClick);
        gridPane.add(selectAllButton, columns - 1, (numButtons / columns) + 1);

        for (int i = 0; i < numButtons; i++) {
            Button button = new Button(buttonNames.get(i));
            button.setMinHeight(buttonHeight);
            button.setPrefHeight(buttonHeight);
            button.setPrefWidth(100);

            button.setMaxHeight(buttonHeight);

            int row = i / columns;
            int col = i % columns;
            gridPane.add(button, col, row);

            button.setOnAction(this::handleButtonClick);

            if (SettingsFrameController.selectedButtonLabels.contains(button.getText())) {
                button.setStyle("-fx-background-color: green;");
            }
        }
    }

    /**
     * Gère le clic sur le bouton "Sélectionner tout".
     */
    private void handleSelectAllButtonClick(ActionEvent event) {
        boolean selectAll = !SettingsFrameController.selectedButtonLabels.isEmpty();
        for (Node node : gridPane.getChildren()) {
            if (node instanceof Button) {
                Button button = (Button) node;
                button.setStyle(selectAll ? "-fx-background-color: #3498db;" : "");
            }
        }

        if (selectAll) {
            SettingsFrameController.selectedButtonLabels.clear();
        } else {
            SettingsFrameController.selectedButtonLabels.addAll(buttonNames);
        }

        updateConfigValues();
    }

    /**
     * Gère le clic sur un bouton.
     */
    private void handleButtonClick(ActionEvent event) {
        if (event.getSource() instanceof Button) {
            Button clickedButton = (Button) event.getSource();
            String buttonText = clickedButton.getText();

            if (!SettingsFrameController.selectedButtonLabels.contains(buttonText)) {
                // Bouton non sélectionné
                SettingsFrameController.selectedButtonLabels.add(buttonText);
                clickedButton.setStyle("-fx-background-color: green;");
            } else {
                // Bouton déjà sélectionné
                SettingsFrameController.selectedButtonLabels.remove(buttonText);
                clickedButton.setStyle("-fx-background-color: #3498db;"); // Changer la couleur en bleu clair
            }

            System.out.println("Boutons sélectionnés : " + SettingsFrameController.selectedButtonLabels);
        }
    }

    /**
     * Charge la configuration depuis le fichier.
     *
     * @return Une map représentant les sections et les propriétés du fichier de configuration.
     */
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

    /**
     * Sauvegarde la configuration dans le fichier.
     *
     * @param configMap La map représentant les sections et les propriétés du fichier de configuration.
     */
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

                writer.newLine(); // Ligne vide
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    /**
     * Met à jour les valeurs de configuration en fonction des boutons sélectionnés.
     */
    private void updateConfigValues() {
        Map<String, Properties> configMap = loadConfigFromFile();

        Properties sallesProperties = configMap.get("[Salles]");
        if (sallesProperties != null) {
            if (!SettingsFrameController.selectedButtonLabels.isEmpty()) {
                // Convertir la liste des salles en une chaîne séparée par des virgules
                String salles = String.join(",", SettingsFrameController.selectedButtonLabels);

                sallesProperties.setProperty("salle", salles);
            } else {
                sallesProperties.remove("salle");
            }
        }

        saveConfigToFile(configMap);
    }
}
