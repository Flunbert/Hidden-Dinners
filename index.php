<?php
require_once 'lib/limonade.php';
require("env.php");

//Redirects
dispatch_get('/', 'index');
//Version 1 API calls
dispatch_get('/api/v1/recipes', 'getRecipes');                                //Returnerar alla recept
dispatch_get('/api/v1/recipes/id/:id','getRecipeById');                          //Returnerar recept med id :id
dispatch_get('/api/v1/recipes/ingredients','getRecipesByIngredients');         //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x
dispatch_get('/api/v1/recipes/ingredients/:acc','getRecipesByIngsFilterAcc');  //Returnera recept som innehåller ingredient, kräver ?ingredient[]=x, :acc ger procentvärde
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
   $conn->set_charset("utf8");
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
   $conn->set_charset("utf8");
   if($conn->connect_error)
   {
      $message = new stdClass();
      $message->info = $conn->connect_error;
      http_response_code(500);
      echo json_encode($message);
   }else
   {
      $sql = "SELECT r.instructions rInstructions, r.name rName,i.name iName,c.amount amount
      FROM combination_table c
      JOIN recipe r ON c.recipe_id=r.recipe_id
      JOIN ingredient i ON c.ingredient_id=i.ingredient_id
      WHERE r.recipe_id=".$id;
      $sqlResult = mysqli_query($conn, $sql);
      if($sqlResult && $sqlResult->num_rows > 0)
      {
         $result = new ArrayObject();
         $setInstr = true;
         while($row = mysqli_fetch_assoc($sqlResult))
         {
            if($setInstr)
            {
               $result['recipeName'] = $row["rName"];
               $result['instructions'] = $row["rInstructions"];
               $setInstr = false;
            }
            $message = new stdClass();
            $message->iName = $row["iName"];
            $message->amount = $row["amount"];
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
function getRecipesByIngredients()
{
   getRecipesByIngsFilterAcc(0);
}
function getRecipesByIngsFilterAcc($acc)
{
   global $serverName, $userName, $password, $dbName;
   $ingredients = $_GET["ingredient"];
   $conn = new mysqli($serverName,$userName,$password,$dbName);
   $conn->set_charset("utf8");
   if($conn->connect_error)
   {
      $message = new stdClass();
      $message->info = $conn->connect_error;
      http_response_code(500);
      echo json_encode($message);
   }else
   {
      $sql = "SELECT DISTINCT r.recipe_id rId, r.name rName
      FROM combination_table c
      JOIN recipe r ON c.recipe_id=r.recipe_id
      JOIN ingredient i ON c.ingredient_id=i.ingredient_id";
      $sql .= " WHERE";
      foreach($ingredients as $index => $ing) {
         if($index == 0)
         {
            $sql .= " i.name='".$ing."'";
         }else
         {
            $sql .= " OR i.name='".$ing."'";
         }
      }
      $sqlResult = mysqli_query($conn, $sql);
      if($sqlResult && $sqlResult->num_rows > 0)
      {
         $result = new ArrayObject();
         while($row = mysqli_fetch_assoc($sqlResult))
         {
            $message = new stdClass();
            $message->id = $row["rId"];
            $message->name = $row["rName"];
            $result['recipes'][] = $message;
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
   $conn->set_charset("utf8");
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
   global $serverName, $userName, $password, $dbName;
   $conn = new mysqli($serverName,$userName,$password,$dbName);
   $conn->set_charset("utf8");
   if($conn->connect_error)
   {
      $message = new stdClass();
      $message->info = $conn->connect_error;
      http_response_code(500);
      echo json_encode($message);
   }else
   {
      $sql = "SELECT name FROM recipe WHERE name='".$_POST["name"]."'";
      $sqlResult = mysqli_query($conn, $sql);
      if($sqlResult && $sqlResult->num_rows > 0)
      {
         $message = new stdClass();
         $message->info = "Entry already exists";
         http_response_code(409); //Conflict
         echo json_encode($message);
      }else
      {
         $sql = "INSERT INTO recipe(name,instructions) VALUES('".$_POST["name"]."','".$_POST["instructions"]."')";
         $sqlResult = mysqli_query($conn, $sql);
         if($sqlResult)
         {
            $sql = "SELECT recipe_id FROM recipe WHERE name='".$_POST["name"]."'";
            $sqlResult = mysqli_query($conn, $sql);
            if($sqlResult)
            {
               $row = mysqli_fetch_assoc($sqlResult);
               $amountArray = $_POST["amount"];
               foreach($_POST["ingredient"] as $index => $i)
               {
                  $sql = "INSERT INTO combination_table(recipe_id, ingredient_id, amount)
                  VALUES(".$row["recipe_id"].",".$i.",".$amountArray[$index].")";
                  $sqlResult = mysqli_query($conn, $sql);
               }
               $message = new stdClass();
               $message->info = "Entry successfully created";
               http_response_code(201); //Created
               echo json_encode($message);
            }else
            {
               $message = new stdClass();
               $message->info = "Something went wrong with the database [Create combination_table]";
               http_response_code(500); //Internal server error
               echo json_encode($message);
            }
         }else
         {
            $message = new stdClass();
            $message->info = "Something went wrong with the database [Create recipe]";
            http_response_code(500); //Internal server error
            echo json_encode($message);
         }
      }
   }
}
function createIngredient()
{
   global $serverName, $userName, $password, $dbName;
   $conn = new mysqli($serverName,$userName,$password,$dbName);
   $conn->set_charset("utf8");
   if($conn->connect_error)
   {
      $message = new stdClass();
      $message->info = $conn->connect_error;
      http_response_code(500);
      echo json_encode($message);
   }else
   {
      $sql = "SELECT name FROM ingredient WHERE name='".$_POST["name"]."'";
      $sqlResult = mysqli_query($conn, $sql);
      if($sqlResult && $sqlResult->num_rows > 0)
      {
         $message = new stdClass();
         $message->info = "Entry already exists";
         http_response_code(409); //Conflict
         echo json_encode($message);
      }else
      {
         $sql = "INSERT INTO ingredient(name) VALUES('".$_POST["name"]."')";
         $sqlResult = mysqli_query($conn, $sql);
         if($sqlResult)
         {
            $message = new stdClass();
            $message->info = "Entry successfully created";
            http_response_code(201); //Created
            echo json_encode($message);
         }else
         {
            $message = new stdClass();
            $message->info = "Something went wrong with the database";
            http_response_code(500); //Internal server error
            echo json_encode($message);
         }
      }
   }
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
