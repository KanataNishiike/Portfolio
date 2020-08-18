<?php
  // DB接続
  include_once('includes/connection.php');
  include_once('includes/article.php');
  $article = new Article;

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $data = $article->fetch_data($id);

  $number = $data['article_id'];

  $sql = "UPDATE user_count SET counts = counts+1 WHERE article_id = $id";
  $query = $pdo->prepare($sql);
  $query->execute();

  $sql = "SELECT counts FROM user_count WHERE article_id = ?";
  $query = $pdo->prepare($sql);
  $query->bindValue(1,$id);
  $query->execute();
  $count = $query->fetch();
?>

<html lang="ja" dir="ltr">
 <head>
   <meta charset="utf-8 utf8_general_ci">
   <title><?php echo $data['article_title']; ?></title>
   <meta mame="description" content="Blogページです">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="article/css/article.css" type="text/css">
 </head>

<body>
<script language="JavaScript">
  function fb_button_tag(){
   var tag= '<div class="fb-like" data-href="{0}" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>';
   tag = tag.replace(/\{0\}/g, location.href);
   return tag;
  }
</script>
<script language="JavaScript">document.write(fb_button_tag());</script>
  <main>
    <div class="container">
      <div clas="row">
        <div class="col-xs-12 csl-sm-9" style="width:70%;">
          <div class="col-xs-12 wrap">
            <div id="text" class="text">
              <h6 id="date"><?php echo date('l jS',$data['article_timestamp']) ?></h6>
              <small id="eturan">閲覧数 <?php echo $count[0]; ?>回 </small>
              <h4 id="title"><?php echo $data['article_title']; ?></h4>
              <p style="margin-bottom:20px;" id="content"><?php  echo $data['article_content']; ?></p>
            </div>
          </div>
          <br />
        </div>
      </div>
    </div>
  </main>
</body>
</html>


<script>
$(document).ready(function(){

    $('#comment_form').on('submit',function(event){
       event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"add_comment.php",
            method:"POST",
            data:form_data,
            dataType:"JSON",
            success:function(data)
            {
                if(data.error != '')
                {
                    $('#comment_form')[0].reset();
                    $('#comment_message').html(data.error);
                    $('#comment_id').val('0');
                    load_comment();
                }
            }
        })
    });

    load_comment();

    function load_comment()
    {
      var number = <?php echo $number; ?>;
        $.ajax({
            url:"fetch_comment.php",
            method:"GET",
            data: {
              number: number,
            },
            success:function(data)
            {
                console.log(data);
                $('#display_comment').html(data);
            }
        })
    }

    $(document).on('click', '.reply', function(){
          var comment_id = $(this).attr("id");
          $('#comment_id').val(comment_id);
          $('#comment_name').focus();
    });
    $(document).on('click', '.cancel', function(){
          $('#comment_id').val('0');
    });


// if the user clicks on the like button ...
$('.like-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
    action = 'like';
  } else if($clicked_btn.hasClass('fa-thumbs-up')){
    action = 'unlike';
  }

  $.ajax({
    url: 'article.php',
    type: 'post',
    data: {
      'action': action,
      'post_id': post_id
    },
    success: function(data){
      res = JSON.parse(data);
      if (action == "like") {
        $clicked_btn.removeClass('fa-thumbs-o-up');
        $clicked_btn.addClass('fa-thumbs-up');
      } else if(action == "unlike") {
        $clicked_btn.removeClass('fa-thumbs-up');
        $clicked_btn.addClass('fa-thumbs-o-up');
      }
      // display the number of likes and dislikes
      $clicked_btn.siblings('span.likes').text(res.likes);
      $clicked_btn.siblings('span.dislikes').text(res.dislikes);

      // change button styling of the other button if user is reacting the second time to post
      $clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
    }
  });
});


// if the user clicks on the dislike button ...
$('.dislike-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
    action = 'dislike';
  } else if($clicked_btn.hasClass('fa-thumbs-down')){
    action = 'undislike';
  }
  $.ajax({
    url: 'article.php',
    type: 'post',
    data: {
      'action': action,
      'post_id': post_id
    },
    success: function(data){
      res = JSON.parse(data);
      if (action == "dislike") {
        $clicked_btn.removeClass('fa-thumbs-o-down');
        $clicked_btn.addClass('fa-thumbs-down');
      } else if(action == "undislike") {
        $clicked_btn.removeClass('fa-thumbs-down');
        $clicked_btn.addClass('fa-thumbs-o-down');
      }
      // display the number of likes and dislikes
      $clicked_btn.siblings('span.likes').text(res.likes);
      $clicked_btn.siblings('span.dislikes').text(res.dislikes);

      // change button styling of the other button if user is reacting the second time to post
      $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
      }
    });
  });
});

</script>


  <?php
} else {
  header('Location:blog.php');
  exit();
}

   ?>
