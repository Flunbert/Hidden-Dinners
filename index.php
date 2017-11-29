<?php
require_once 'lib/limonade.php';
require("env.php");

//Redirects
dispatch_get('/', 'index');
//Version 1 API calls
dispatch_get('/api/v1/recipes', 'getRecipes');                                //Returnerar alla recept
dispatch_get('/api/v1/recipes/id/:id','getRecipeById');                          //Returnerar recept med id :id
dispatch_get('/api/v1/recipes/ingredients','getRecipeByIngredients');         //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x
dispatch_get('/api/v1/recipes/ingredients/:acc','getRecipeByIngsFilterAcc');  //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x, :acc ger procentvärde
dispatch_get('/api/v1/ingredients','getIngredients');                         //Returnerar alla ingredienser
dispatch_post('/api/v1/recipes','createRecipe');                              //Skapa nytt recept, kräver headers
dispatch_post('/api/v1/ingredients','createIngredient');                      //Skapa ny ingrediens, kräver headers
//Redirect methods
function index()
{
  return html('html/index.html');
}
//GET methods
function getRecipes()
{
  global $serverName, $userName, $password, $dbName;
  $conn = new mysqli($serverName,$userName,$password,$dbName);
  if($conn->connect_error)
  {
    $message = new stdClass();
    $message->info = $conn->connect_error;
    http_response_code(500);
    echo json_encode($message);
  }else
  {
    $sql = "SELECT * FROM recipe";
    $sqlResult = mysqli_query($conn, $sql);
    if($sqlResult && $sqlResult->num_rows > 0)
    {
      while($row = mysqli_fetch_assoc($sqlResult))
      {
        $message = new stdClass();
        $message->id = $row["recipe_id"];
        $message->Name = $row["name"];
        echo json_encode($message);
      }
      http_response_code(200);
    }else
    {
      $message = new stdClass();
      $message->info = "Not found";
      http_response_code(404);
      echo json_encode($message);
    }
  }
}
function getRecipeById($id)
{
  global $serverName, $userName, $password, $dbName;
  $conn = new mysqli($serverName,$userName,$password,$dbName);
  if($conn->connect_error)
  {
    $message = new stdClass();
    $message->info = $conn->connect_error;
    http_response_code(500);
    echo json_encode($message);
  }else
  {
    $sql = "SELECT * FROM recipe WHERE recipe_id=".$id;
    $sqlResult = mysqli_query($conn, $sql);
    if($sqlResult && $sqlResult->num_rows > 0)
    {
      while($row = mysqli_fetch_assoc($sqlResult))
      {
        $message = new stdClass();
        $message->id = $row["recipe_id"];
        $message->Name = $row["name"];
        echo json_encode($message);
      }
      http_response_code(200);
    }else
    {
      $message = new stdClass();
      $message->info = "Not found";
      http_response_code(404);
      echo json_encode($message);
    }
  }
}
function getRecipeByIngredients()
{
  global $serverName, $userName, $password, $dbName;
  $ingredients = $_GET["ingredient"];
  $conn = new mysqli($serverName,$userName,$password,$dbName);
  if($conn->connect_error)
  {
    $message = new stdClass();
    $message->info = $conn->connect_error;
    http_response_code(500);
    echo json_encode($message);
  }else
  {
    $sql = "SELECT r.instructions rName,i.name iName,c.amount amount
            FROM combination_table c
            JOIN recipe r ON c.recipe_id=r.recipe_id
            JOIN ingredient i ON c.ingredient_id=i.ingredient_id";
    $sqlResult = mysqli_query($conn, $sql);
    if($sqlResult && $sqlResult->num_rows > 0)
    {
      $result = new ArrayObject();
      while($row = mysqli_fetch_assoc($sqlResult))
      {
        $message = new stdClass();
        $message->rName = utf8_encode($row["rName"]);
        $message->iName = utf8_encode($row["iName"]);
        $message->amount = utf8_encode($row["amount"]);
        $result['ingredients'][] = $message;
      }
      http_response_code(200);
      echo json_encode($result);
    }else
    {
      $message = new stdClass();
      $message->info = "Not found";
      http_response_code(404);
      echo json_encode($message);
    }
  }
}
function getRecipeByIngsFilterAcc($acc)
{
  global $serverName, $userName, $password, $dbName;
  $ingredients = $_GET["ingredient"];
  $conn = new mysqli($serverName,$userName,$password,$dbName);
  if($conn->connect_error)
  {
    $message = new stdClass();
    $message->info = $conn->connect_error;
    http_response_code(500);
    echo json_encode($message);
  }else
  {
    $sql = "SELECT r.instructions rName,i.name iName,c.amount amount
            FROM combination_table c
            JOIN recipe r ON c.recipe_id=r.recipe_id
            JOIN ingredient i ON c.ingredient_id=i.ingredient_id";
    $sqlResult = mysqli_query($conn, $sql);
    if($sqlResult && $sqlResult->num_rows > 0)
    {
      $result = new ArrayObject();
      $result['acc'] = $acc;
      while($row = mysqli_fetch_assoc($sqlResult))
      {
        $message = new stdClass();
        $message->rName = utf8_encode($row["rName"]);
        $message->iName = utf8_encode($row["iName"]);
        $message->amount = utf8_encode($row["amount"]);
        $result['ingredients'][] = $message;
      }
      http_response_code(200);
      echo json_encode($result);
    }else
    {
      $message = new stdClass();
      $message->info = "Not found";
      http_response_code(404);
      echo json_encode($message);
    }
  }
}
function getIngredients()
{
  global $serverName, $userName, $password, $dbName;
  $conn = new mysqli($serverName,$userName,$password,$dbName);
  if($conn->connect_error)
  {
    $message = new stdClass();
    $message->info = $conn->connect_error;
    http_response_code(500);
    echo json_encode($message);
  }else
  {
    $sql = "SELECT * FROM ingredient;";
    $sqlResult = mysqli_query($conn, $sql);
    if($sqlResult && $sqlResult->num_rows > 0)
    {
      $result = new ArrayObject();
      while($row = mysqli_fetch_assoc($sqlResult))
      {
        $message = new stdClass();
        $message->id = utf8_encode($row["ingredient_id"]);
        $message->name = utf8_encode($row["name"]);
        $result['ingredients'][] = $message;
      }
      http_response_code(200);
      echo json_encode($result);
    }else
    {
      $message = new stdClass();
      $message->info = "Not found";
      http_response_code(404);
      echo json_encode($message);
    }
  }
}
//POST methods
function createRecipe()
{

}
function createIngredient()
{

}

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
