module sae.s3.application {
    requires javafx.controls;
    requires javafx.fxml;


    opens sae.s3.application to javafx.fxml;
    exports sae.s3.application;
    exports sae.s3.view;
    opens sae.s3.view to javafx.fxml;
}