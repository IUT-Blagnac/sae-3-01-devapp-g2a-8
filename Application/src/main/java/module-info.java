module sae.s3.application {
    requires javafx.controls;
    requires javafx.fxml;


    opens saeS3.application to javafx.fxml;
    exports saeS3.application;
    exports saeS3.view;
    opens saeS3.view to javafx.fxml;
}