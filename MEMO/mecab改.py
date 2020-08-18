# coding: UTF-8
import urllib.request, urllib.error
from bs4 import BeautifulSoup
import sys
import MeCab
import re #正規表現を使用するモジュール

# アクセスするURL
url = "https://nakanishi.qss-system.net/blog-r.php"
# URLにアクセスする 戻り値にはアクセスした結果やHTMLなどが入ったinstanceが帰ってきます
instance = urllib.request.urlopen(url)
# instanceからHTMLを取り出して、BeautifulSoupで扱えるようにパースします
soup = BeautifulSoup(instance, "html.parser")
# CSSセレクターを使って指定した場所のtextを表示します
text1 = soup.select_one("body > div.top > div > div.intro-p > p:nth-child(1)").text
text2 = soup.select_one("body > div.top > div > div.intro-p > p:nth-child(2)").text
text3 = soup.select_one("body > div.top > div > div.intro-p > p:nth-child(3)").text
text4 = soup.select_one("body > div.top > div > div.intro-p > p:nth-child(4)").text
text5 = soup.select_one("body > div.top > div > div.intro-p > p:nth-child(5)").text
text6 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > form > div > label").text
#text7 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > form > input[type=submit]").value
text7 = soup.select_one("#sidebar > h5").text

small = soup.find('span',{'class':'rating-count'}).text
print(small)

#記事
#article1 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > ol > div:nth-child(1) > li > a").text
#article2 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > ol > div:nth-child(1) > li > small:nth-child(2)").text
#article3 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > ol > div:nth-child(1) > li > small:nth-child(4)").text
#article4 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > ol > div:nth-child(1) > li > p:nth-child(6)").text
#article5 = soup.select_one("body > div.container > div > div.col-xs-12.csl-sm-9 > div.col-xs-12.wrap > ol > div:nth-child(1) > li > p:nth-child(7)").text



def change(text):
    def henkan(text):
        hiragana = [chr(i) for i in range(12353, 12436)]
        #chr()：組み込み関数。数値に応じ文字を返す。リスト一覧 https://qiita.com/okkn/items/3aef4458ed2269a59d63
        katakana = [chr(i) for i in range(12449, 12532)]
        kana = ""
        #読み仮名のカタカナを平仮名に。
        for text in list(text):
            for i in range(83):
                if text ==katakana[i]:
                    kana += hiragana[i]
        return kana

    mecab = MeCab.Tagger("-Ochasen")  #mecabを呼び出し
    mecab.parse('') #空で分析する必要がある。
    node = mecab.parseToNode(text)
    ccc = ""
    while node :
        origin = node.surface #元の単語を代入
        feature_list = node.feature.split(",")
        if len(feature_list)== 9:
            yomi   = feature_list[7] #読み仮名を代入.[7]はカンマ区切りの七番目にあるから。
            kana   = henkan(yomi) #変換関数を呼び出し、カタカナを平仮名に。

            #正規表現で漢字と一致するかをチェック
            pattern = "[一-龥]" #form用正規表現判定 https://qiita.com/fubarworld2/items/9da655df4d6d69750c06
            matchOB = re.match(pattern, origin) #漢字じゃない時はNone

            #originが空の時、漢字以外の時はふりがなを振る必要がないのでそのまま出力する。
            if origin != "" and matchOB:
                origin = list(origin)
                kana = list(kana)
                num1 = len(origin)
                num2 = len(kana)
                okurigana = ""

                if origin[num1-1] == kana[num2-1] and origin[num1-2] == kana[num2-2] :
                    okurigana = origin[num1-2] + origin[num1-1]

                    origin[num1-1] = ""
                    origin[num1-2] = ""
                    kana[num2-1] = ""
                    kana[num2-2] = ""

                    origin = "".join(origin)
                    kana   = "".join(kana)

                elif origin[num1-1] == kana[num2-1] :

                    okurigana = origin[num1-1]

                    origin[num1-1] = ""
                    kana[num2-1] = ""

                    origin = "".join(origin)
                    kana   = "".join(kana)

                else :
                    origin = "".join(origin)
                    kana   = "".join(kana)

                    ccc += "<ruby><rb>{0}</rb><rt>{1}</rt></ruby>{2}".format(origin, kana, okurigana)
                    #print("<ruby><rb>{0}</rb><rt>{1}</rt></ruby>{2}".format(origin, kana, okurigana),end="")
            else :
                ccc += origin
                #print(origin,end="")
        else :
            ccc += origin
            #print(origin,end="")
        node = node.next

    return ccc

ccc = change(text1)

file = "blog-r.php"
with open(file) as f:
    page = f.read()
    soup = BeautifulSoup(page, "html.parser")
    text = soup.select_one("body > div.top > div > div.intro-p > p:nth-child(1)").text

txt = page.replace(text,ccc)

with open(file, mode="w") as f:
    f.write(txt)
