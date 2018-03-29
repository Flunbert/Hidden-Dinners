<?php
require_once 'lib/limonade.php';
require("env.php");

//Redirects
dispatch_get('/', 'index');
dispatch_get('/get_by_ingredient', 'get_by_ingredient');

//Version 1 API calls
dispatch_get('/api/v1/recipes', 'getRecipes');                              //Returnerar alla recept
dispatch_get('/api/v1/recipes/:id','getRecipeById');                        //Returnerar recept med id :id
// dispatch_get('/api/v1/recipes/ingredients','getRecipesByIngredients');   //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x
dispatch_get('/api/v1/recipes/:id/:acc','getRecipesByIngsFilterAcc');       //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x, :acc ger procentvärde
dispatch_get('/api/v1/ingredients','getIngredients');                       //Returnerar alla ingredienser
dispatch_post('/api/v1/recipes','createRecipe');                            //Skapa nytt recept, kräver headers
dispatch_post('/api/v1/ingredients','createIngredient');                    //Skapa ny ingrediens, kräver headers

function index(){return html('views/index.html');}
function get_by_ingredient(){return html('views/recipe_by_ingredient.html');}

run();
?>
