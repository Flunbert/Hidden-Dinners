package api.routes;

import api.models.RecipeWithIngredients;
import io.swagger.annotations.*;
import api.models.Recipe;
import spark.Response;
import spark.Request;
import spark.Route;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

@Api
@Path("/api/v1/recipes/{id}")
@Produces("application/json")
public class GetRecipeById implements Route {
    @GET
    @ApiOperation(value = "Gets recipe that matches id", nickname = "GetRecipeById")
    @ApiImplicitParams({
            @ApiImplicitParam(required = true, dataType = "integer", name = "id", paramType = "path")
    })
    @ApiResponses(value = {
            @ApiResponse(code = 200, message = "Success", response = RecipeWithIngredients.class),
            @ApiResponse(code = 404, message = "Not Found", response = String.class),
            @ApiResponse(code = 500, message = "Failure", response = String.class)
    })
    public String handle(@ApiParam(hidden = true) Request request, @ApiParam(hidden = true) Response response){
        return "";
    }
}
