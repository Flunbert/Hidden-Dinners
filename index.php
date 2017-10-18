<?php
require_once 'lib/limonade.php';

//Redirects
dispatch_get('/', 'index');
//Version 1 API calls
dispatch_get('/api/v1/:ingredients', 'findRecipes');
dispatch_get('/api/v1/:recipe','findRecipe');

function index()
{
   return html('html/index.html');
}
function findRecipe()
{
   $recipe = params('recipe');
   //TODO: find recipe according to search
}
function findRecipes()
{
   $ingredients = params('ingredients');
   //TODO: find recipes according to what ingredients user has
}

run();
?>
