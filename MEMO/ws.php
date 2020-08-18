<?php
//phpqueryの読み込み
require_once("phpQuery-onefile.php");
//PHP Phantomjsの読み込み
require_once("vendor/autoload.php");
use JonnyW\PhantomJs\Client;
//インスタンスの取得
$client = Client::getInstance();
//リクエストとレスポンスオブジェクト作成
$request  = $client->getMessageFactory()->createRequest();
$response = $client->getMessageFactory()->createResponse();
//URLの指定と実行
$url = 'https://nakanishi.qss-system.net/article.php?id=1';
$request->setUrl($url);
$client->send($request, $response);
//js実行後のhtmlの取得
$html = $response->getContent();
//DOMDocumentにする
$dom = new DOMDocument;
@$dom->loadHTML($html);
//$htmlになんらかのHTML的invalidがあるので、@をつける
$dom->saveHTML();
//phpQueryでスクレイピングする
$data = phpQuery::newDocument($dom);
echo $data;

//午後やること
//１ ws.phpでDOM操作→コマンドプロンプト確認。
//２ voice.phpからws-article.phpにajax送信。

//$article1 = $data['.text > h6']->text();
/*$article2 = $data['.text > small']->text();
$article3 = $data['.text > h4']->text();
$article4 = $data['.text > p']->text();
$article5 = $data['.under > p']->text();
$article6 = $data['.comment > h3']->text();
$article7 = $data['.form-group']->find('input')->attr('placeholder');
$article8 = $data['.form-group']->find('textarea')->attr('placeholder');
$article9 = $data['.pull-right > h5']->text();
$article10 = $data['.pull-right > ul > li > a']->text(); */

//echo 'なかにしブログ ';
//echo $article1.' ';
/*echo $article2;
echo ' 記事のタイトル ';
echo $article3;
echo ' 記事の内容 ';
echo $article4;
echo $article5." ";
echo $article6.' ';
echo $article7.' ';
echo $article8.' ';
echo $article9;
echo $article10; */

/*foreach ($response[".panel-default"] as $dat){
      $article1 = pq($dat)->find('p')->text();
        echo $article1;
      $article2 = pq($dat)->find('li')->text();
        echo $article2;
      $article3 = pq($dat)->find('.panel-footer1 > button')->text();
        echo $article3;
    } */

?>
