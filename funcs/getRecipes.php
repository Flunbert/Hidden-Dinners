<?php
function getRecipes()
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
      if(!($stmt = $conn->prepare('SELECT * FROM recipe')))
      {
         //Error
      }else if(!($stmt->execute()))
      {
         //Error
      }else if(($sqlResult = $stmt->get_result()))
      {
         $resultArray = new ArrayObject();
         while($row = mysqli_fetch_assoc($sqlResult))
         {
            $message = new stdClass();
            $message->id = $row["recipe_id"];
            $message->Name = $row["name"];
            $resultArray["recipes"][] = $message;
         }
         echo json_encode($resultArray);
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
?>
