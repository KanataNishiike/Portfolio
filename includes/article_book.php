<?php
include_once('connection.php');

class Article{
  public function fetch_all(){
    global $pdo;

$book = 'book';
    $sql = "SELECT * FROM articles WHERE article_id in (
      SELECT article_id FROM tag_article WHERE tag_id in (
        SELECT tag_id FROM tag WHERE article_tag = :tag
        )
       )";
     $query = $pdo->prepare($sql);
     $query->bindValue(':tag',$book);
     $query->execute();

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


$article = new Article;
$articles = $article->fetch_all();
 ?>

 <!doctype html>
 <html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>なかにしブログ／BOOK</title>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144193232-1"></script>
     <script>
       window.dataLayer = window.dataLayer || [];
       function gtag(){dataLayer.push(arguments);}
       gtag('js', new Date());
       gtag('config', 'UA-144193232-1');
     </script>

    <meta mame="description" content="Blogページです">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- BootstrapのCSS読み込み -->
     <link href="css/bootstrap.min.css" rel="stylesheet">
     <!-- jQuery読み込み -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <!-- BootstrapのJS読み込み -->
     <script src="js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="../css/blog.css" type="text/css">
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
   <div class="top">
   <div class="intro">
     <div class="intro-h">
       <h1><span class="text-1">なかにし</h1>
       <h1><span class="text-2">ブログ</span></h1>
     </div>
     <div class="intro-p">
       <p class="text-3">日頃の出来事を</p>
       <p class="text-4">記録していく</p>
       <p class="text-5">ブログです。</p>
       <p class="text-6">主にラーメンの</p>
       <p class="text-7">話題が多いです。</p>
     </div>
   </div>
   </div>

   <div class="container">
     <div clas="row">
     <div class="col-xs-12 csl-sm-9" style="width:80%">
     <div class="col-xs-12 wrap">
       <h1>Book</h1>
       <ol style="list-style:none;">
         <?php foreach ($articles as $article){
         $aid = intval($article['article_id']);
         echo '<br>';
         //var_dump($aid)の出力＝「int(1)」intval()の場合
          $sql = "SELECT article_tag FROM tag WHERE tag_id in(
             SELECT tag_id FROM tag_article WHERE article_id = ?
             )";
           $query = $pdo->prepare($sql);
           $query->bindValue(1,$aid);
           $query->execute();
           $tag_n = $query->fetchAll();
           $tag_name = '';
           foreach($tag_n as $tag){
             $tag_name .= '<a href="article_'.$tag[0].'.php">'.' '.$tag[0].'</a>';
           }
           ?>
            <li>
              <a href="article.php?id=<?php echo $article['article_id']; ?>"
                style="font-family:'游ゴシック',和文フォント; color:black; text-decoration:none; font-size:35px;">
                <?php echo $article['article_title']; ?>
             </a>
             ー<small>投稿日 <?php echo date('Y/n/j',$article['article_timestamp']); ?></small>
             　<small>【<?php echo($tag_name); ?> 】</small>
             <p style="margin-left:20px;">
               <?php
                   $content = $article['article_content'];
                   $limit = 20;
                     if(mb_strlen($content) > $limit){
                       $content = mb_substr($content,0,$limit);
                       echo $content. '……続きを読む';
                     } else{
                       echo $article['article_content']. '……続きを読む';
                     }
                      ?><p>
                 </li>
               <?php } ?>
             </ol>
             <div id="display_tag"></div>
           </div>

           <div class="col-xs-12 navigation">
             <div class="pull">
               <p>
                 <a href=""><span>←</span></a>
                 <a href="blog.html"><span style="text-decoration-line: underline; text-decoration-color: orange;">1</span></a>
                 <a href=""><span>2</span></a>
                 <a href=""><span>3</span></a>
                 <a href=""><span>→</span></a>
               </p>
             </div>
           </div>
         </div>
         <div id="sidebar" class="col-xs-12 csl-sm-3" style="width: 20%;">
           <span class="hedden-xs"><h5>タグ検索</h5>
             <ul style="list-style:none;">
               <li><a href="article_music.php">Music</a></li>
               <li><a href="article_tech.php">Tech</a></li>
               <li><a href="article_book.php">Book</a></li>
               <li><a href="article_everyday.php">Everyday</a></li>
               <li><a href="../blog.php">All</a></li>
               <li><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false"></a>
                 <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></li>
             </ul>
           </span>
         </div>
       </div>
     </div>

     <div class="fnavi">
       <div class="left">
         <ul>
           <li>
             <a href="index.html"><img src="../image/green-star.png" height="50px" width="50px"
               style="margin-bottom: 5px;">トップ</a>
           </li>
           <li>
             <a href="book.html"><img src="../image/blue-star.png" height="50px" width="50px"
               style="margin-bottom: 5px;">本</a>
           </li>
           <li>
             <a href="fashion.html"><img src="../image/skyblue-star.png" height="50px" width="50px"
               style="margin-bottom: 5px;">ファッション</a>
           </li>
           <li>
             <a href="test_php/index.php"><img src="../image/skyblue-star.png" height="50px" width="50px"
               style="margin-bottom: 5px;">test</a>
           </li>

         </ul>
       </div>
       <div class="right">
         <ul>
           <li>
             <img src="../image/pink-star.png" height="50px" width="50px" style="margin-bottom: 5px;">サイトマップ
           </li>
           <li>
             <img src="../image/orange-star.png" height="50px" width="50px" style="margin-bottom: 10px;">お問い合わせ
           </li>
           <li>
             <a href="admin/index.php"><img src="../image/orange-star.png" height="50px" width="50px" style="margin-bottom: 10px; color:black;">あどみん！</a>
           </li>
           <li>
             <a href="index_like.php"><img src="../image/orange-star.png" height="50px" width="50px" style="margin-bottom: 10px; color:black;">test room！</a>
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
