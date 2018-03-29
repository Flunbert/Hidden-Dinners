function get_by_ingredient()
{
  $.ajax(
    {
      // /api/v1/recipes/:id/:acc?ingredients[]
      url: "/api/v1/recipes/0/0?ingredients[]",
      type: "GET",
      data: {
        ingredients: ingredients
      }
    }).done(function(data)
    {
      var recipes = JSON.parse(data);
      $("p").remove(".result");
      $.each(recipes, function(i, item)
      {
        $("#recipes_container").append($("<p class='result' recipeId="+item.id+">"+item.name+"</p>"));
      });
      setRecipeClickEvent();
    });
  }
