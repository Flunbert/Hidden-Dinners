<?php
require_once 'lib/limonade.php';
require("env.php");

//Version 1 API calls
dispatch_get('/api/v1/recipes', 'getRecipes');                                //Returnerar alla recept
dispatch_get('/api/v1/recipes/id/:id','getRecipeById');                          //Returnerar recept med id :id
dispatch_get('/api/v1/recipes/ingredients','getRecipesByIngredients');         //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x
dispatch_get('/api/v1/recipes/ingredients/:acc','getRecipesByIngsFilterAcc');  //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x, :acc ger procentvärde
dispatch_get('/api/v1/ingredients','getIngredients');                         //Returnerar alla ingredienser
dispatch_post('/api/v1/recipes','createRecipe');                              //Skapa nytt recept, kräver headers
dispatch_post('/api/v1/ingredients','createIngredient');                      //Skapa ny ingrediens, kräver headers

run();

//Exempel på hur ett call måste göras för att hämta ett recept med ingredienser (med gammal kod)
//localhost:5000/api/v1/recipes/aaa?recipe[]=1&recipe[]=2

//Exempelkod för hantering av multipla parametrar i APIet. Utkommeterat until further notice
// $recipies = $_GET["recipe"];
// foreach($recipies as $index => $r) {
//   echo $index.": ".$r."<br />";
// }

//Exempelkod för hantering av databas. Utkommenterad until further notice
// $conn = new mysqli($serverName,$userName,$password,$dbName);
// if($conn->connect_error)
// {
//   $message = new stdClass();
//   $message->info = "Database is not responding.";
//   echo json_encode($message);
// }else
// {
//   $sql = "SELECT * FROM combination_table";
//   $sqlResult = mysqli_query($conn, $sql);
//   if($sqlResult)
//   {
//
//   }
// }

//Gammal kod. Bortkommenterad until further notice
// dispatch_get('/api/v1/recipes', 'X');                       //Returnerar alla recept
//dispatch_get('/api/v1/recipes/:id','X');  //Returnerar receptet som matchar id
// dispatch_get('/api/v1/recipes/:ingredients','findRecipe');   //Returnerar alla recept som innehåller ingredients
// dispatch_get('/api/v1/recipes/:ingredients/:acc','X'); //Returnerar alla recept som innehåller ingredients med minimum accuracy acc
// dispatch_get('/api/v1/ingredients','X');  //Returnerar alla ingredienser
// dispatch_post('/api/v1/recipes:recipe:ingredients','X'); //Skapa nytt recept
// dispatch_post('/api/v1/ingredients:ingredient','X');  //Skapa ny ingrediens
?>
