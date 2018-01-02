<?php
function createIngredient()
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
      $sql = "SELECT name FROM ingredient WHERE name=?";
      if(!($stmt = $conn->prepare($sql)))
      {
         //Error
      }else if(!($stmt->bind_param('s',$_POST['name'])))
      {
         //Error
      }else if(($stmt->execute()))
      {
         $stmt->store_result();
         if($stmt->num_rows > 0)
         {
            $message = new stdClass();
            $message->info = "Entry already exists";
            http_response_code(200);
            echo json_encode($message);
         }else
         {
            $qName = $_POST["name"];
            $qMeasure = $_POST["measurement"];
            $sql = "INSERT INTO ingredient(name, measurement) VALUES(?,?)";
            if(!($stmt = $conn->prepare($sql)))
            {
               //Error
            }else if(!($stmt->bind_param('ss', $qName, $qMeasure)))
            {
               //Error
            }else if(($stmt->execute()))
            {
               $message = new stdClass();
               $message->info = "Entry successfully created";
               http_response_code(201);
               echo json_encode($message);
            }else
            {
               $message = new stdClass();
               $message->info = "Something went wrong with the database";
               http_response_code(500);
               echo json_encode($message);
            }
         }
      }
   }
}
?>
