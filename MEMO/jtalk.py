# coding: UTF-8
import subprocess
from datetime import datetime


def jtalk(t):
    # depend on your install folder
    OPENJTALK_BINPATH = '/usr/local/src/open_jtalk-1.10/bin'
    OPENJTALK_DICPATH = '/usr/local/share/open_jtalk/open_jtalk_dic_utf_8-1.10'
    OPENJTALK_VOICEPATH = '/usr/local/share/hts_voice/mei/mei_normal.htsvoice'
    open_jtalk=[OPENJTALK_BINPATH + '/open_jtalk.exe']
    mech=['-x',OPENJTALK_DICPATH]
    htsvoice=['-m',OPENJTALK_VOICEPATH]
    speed=['-r','1.0']
    outwav=['-ow','open_jtalk.wav']
    cmd=open_jtalk+mech+htsvoice+speed+outwav
    c = subprocess.Popen(cmd,stdin=subprocess.PIPE)


    # play wav audio file with winsound module
    winsound.PlaySound('open_jtalk.wav', winsound.SND_FILENAME)



    print(('アルトリア・ペンドラゴン').encode('utf-8'))


# coding: UTF-8
"""
import os
import subprocess
import codecs

class JTalk:

    def __init__(self, talk_file, wav_file):
        self.talk_file = talk_file
        self.wav_file = wav_file
        self.enabled = 'off'

    # 音声ファイル作成メソッド
    def set_talk(self, text):
        target_file = codecs.open(self.talk_file, 'w', "utf_8")
        target_file.write(text)
        target_file.close()
        os.system('open_jtalk -x /usr/local/share/open_jtalk/open_jtalk_dic_utf_8-1.10 \
             -m /usr/local/share/hts_voice/mei/mei_normal.htsvoice \
              -ow %s %s' % (self.wav_file, self.talk_file))

    # 音声再生メソッド


def main():
    talk_file = 'talk.txt'  # 読み上げる文章を書き込むファイル
    wav_file = 'out.wav'  # 音声の出力ファイル
    text = '通常攻撃が全体攻撃で二回攻撃のお母さんは好きですか'
    # message.send(reply)→音声の順に処理すると同時再生っぽくなります
    jtalk = JTalk(talk_file, wav_file)
    jtalk.exe_talk(text)
if __name__ == "__main__":
    main()
"""








"""
import subprocess
from datetime import datetime

def jtalk(t):
    open_jtalk=['/usr/local/src/open_jtalk-1.10/bin/open_jtalk']
    mech=['-x','/usr/local/share/open_jtalk/open_jtalk_dic_utf_8-1.10']
    htsvoice=['-m','/usr/local/share/hts_voice/mei/mei_normal.htsvoice']
    speed=['-r','1.0']
    outwav=['-ow','/tmp/open_jtalk.wav']
    cmd=open_jtalk+mech+htsvoice+speed+outwav
    c = subprocess.Popen(cmd,stdin=subprocess.PIPE)
    c.stdin.write(t.encode('utf-8'))
    c.stdin.close()
    c.wait()
    aplay = ['aplay','-q','/tmp/open_jtalk.wav']
    wr = subprocess.Popen(aplay)

def say_datetime():
    d = datetime.now()
    text = '%s月%s日、%s時%s分%s秒' % (d.month, d.day, d.hour, d.minute, d.second)
    jtalk(text)

if __name__ == '__main__':
    say_datetime()
"""







"""
import subprocess

def jtalk(t):
    # depend on your install focd~lder
    OPENJTALK_BINPATH = '/usr/local/src/open_jtalk-1.10/bin'
    OPENJTALK_DICPATH = '/usr/local/share/open_jtalk/open_jtalk_dic_utf_8-1.10'
    OPENJTALK_VOICEPATH = '/usr/local/share/hts_voice/mei/mei_normal.htsvoice'
    open_jtalk=[OPENJTALK_BINPATH + '/open_jtalk.exe']
    mech=['-x',OPENJTALK_DICPATH]
    htsvoice=['-m',OPENJTALK_VOICEPATH]
    speed=['-r','1.0']
    outwav=['-ow','open_jtalk.wav']
    cmd=open_jtalk+mech+htsvoice+speed+outwav
    c = subprocess.Popen(cmd,stdin=subprocess.PIPE)
    c.stdin.write(t.encode('utf-8'))
    c.stdin.close()
    c.wait()
    aplay = ['aplay','-q','/usr/local/src/jtalk.wav']
    wr = subprocess.Popen(aplay)



    def say():
    text = '俺の妹がこんなに可愛いわけがない'
    jtalk(text)

    if __name__ == '__main__':
    say()
"""
