<?php
session_start();
  include_once('../includes/connection.php');
  if (isset($_SESSION['logged_in'])){
?>

  <html>
    <head>
      <title>管理人室</title>
      <link rel="stylesheet" href="index_after.css">
      </head>

    <body>
      <div class="list">
      <h3 style="margin-top:80px;">～機能一覧～</h3>
      <ol style="margin-top:30px;">
        <li style="display: inline-block; padding-right:40px;"><a href="add.php" class="btn1">記事の追加</a></li>
        <li style="display: inline-block; padding-left:40px;"><a href="edit.php" class="btn2">記事の編集</a></li><br />
        <li style="display: inline-block; padding-right:40px; padding-top:40px;"><a href="delete.php" class="btn3">記事の削除</a></li>
        <li style="display: inline-block; padding-left:40px;"><a href="delete_tag.php" class="btn2">タグの削除</a></li><br />
        <li style="display: inline-block; padding-right:40px; padding-top:40px;"><a href="logout.php" class="btn4">ログアウト</a></li>
        <li style="display: inline-block; padding-left:40px;"><a href="../blog.php" class="btn5">Blogページ</a></li><br />
        <li style="display: inline-block; padding-right:11px; padding-top:40px;;"><a href="voice.php" class="btn4">音声の作成</a></li>
      </ol>
      </div>
    </body>
  <html>

<?php
} else {
  if (isset($_POST['username'],$_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) or empty($password)){
      $error = '入力漏れがあります';
    } else {
      $query = $pdo->prepare("SELECT * FROM users WHERE user_name = ? AND user_password = ?");

      $query->bindValue(1,$username);
      $query->bindValue(2,$password);

      $query->execute();
      $num = $query->rowCount();

      if($num == 1){
        $_SESSION['logged_in'] = true;
        header('Location:index.php');
        exit();
      } else {
        $error = '入力に誤りがあります';
      }
    }
  }
?>

  <html>
      <head>
        <title>認証</title>
        <link rel="stylesheet" href="index_before.css">
      </head>

      <body>
        <div class="code">
          <br />
          <h3 style="color:#FF4F02;">【管理者認証】</h3>
          <?php if (isset($error)) { ?>
            <p style="color:#aa0000; z-index:5;"><?php echo $error; ?></p>
          <?php } ?>

          <form action="index.php" method="post" autocomplete="off">
              <div class="name">
              <input type="text" name="username" class="text" placeholder="">
              <label>name：</label>
              <span class="focus_line"><i></i></span>
              </div>
              <div class="word">
              <input type="password" name="password" class="text" placeholder="">
              <label>password：</label>
              <span class="focus_line"><i></i></span>
              </div>
              <input type="submit" class="submit" value="入室" />
          </form>
          <br />
          <a href="../blog.php" style="z-index:5;" class="btn">＞ブログ一覧</a>
        </div>
      </body>
    <html>
<?php } ?>
