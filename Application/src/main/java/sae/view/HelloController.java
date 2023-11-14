package sae.view;

import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.RadioButton;

public class HelloController {
    @FXML
    private Label welcomeText;

    @FXML
    private Button hstrq;
    @FXML
    private RadioButton rb;


    @FXML
    private Button parametrer;

    @FXML
    private Button salle;



    @FXML
    protected void onHelloButtonClick() {
        welcomeText.setText("Welcome to JavaFX Application!");
    }
}