module sae.s3.application {
    requires javafx.controls;
    requires javafx.fxml;


    opens sae.application to javafx.fxml;
    exports sae.application;
    exports sae.view;
    opens sae.view to javafx.fxml;
}