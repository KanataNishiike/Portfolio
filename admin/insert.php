<?php
if(isset($_POST["name"]))
{
  $connect = new PDO("mysql:host=localhost;dbname=article;charset=utf8", "nakanishi", "kinniku0407");
  $query = "INSERT INTO test(name, skill) VALUES(:name, :skill)";
  $statement = $connect->prepare($query);
  $statement->execute(
  array(
    ':name'  => $_POST["name"],
    ':skill' => $_POST["skill"]
    )
  );
  $result = $statement->fetchAll();
  $output = '';
 if(isset($result))
 {
  $output = '
  <div class="alert alert-success">
   Your data has been successfully saved into System
  </div>
  ';
 }
 echo $output;
}

?>
