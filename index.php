<?php
require_once 'lib/limonade.php';

//Redirects
dispatch_get('/', 'index');
//Version 1 API calls
dispatch_get('/api/v1/recipes', 'X');  //Returnerar alla recept
//dispatch_get('/api/v1/recipes/:id','X');  //Returnerar receptet som matchar id
dispatch_get('/api/v1/recipes/:ingredients','findRecipe');   //Returnerar alla recept som innehåller ingredients
dispatch_get('/api/v1/recipes/:ingredients/:acc','X'); //Returnerar alla recept som innehåller ingredients med minimum accuracy acc
dispatch_get('/api/v1/ingredients','X');  //Returnerar alla ingredienser
dispatch_post('/api/v1/recipes:recipe:ingredients','X'); //SKapa nytt recept
dispatch_post('/api/v1/ingredients:ingredient','X');  //Skapa ny ingrediens

function index()
{
   return html('html/index.html');
}
function findRecipe($ing)
{
   //echo $ing."\n";
   $recipies = $_GET["recipe"];
   foreach($recipies as $index => $r) {
      echo $index.": ".$r."<br />";
   }
   //$recipe = params('recipe');
   //echo $recipe;
   //TODO: find recipe according to search
}
function findRecipes()
{
   $ingredients = params('ingredients');
   //TODO: find recipes according to what ingredients user has
}

run();
?>
