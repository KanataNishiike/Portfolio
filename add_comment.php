<?php

//add_comment.php

$connect = new PDO('mysql:host=localhost;dbname=article;charset=utf8', 'nakanishi', 'kinniku0407');

$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">名前が必要です。</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">コメントが必要です。</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if($error == '')
{
 $query = "
 INSERT INTO comment
 (parent_comment_id, comment, comment_sender_name, article_number)
 VALUES (:parent_comment_id, :comment, :comment_sender_name, :article_number)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id'   => $_POST["comment_id"],
   ':comment'             => $comment_content,
   ':comment_sender_name' => $comment_name,
   ':article_number'      => $_POST["article_number"]
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
