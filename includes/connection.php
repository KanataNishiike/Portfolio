<?php

  try {
    $pdo = new PDO('mysql:host=localhost;dbname=article;charset=utf8','root','');
  } catch (Expception $e){
    exit('Database error.');
  }

 ?>
