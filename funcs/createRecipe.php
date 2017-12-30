<?php
function createRecipe()
{
   global $serverName, $userName, $password, $dbName;
   $conn = mysqli_connect($serverName,$userName,$password,$dbName);
   $conn->set_charset("utf8");
   if($conn->connect_error)
   {
      $message = new stdClass();
      $message->info = $conn->connect_error;
      http_response_code(500);
      echo json_encode($message);
   }else
   {
      $sql = 'SELECT name FROM recipe WHERE name=?';
      if(!($stmt = $conn->prepare($sql)))
      {
         //Error
      }else if(!($stmt->bind_param('s',$_POST['name'])))
      {
         //Error
      }else if(($sqlResult = $stmt->execute()))
      {
         $stmt->store_result();
         if($stmt->num_rows > 0)
         {
            $message = new stdClass();
            $message->info = "Entry already exists";
            http_response_code(200); //Conflict
            echo json_encode($message);
         }else
         {
            $conn->autocommit(false);
            $sql = "INSERT INTO recipe(name,instructions) VALUES(?,?)";
            if(!($stmt = $conn->prepare($sql)))
            {
               //Error
            }else if(!($stmt->bind_param('ss',$_POST['name'],$_POST["instructions"])))
            {
               //Error
            }else if(($stmt->execute()))
            {
               $insId = $conn->insert_id;
               $amountArray = $_POST["amount"];
               foreach($_POST["ingredient"] as $index => $i)
               {
                  $sql = "INSERT INTO combination_table(recipe_id, ingredient_id, amount) VALUES(?,?,?)";
                  $stmt->prepare($sql);
                  $stmt->bind_param('iii',$insId,$i,$amountArray[$index]);
                  $stmt->execute();
               }
               $conn->commit();
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
?>
