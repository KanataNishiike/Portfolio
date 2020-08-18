<?php

  try {
    $pdo = new PDO('mysql:host=localhost;dbname=article;charset=utf8','root','karma7040');
  } catch (Expception $e){
    exit('Database error.');
  }

 ?>
