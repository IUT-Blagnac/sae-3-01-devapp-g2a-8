package sae.s3.application.view;

import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.MenuButton;

public class ParamController {
    @FXML
    private Label welcomeText;

    @FXML
    private Button prmtr;

    @FXML
    private Button hstrq;

    @FXML
    private MenuButton entrpts;

    @FXML
    protected void onHelloButtonClick() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }


    @FXML
    protected void ouvrirParam() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }

    @FXML
    protected void ouvrirHist() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }
}
