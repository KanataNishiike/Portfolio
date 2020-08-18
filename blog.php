<?php
  // エラー表示
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // DBへのログイン
  include_once('includes/connection.php');
  // 記事情報
  include_once('includes/article.php');
  // タグによる記事検索
  if (isset($_POST['tag'])){
      $tag     = $_POST['tag'];
      $tags    = explode(", ",$tag);
      $tag     = "'".implode("','",$tags)."'";

      $sql = "SELECT * FROM articles WHERE article_id in (
        SELECT article_id FROM tag_article WHERE tag_id in (
          SELECT tag_id FROM tag WHERE article_tag in ($tag)
        )
      )";
      $query = $pdo->prepare($sql);
      $query->execute();
      $art = $query->fetchall();
      }

  $article = new Article;
  if (isset($_POST['tag'])){
    $articles = $art;
  } else {
    $articles = $article->fetch_all();
  }

  $sql = "UPDATE user_count SET counts = counts+1 WHERE article_id = 0";
  $query = $pdo->prepare($sql);
  $query->execute();
?>

<!doctype html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>なかにしブログ</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144193232-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-144193232-1');
    </script>

    <meta mame="description" content="Blog page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="includes/common.js"></script>
    <script src="includes/navigation.js"></script>
    <script src="includes/common.js"></script>
    <link rel="stylesheet" href="css/blog.css" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
  </head>

  <body>
    <div class="top" style="margin-top:80px;">
      <div class="intro">
        <div class="intro-h">
          <h1 style="padding-top: 10%; font-weight: 900;">なかにし</h1>
          <h1 style="padding-top: 30%; font-weight: 900;">ブログ</h1>
        </div>
        <div class="intro-p">
          <p style="font-weight: 900;">日頃の出来事を</p>
          <p style="font-weight: 900;">記録していく</p>
          <p style="font-weight: 900;">ブログです。</p>
          <p style="font-weight: 900;">主にラーメンの</p>
          <p style="font-weight: 900;">話題が多いです。</p>
        </div>
      </div>
    </div>

    <div class="container">
      <div clas="row">
        <div class="col-xs-12 csl-sm-9" style="width:80%; margin-left: -45px; margin-right: 45px;">
          <div class="col-xs-12 wrap">
            <!-- タグによる記事検索のフォーム -->
            <form action="blog.php" method="post" autocomplete="off">
              <div class="form-group">
                <label style="margin-right:380px;">タグ検索</label>
                <input type="text" name="tag" id="tag" class="form-control" style="width:300px;"/>
                <input type="submit" value="検索" style="margin-bottom:30px; margin-left:255px"/>
              </div>
            </form>

            <script>
              // タグ検索の入力フォームにおける選択項目の設定
              $(document).ready(function(){
                $('#tag').tokenfield({
                  autocomplete:{
                        source: [
                            {
                              "id": "1",
                              "value":'music'
                            },
                            {
                              "id": "2",
                              "value":'tech'
                            },
                            {
                              "id": "3",
                              "value":'book'
                            },
                            {
                              "id": "4",
                              "value":'everyday'
                            }
                                ],
                         delay:100
                                },
                  showAutocompleteOnFocus: true
                });

                $('#tag').on('tokenfield:createtoken', function (event) {
                  var existingTokens = $(this).tokenfield('getTokens');
                  $.each(existingTokens, function(index, token) {
                    if (token.value === event.attrs.value)
                    event.preventDefault();
                  });
                });
              });
              </script>

        <ol style="list-style:none; padding-inline-start:0px;">
          <?php
          // 記事データをDBから引っ張ってきて表示
          foreach ($articles as $article){
            $sql = "SELECT counts FROM user_count WHERE article_id = ?";
            $query = $pdo->prepare($sql);
            $query->bindValue(1,$article['article_id']);
            $query->execute();
            $count = $query->fetch();
            ?>
        <div class="article">
          <li style="background-color: #FDF5E6; border-radius: 30px; margin-bottom:25px;">
            <a href="article.php?id=<?php echo $article['article_id']; ?>"
               style="font-family:'游ゴシック',和文フォント; color:black; text-decoration:none;
               font-size:35px; margin-left: 30px;"><span><?php echo $article['article_title']; ?></span>
            </a>
            <small class="day">投稿日 <?php echo date('Y/n/j',$article['article_timestamp']); ?></small>
          <small>【<?php

          $aid = intval($article['article_id']);
           $sql = "SELECT article_tag FROM tag WHERE tag_id in(
              SELECT tag_id FROM tag_article WHERE article_id = ?
              )";
            $query = $pdo->prepare($sql);
            $query->bindValue(1,$aid);
            $query->execute();
            $tag_n = $query->fetchAll();
            $tag_name = [];
            foreach($tag_n as $tag){
              $tag_name[] = sprintf('<a href="includes/article_%s.php">%s</a>',
                $tag['article_tag'], $tag['article_tag']);
            }
            $tag = implode(" ", $tag_name);
            echo $tag;
            ?>】</small>
            <small class="number">閲覧数 <?php echo $count[0]; ?>回</small>
            <a href="article.php?id=<?php echo $article['article_id']; ?>" style="text-decoration:none;">
            <p class="content" style="margin-left:30px;">
              <?php
                  $content = $article['article_content'];
                  $limit = 20;
                    if(mb_strlen($content) > $limit){
                      $content = mb_substr($content,0,$limit);
                      echo $content. '……続きを読む';
                    } else{
                      echo $article['article_content']. '……続きを読む';
                    }
                     ?></p></a>
                </li>
              </div>
              <?php } ?>
            </ol>
            <div id="display_tag"></div>
          </div>
        </div>
      </div>
  </div>
    <div class="fnavi">
      <div class="left" style="padding-top:3%;">
        <ul>
          <li>
            <a href="index.html"><img src="image/green-star.png" height="50px" width="50px" style="margin-bottom: 5px;">トップ</a>
          </li>
          <li>
            <a href=""><img src="image/blue-star.png" height="50px" width="50px" style="margin-bottom: 5px;"><span class="book">本</span></a>
          </li>
          <li>
            <a href="fashion.html"><img src="image/skyblue-star.png" height="50px" width="50px" style="margin-bottom: 5px;">ファッション</a>
          </li>
        </ul>
      </div>
      <div class="right">
        <ul>
          <li>
            <a href="admin/index.php"><img src="image/orange-star.png" height="50px" width="50px" style="margin-bottom: 10px; color:black; ">管理者</a>
          </li>
        </ul>
      </div>
    </div>
  </body>
<style>
a{
  color:black;
}
</style>
</html>
