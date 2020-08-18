<?php
require_once("phpQuery-onefile.php");
$html = file_get_contents('https://nakanishi.qss-system.net/blog.php');
$data = phpQuery::newDocument($html);

    $intro_h = $data['.intro-h > h1']->text();
    $intro_p = $data['.intro-p > p']->text();
    $search  = $data['.form-group > label']->text();
    $sidebar1 = $data['.sidebar > h5']->text();
    $sidebar2 = $data['.sidebar > ul > li > a']->text();
    $fnavi1    = $data['.left > ul > li > a']->text();
    $fnavi2   = $data['.right > ul > li']->text();
    //$article1 = $data['.article > li > a']->text();
    //$article2 = $data['.article > li > small']->text();


    echo $intro_h;
    echo $intro_p;
    echo $search;

    foreach ($data[".article"] as $dat){
      $article1 = pq($dat)->find('li > a')->text();
        echo $article1;
      $article2 = pq($dat)->find('li > small')->text();
        echo $article2;
      $article3 = pq($dat)->find('li > p')->text();
        echo $article3;
    }

    echo $sidebar1." ";
    echo $sidebar2;
    echo $fnavi1;
    echo $fnavi2;


?>
