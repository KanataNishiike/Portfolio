<?php
require_once("../phpQuery-onefile.php");

if (isset($_POST['voice'])){
    $voice = $_POST['voice'];

$html = file_get_contents($voice);
$data = phpQuery::newDocument($html);
$num = substr($voice, 48);



    $article1 = $data['#text > h6']->text();
    $article2 = $data['#text > small']->text();
    $article3 = $data['#text > h4']->text();
    $article4 = $data['#text > p']->text();
    $article5 = $data['.under > p']->text();
    $article6 = $data['.comment > h3']->text();
    $article7 = $data['.form-group']->find('input')->attr('placeholder');
    $article8 = $data['.form-group']->find('textarea')->attr('placeholder');
    $article9 = $data['.pull-right > h5']->text();
    $article10 = $data['.pull-right > ul > li > a']->text();

    $text = '';
    $text .= 'なかにしブログ ';
    $text .= $article1.' ';
    $text .= $article2;
    $text .= ' 記事のタイトル ';
    $text .= $article3;
    $text .= ' 記事の内容 ';
    $text .= $article4.' ';
    $text .= $article5." ";
    $text .= $article6.' ';
    $text .= $article7.' ';
    $text .= $article8.' ';
    $text .= $article9;
    $text .= $article10;

    file_put_contents("/var/www/html/mp3/article${num}.txt", $text);
    echo exec('jsay_make /var/www/html/mp3/article'.$num.'.txt /var/www/html/mp3/article'.$num.'.mp3');

}
?>
