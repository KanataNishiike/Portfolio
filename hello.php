<?php
if (isset($_POST['voice'])){
    $voice = $_POST['voice'];
    $num = substr($voice, 48);
//exec関数
echo exec('phantomjs /var/www/html/hello.js '.$voice.' > /var/www/html/mp3/article'.$num.'.txt');
echo exec('jsay_make /var/www/html/mp3/article'.$num.'.txt /var/www/html/mp3/article'.$num.'.mp3');
}
?>
