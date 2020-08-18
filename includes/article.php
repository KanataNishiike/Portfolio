<?php

class Article{
  public function fetch_all(){
    global $pdo;

    if (isset($_POST['tag'])){
        $tag     = $_POST['tag'];
        $tags    = implode(",",$tag);

        $sql = "SELECT * FROM articles WHERE article_id in (
          SELECT article_id FROM tag_article WHERE tag_id in (
            SELECT tag_id FROM tag WHERE article_tag in (:tag)
          )
        )";
        $query = $pdo->prepare($sql);
        $query->bindParam(':tag', $tags);
        $query->execute();
      //return $query->fetchall();
      } else {
        $query = $pdo->prepare("SELECT * FROM articles");
        $query->execute();

    //return $query->fetchall();
  }
return $query->fetchall();
  }


  public function fetch_data($article_id){
    global $pdo;

    $query =$pdo->prepare("SELECT * FROM articles WHERE article_id = ?");
    $query->bindValue(1,$article_id);
    $query->execute();

    return $query->fetch();
  }
}
 ?>
