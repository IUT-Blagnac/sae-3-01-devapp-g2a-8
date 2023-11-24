module sae.s3.application {
    requires javafx.controls;
    requires javafx.fxml;
    requires com.google.gson;


    opens sae.s3.application to javafx.fxml;
    exports sae.s3.application;
    exports sae.s3.application.control;
    opens sae.s3.application.control to javafx.fxml;
    exports sae.s3.application.view;
    opens sae.s3.application.view to javafx.fxml;
}