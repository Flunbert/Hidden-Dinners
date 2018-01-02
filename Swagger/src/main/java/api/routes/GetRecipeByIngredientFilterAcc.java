package api.routes;

import api.models.RecipeListWithIngredients;
import io.swagger.annotations.*;
import api.models.RecipeList;
import spark.Response;
import spark.Request;
import spark.Route;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

@Api
@Path("/api/v1/recipes/{id}/{acc}")
@Produces("application/json")
public class GetRecipeByIngredientFilterAcc implements Route {
    @Override
    @GET
    @ApiOperation(value = "Get recipes that matches ingredients and filters by accuracy", nickname = "GetRecipeByIngredientFilterAcc")
    @ApiImplicitParams({
            @ApiImplicitParam(required = false, dataType = "integer", name = "id", paramType = "path"),
            @ApiImplicitParam(required = true, dataType = "integer", name = "acc", paramType = "path"),
            @ApiImplicitParam(required = true, dataType = "string", name = "ingredient[]", paramType = "query")
    })
    @ApiResponses(value = {
            @ApiResponse(code = 200, message = "Success", response = RecipeList.class),
            @ApiResponse(code = 404, message = "Not Found", response = String.class),
            @ApiResponse(code = 500, message = "Failure", response = String.class)
    })
    public String handle(@ApiParam(hidden = true) Request request, @ApiParam(hidden = true) Response response) {
        return "";
    }
}