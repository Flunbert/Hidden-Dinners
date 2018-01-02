package api;

import io.swagger.annotations.Info;
import io.swagger.annotations.SwaggerDefinition;
import spark.ModelAndView;
import spark.Spark;
import spark.template.velocity.VelocityTemplateEngine;

import java.util.HashMap;
import java.util.Map;

import static spark.Spark.before;
import static spark.Spark.get;
import static spark.SparkBase.port;

@SwaggerDefinition(host = "localhost:8000",
        info = @Info(description = "Projekt för Självfördjupande Datavetenskap",
                version = "V1.0",
                title = "Hidden Dinners API"),
        schemes = {SwaggerDefinition.Scheme.HTTP},
        consumes = {"application/json"},
        produces = {"application/json"})
public class Main
{
    private static final String APP_PACKAGE = "api";

    public static void main(String[] args) throws Exception
    {
        Spark.staticFileLocation("public");
        port(5000);
        before(new CorsFilter());
        new OptionsController();
        RouteBuilder.setupRoutes(APP_PACKAGE);

        //Kod för att generera Swagger dokumentation
        final String swaggerJson = SwaggerParser.getSwaggerJson(APP_PACKAGE);
        get("/swagger", (req, res) -> swaggerJson);
    }
}