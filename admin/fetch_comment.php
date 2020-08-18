<?php
$connect = new PDO('mysql:host=localhost;dbname=article;charset=utf8', 'nakanishi', 'kinniku0407');
$number = $_GET['number'];


$query = "
SELECT * FROM comment
WHERE parent_comment_id = '0' AND article_number = '$number'
ORDER BY comment_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
 $output .= '
 <div class="panel-default">
  <p>名前：'.$row["comment_sender_name"].' '.$row["date"].'</p>
  <li>'.$row["comment"].'</li>
  <div class="panel-footer1" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">返信</button></div>
  <div class="panel-footer2" align="right"><button type="button" class="btn btn-default cancel">キャンセル</button></div>
 </div>
 ';
 $output .= get_reply_comment($connect, $row["comment_id"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
 $query = "
 SELECT * FROM comment
 WHERE parent_comment_id = '".$parent_id."'
 ";
 $output = '';
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {
   $output .= '
   <div class="panel-default" style="margin-left:'.$marginleft.'px" value="'.$row["article_number"].'">
    <p>名前：'.$row["comment_sender_name"].' '.$row["date"].'</p>
    <li>'.$row["comment"].'</li>
    <div class="panel-footer3" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">返信</button></div>
    <div class="panel-footer4" align="right"><button type="button" class="btn btn-default cancel">キャンセル</button></div>
   </div>
   ';
   $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
  }
 }
 return $output;
}

?>
