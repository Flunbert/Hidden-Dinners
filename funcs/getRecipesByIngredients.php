<?php
// function getRecipesByIngredients()
// {
//    getRecipesByIngsFilterAcc(0);
// }
function getRecipesByIngsFilterAcc($id,$acc)
{
  global $serverName, $userName, $password, $dbName;
  $ingredients = $_GET["ingredient"];
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
    $sql = "SELECT r.recipe_id rId, r.name rName
    FROM combination_table c
    JOIN recipe r ON c.recipe_id=r.recipe_id
    JOIN ingredient i ON c.ingredient_id=i.ingredient_id";
    $sql .= " WHERE";
    $paramType = '';
    foreach($ingredients as $index => $ing) {
      $paramType .= "s";
      if($index == 0)
      {
        $sql .= " i.name=?";
      }else
      {
        $sql .= " OR i.name=?";
      }
    }
    $paramType .= 'i';
    $sql .= " GROUP BY r.recipe_id HAVING COUNT(r.recipe_id) >= ?;";
    if(!($stmt = $conn->prepare($sql)))
    {
      //Error
    }else
    {
      $paramArray = array();
      $paramArray[] = $paramType;
      foreach($ingredients as $index => $ing) {
        $paramArray[] = $ing;
      }
      $paramArray[] = $acc;
      call_user_func_array(array($stmt, "bind_param"), $paramArray);
    }
    if(!($stmt->execute()))
    {
      //Error
    }else if($sqlResult = $stmt->get_result())
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
?>
