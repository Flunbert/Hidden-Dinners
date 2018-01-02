package api.routes;

import io.swagger.annotations.*;
import spark.Response;
import spark.Request;
import spark.Route;

import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

@Api
@Path("/api/v1/ingredients")
@Produces("application/json")
public class CreateIngredient implements Route {
    @Override
    @POST
    @ApiOperation(value = "Create a new ingredient", nickname = "CreateIngredient")
    @ApiImplicitParams({
            @ApiImplicitParam(required = true, dataType = "string", name = "name", paramType = "query"),
            @ApiImplicitParam(required = true, dataType = "string", name = "measurement", paramType = "query")
    })
    @ApiResponses(value = {
            @ApiResponse(code = 201, message = "Success", response = String.class),
            @ApiResponse(code = 500, message = "Failure", response = String.class)
    })
    public String handle(@ApiParam(hidden = true) Request request, @ApiParam(hidden = true) Response response) {
        return "";
    }
}