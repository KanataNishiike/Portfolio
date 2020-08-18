<?php
session_start();

include_once('../includes/connection.php');
include_once('../includes/article.php');

$article = new Article;


if (isset($_SESSION['logged_in'])){
// 8/8
  if (isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM tag WHERE tag_id in(
       SELECT tag_id FROM tag_article WHERE article_id = ?
       )";
    $query = $pdo->prepare($sql);
    $query->bindValue(1,$id);
    $query->execute();

    $rows = $query->fetchall();

    $que = $pdo->prepare('SELECT * FROM articles WHERE article_id = ? ');
    $que->bindValue(1,$id);
    $que->execute();

    $r = $que->fetch();
// 8/8
}
    $title = $r['article_title'];


    if (isset($_POST['tag'])){
        $id = $_POST['id'];
        $tags = $_POST['tag'];
        foreach ($tags as $tag){
        $sql = "DELETE FROM tag_article WHERE article_id = ? and tag_id = ?";

        $query = $pdo->prepare($sql);
        $query->bindValue(1,$id);
        $query->bindValue(2,$tag);

        $query->execute();
      }
        header('Location: delete_tag.php');
    }

    $articles = $article->fetch_all();

    ?>

    <html>
      <head>
        <title>外し屋</title>
        <link rel="stylesheet" href="delete.css">

      </head>

      <body>
        <div class="list">
          <br />

          <h4>削除したい記事タグを選んでください:</h4>
          <form action="delete_tag.php" method="get" autocomplete="off">
            <select name="id">
              <?php foreach ($articles as $article) { ?>
                <option value="<?php echo $article['article_id'];?>">
                    <?php echo $article['article_title']; ?>
                </option>
              <?php } ?>
            </select>
            <input type="submit" value="表示">
          </form>



          <form action="delete_tag.php" method="post" autocomplete="off">
            <input type="text" name="id" value="<?php echo $id; ?>"  style="visibility:hidden;"/><br />
            <p>選択記事：<?php echo $title; ?></p>
            <p>タグ一覧：
              <?php foreach ($rows as $row){ ?>
                <input type="checkbox" style="margin-bottom:30px;" name="tag[]" value="<?php echo $row["tag_id"]; ?>">
                <?php echo $row["article_tag"]; ?>
              <?php } ?>
            </p>
            <br/>
            <input type="submit" class="btn1" value="決定" style="background-color:#000; border:#000; margin-top:40px; margin-bottom:70px;" />
          </form>

        <a href="index.php" class="btn">＞機能一覧</a>
      </div>
    </body>
  <html>

    <?php
} else {
  header('Location: index.php');
}

 ?>
