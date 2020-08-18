<?php
  session_start();
  //ini_set( 'display_errors', 1 );
  //ini_set( 'error_reporting', E_ALL );

  include_once('../includes/connection.php');
  include_once('../includes/article.php');

  $article = new Article;

  $title   = '';
  $tag     = '';
  $content = '';

    // ログイン成功時
    if (isset($_SESSION['logged_in'])){
      //記事の取得
      if (isset($_GET['id'])){
      $id = $_GET['id'];
      $query = $pdo->prepare('SELECT * FROM articles WHERE article_id = ? ');
      $query->bindValue(1,$id);
      $query->execute();
      $row = $query->fetch();
    // エラー処理
    if(empty($row)) {
          exit;
          }

      $sql = "SELECT article_tag FROM tag WHERE tag_id in(
        SELECT tag_id FROM tag_article WHERE article_id = ?
      )";
      $query = $pdo->prepare($sql);
      $query->bindValue(1,$id);
      $query->execute();
      $tags = $query->fetchall();
      $title   = $row['article_title'];
      $content = $row['article_content'];
      //$tag = implode(',',$tags);
}
    //記事の更新
    if (isset($_POST['id'])){
      $id      = $_POST['id'];
      $title   = $_POST['title'];
      $content = $_POST['content'];
      $tag     = $_POST['tag'];
      $tags    = explode(", ",$tag);

      if (empty($title) or empty($content)){
        $error = '未入力があります！';
      } else {
        $query =$pdo->prepare("UPDATE articles
          SET article_title ='$title', article_content ='$content'
          WHERE article_id= ?");
        $query->bindValue(1, $id);
        $query->execute();
          }

      foreach ($tags as $tag){
      $result = $pdo->prepare("SELECT tag_id FROM tag WHERE article_tag = ?");
      $result->bindValue(1,$tag);
      $result->execute();
      $abc = $result->fetch();
      $abcd = $abc["tag_id"];

      $que = $pdo->prepare('INSERT INTO tag_article (article_id,tag_id) VALUES(?,?)');
      $que->bindValue(1,$id);
      $que->bindValue(2,$abcd);
      $que->execute();
      }
        header('Location:index.php');
    }
  $articles = $article->fetch_all();
?>


<html>
  <head>
    <meta charset="utf-8">
    <title>編集室</title>
    <meta mame="description" content="Blogページです">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../article/css/article.css" type="text/css">
    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
  </head>

  <body>
    <main>
      <div class="container">
        <div clas="row">
          <div class="col-xs-12 csl-sm-9" style="width:70%;">
            <div class="col-xs-12 wrap">
              <h4>記事の編集</h4>
              <?php if (isset($error)){ ?>
              <small style="color:#aa0000; padding-left:50px;"><?php echo $error; ?></small>
              <?php } ?>

              <h4>編集したい記事を選んでください:</h4>
                <form action="edit.php" method="get">
                  <select name="id">
                    <?php foreach ($articles as $article) { ?>
                  <option value="<?php echo $article['article_id'];?>">
                    <?php echo $article['article_title']; ?>
                  </option>
                    <?php } ?>
                  </select>
                  <input type="submit" value="編集">
                </form>

              <div class="text">
                <form action="edit.php" method="post" autocomplete="off">
                  <input type="text" name="id" value="<?php echo $id; ?>"  style="visibility:hidden;"/><br />
                  <div class="input">
                    <label class="title">
                      <input type="text" name="title" value="<?php echo $title; ?>" /><br />
                    </label>
                  </div>
                  <div class="form-group">
                    <label>記事のタグを入力してください。</label>
                      <input type="text" name="tag" id="tag" class="form-control"
                             value="<?php foreach ((array)$tags as $tag):?>
                             <?php echo $tag[0].','; ?>
                             <?php endforeach;?>"/>
                  </div>
                  <textarea id="editor" name="content" style="margin-bottom:30px;"><?php echo $content; ?></textarea>
                  <br/>
                  <input type="submit" class="btn2" value="決定 " />
                </form>

                <script type="text/javascript">
                  CKEDITOR.replace('editor', {
                      uiColor: '#EEEEEE',
                      height: 500,
                      width:'100%',
                      filebrowserBrowseUrl: '/admin/ckfinder/ckfinder.html',
                      filebrowserImageBrowseUrl: '/admin/ckfinder/ckfinder.html?Type=Images',
                      filebrowserUploadUrl: '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                      filebrowserImageUploadUrl: '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                      filebrowserWindowWidth : '1000',
                      filebrowserWindowHeight : '700'
                  });

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
              </div>
              <br />
              <br />
                  <p
                  style="
                    padding-bottom: 26px;
                    right: 30px;
                    position: fixed;
                    bottom: 10px;">
                  <a href="index.php" class="btn1">＞機能一覧</a></p>
            </div>
          </div>
          <div id="title-logo" class="top col-xs-12 csl-sm-3" style="width:30%;">
            <img src="../image/title.png" style="width: 80%;">
          </div>
        </div>
    </main>
      <p
        style="
            padding-bottom: 26px;
            right: 30px;
            position: fixed;
            bottom: 10px;">
          <a href="index.php" class="btn1">＞機能一覧</a>
      </p>
  </body>
</html>




  <?php
} else {
    header('Location: index.php');
}
 ?>
