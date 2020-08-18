<?php
session_start();

include_once('../includes/connection.php');

if (isset($_SESSION[logged_in])){
  if (isset($_POST['title'],$_POST['content'],$_POST['tag'])){
      $title   = $_POST['title'];
      $content = $_POST['content'];
      $tag     = $_POST['tag'];
      $tags    = explode(", ",$tag);
      if (empty($title) or empty($content)){
        $error = '未入力があります';
      } else {
        $query = $pdo->prepare('INSERT INTO articles (article_title,article_content,article_timestamp) VALUES (?,?,?)');
        $query->bindValue(1,$title);
        $query->bindValue(2,$content);
        $query->bindValue(3,time());
        $query->execute();
        $id = $pdo->lastInsertId();

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

        $qu  = $pdo->prepare('INSERT INTO user_count (article_id) VALUES(?)');
        $qu->bindValue(1,$id);
        $qu->execute();
        }
        //header('Location:index.php');
      }
  }

  ?>

  <html>
   <head>
     <meta charset="utf-8">
     <title>記事制作</title>
     <meta mame="description" content="Blogページです">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- BootstrapのCSS読み込み -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <!-- jQuery読み込み -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- BootstrapのJS読み込み -->
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
              <div class="text">
                <form action="add.php" method="post" autocomplete="off">
                  <div class="input">
                    <label class="title">
                      <input type="text" name="title" placeholder="タイトル" /><br />
                    </label>
                  </div>
                  <div class="form-group">
                    <br/>
                    <label>記事のタグを入力してください。</label>
                    <input type="text" name="tag" id="tag" class="form-control" />
                  </div>
                  <textarea id="editor" value="内容" name="content" style="margin-bottom:30px;"></textarea>
                  <br/>
              </div>
              <input type="submit" class="btn2" value="決定 " />
              </form>

                <script>
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
                <br />
                <br />
                <p
                  style="
                         padding-bottom: 26px;
                         right: 30px;
                         position: fixed;
                         bottom: 10px;">
                  <a href="index.php" class="btn1">＞機能一覧</a>
                </p>
            </div>

            </div>
          </div>
          <div id="title-logo" class="top col-xs-12 csl-sm-3" style="width:30%;">
            <img src="../image/title.png" style="width: 80%;">
          </div>
        </div>
    </main>
  </body>
  </html>


  <?php
} else {
    header('Location: index.php');
}
 ?>
