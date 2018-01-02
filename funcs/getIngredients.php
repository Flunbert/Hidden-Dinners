<?php
function getIngredients()
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
      $sql = "SELECT * FROM ingredient;";
      if(!($stmt = $conn->prepare($sql)))
      {
         //Error
      }else if(!($stmt->execute()))
      {
         //Error
      }else if($sqlResult = $stmt->get_result())
      {
         $result = new ArrayObject();
         while($row = mysqli_fetch_assoc($sqlResult))
         {
            $message = new stdClass();
            $message->id = $row["ingredient_id"];
            $message->name = $row["name"];
            $message->measurement = $row["measurement"];
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
