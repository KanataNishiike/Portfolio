var page = require('webpage').create();
var system = require("system");

page.open("https://nakanishi.qss-system.net/article.php?id=1", function (status) {
   waitFor(function check(){
       return page.evaluate(function () {
           // ensure #first and #last are in the DOM
           return !!document.getElementById("display_comment");
           //&& !!document.getElementById("last");
       });

   }, function onReady(){
       page.evaluate(function () {
           var data = {};
           data.one = document.getElementById("display_comment").innerText;
           //data.two = document.getElementById("last").innerText;
           return data;
        });
        callback(null, res);
        ph.exit();
   }, 5000); // some timeout
});
