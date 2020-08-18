// パラメタからurlを取得
var system_in = require('system');
args = system_in.args;
url = args[1];

var page = require('webpage').create();

page.open(url, function start(status){
    setTimeout(function(){
      var text = page.evaluate(function(){
        var content = document.getElementById("text").textContent;
              return content;
      });
      var comment = page.evaluate(function(){
        var comment = document.getElementById("display_comment").textContent;
              return comment;
      });
      var tag = page.evaluate(function(){
        var tag = document.getElementById("tag").textContent;
              return tag;
      });
      var archive = page.evaluate(function(){
        var archive = document.getElementById("archive").textContent;
              return archive;
      });
      var april = page.evaluate(function(){
        var april = document.getElementById("april").textContent;
              return april;
      });
      var march = page.evaluate(function(){
        var march = document.getElementById("march").textContent;
              return march;
      });
      var february = page.evaluate(function(){
        var february = document.getElementById("february").textContent;
              return february;
      });
      var itiran = page.evaluate(function(){
        var itiran = document.getElementById("itiran").textContent;
              return itiran;
      });
      var abec = page.evaluate(function(){
      var abec = document.querySelector('.comment h3').textContent;
              return abec;
      });

      var title = "なかにしブログ ";
      var article = "記事の内容 ";
      var come = " コメントの内容 "
      var com = " 名前を入力 ";
      var comme = " コメントを入力 ";
      var abc = " ";

      var test = new String();
      test += title;
      test += article;
      //記事の中身
      test += text;
      test += tag;
      test += com;
      test += comme;

      test += come;
      //コメントの中身
      test += abec;
      test += comment;
      test += archive;
      test += abc;
      test += april;
      test += abc;
      test += march;
      test += abc;
      test += february;
      test += abc;
      test += itiran;
      //テキスト表示されるよ～
      console.log(test);


    /*  var fs = CreateObject("Scripting.FileSystemObject");
      var file = fs.CreateTextFile("/var/www/html/mp3/test99.txt");
      file.Write(test);
      file.Close(); */
      phantom.exit();
    }, 5000);
});
