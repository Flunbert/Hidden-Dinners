package api.routes;

import io.swagger.annotations.*;
import api.models.RecipeList;
import spark.Response;
import spark.Request;
import spark.Route;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

@Api
@Path("/api/v1/recipes")
@Produces("application/json")
public class GetRecipes implements Route {
    @GET
    @ApiOperation(value = "Get all recipes", nickname = "GetRecipes")
    @ApiResponses(value = {
            @ApiResponse(code = 200, message = "Success", response = RecipeList.class),
            @ApiResponse(code = 404, message = "Not Found", response = String.class),
            @ApiResponse(code = 500, message = "Failure", response = String.class)
    })
    public String handle(@ApiParam(hidden = true) Request request, @ApiParam(hidden = true) Response response) {
        return "";
    }
}
