<?php
$connect = new PDO('mysql:host=localhost;dbname=article;charset=utf8', 'nakanishi', 'kinniku0407');
$tag = $_POST['tag'];


$query = "
SELECT * FROM articles
WHERE article_tag = '$tag'
";

$statement = $connect->prepare($query);

$statement->execute();

$results = $statement->fetchAll();
$output = '';
$output = foreach ($results as $result){
    ?>
  <li>
    <a href="article.php?id=<?php echo $result['article_id']; ?>"
      style="font-family:'游ゴシック',和文フォント;">
      <?php echo $result['article_title']; ?>
    </a>
    ー<small>投稿日 <?php echo date('Y/n/j',$result['article_timestamp']); ?></small><br />
    <p style="margin-left:20px;">
      <?php
        $content = $result['article_content'];
        $limit = 20;
      if(mb_strlen($content) > $limit){
        $content = mb_substr($content,0,$limit);
        echo $content. ……続きを読む;
      } else{
        echo $result['article_content']. ……続きを読む;
      }
       ?><p>
  </li>
<?php }

}
echo $output;

?>
