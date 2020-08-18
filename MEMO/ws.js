var page = require('webpage').create();
var url = "https://nakanishi.qss-system.net/article.php?id=1";

page.open(url, function() {
  const h4 = page.getElementById("titla");
  console.log(h4);
    phantom.exit();
});
