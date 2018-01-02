<?php
function getRecipeById($id)
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
      $sql = 'SELECT r.instructions rInstructions, r.name rName, i.name iName, i.measurement iMeasure, c.amount amount
      FROM combination_table c
      JOIN recipe r ON c.recipe_id=r.recipe_id
      JOIN ingredient i ON c.ingredient_id=i.ingredient_id
      WHERE r.recipe_id=?';
      if(!($stmt = $conn->prepare($sql)))
      {
         //Error
      }else if(!($stmt->bind_param('s', $id)))
      {
         //Error
      }else if(!($stmt->execute()))
      {
         //Error
      }else if(($sqlResult = $stmt->get_result()))
      {
         $result = new ArrayObject();
         $setInstr = true;
         while ($row = $sqlResult->fetch_assoc()) {
            if($setInstr)
            {
               $result['recipeName'] = $row["rName"];
               $result['instructions'] = $row["rInstructions"];
               $setInstr = false;
            }
            $message = new stdClass();
            $message->ingredient = $row["iName"];
            $message->amount = $row["amount"];
            $message->measurement = $row["iMeasure"];
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
?>
