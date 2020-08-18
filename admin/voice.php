<?php
session_start();
include_once('../includes/connection.php');
include_once('../includes/article.php');
$article = new Article;
if (isset($_SESSION['logged_in'])){
?>

    <html>
      <head>
        <title>音声作成</title>
        <link rel="stylesheet" href="delete.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
      </head>

      <body style="margin:0;">
        <div class="list"><br />
          <h4>音声作成する記事のURLを入力してください：</h4>
          <form action="" method="post" id="comment_form" autocomplete="off">
            <span>URL： </span><input type="text" name="voice" size="40"><br>
            <input id='submit' type="submit" value="決定">
          </form>
          <form method="POST" id="comment_form">
          </form>
          <a href="index.php" class="btn">＞機能一覧</a>
      　</div>
    </body>
  </html>

<script>
$(document).ready(function(){
    $('#comment_form').on('submit',function(event){
       event.preventDefault();
        var voice = $(this).serialize();
        $.ajax({
            url:"../hello.php",
            method:"POST",
            data:voice,
            dataType:"JSON",
            success:function(data)
            {
                if(data.error != '')
                {
                    //document.write('作成成功！');
                }
            }
        })
        setTimeout("location.reload()",3000);
    });
});
</script>

<?php
} else {
  header('Location: index.php');
}
?>
