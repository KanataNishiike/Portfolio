<?php

    mysql_connect('localhost','nakanishi','kinniku0407');
    mysql_select_db('like');


 ?>


<html>
<head>
  <title>Like and Unlike</title>
  <style type="text/css">
  .content{
    width: 50%;
    margin: 100px auto;
    border: 1px solid #cbcbcb;
  }
  .post{
    width: 80%;
    margin: 10px auto;
    border: 1px solid #cbcbcb;
    padding: 10px;
  }
  </style>
</head>
<body>

<div class="content">
<?php
  $query = mysql_query("SELECT * FROM posts");

  while ($row = mysql_fetch_array($query)){  ?>
      <div class="post">
          <?php echo $row['text'];  ?><br>

          <?php
          $result = mysql_query("SELECT * FROM likes WHERE userid=1 AND postid=".$row['id']."");
          if (mysql_num_rows($result) == 1){ ?>
            <span><a href ="" class="unlike" id="<?php echo $row['id']; ?>">unlike</a></span>
        <?php } else { ?>
              <span><a href="" class="like" id="<?php echo $row['id']; ?>">like</a></span>
        <?php } ?>


          <span><a href="">like</a></span>
      </div>
    <?php } ?>

</div>


<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('.like').click(function(){
        var postid = $(this).attr('id');
        alert('You clicked on' + postid);
      });
  });

</script>
</body>
</html>
