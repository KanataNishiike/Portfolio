# coding:utf-8
import os
import codecs
import bs4


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
    def exe_talk(self, text):
        self.set_talk(text)

def main():
    talk_file = 'talk.txt'  # 読み上げる文章を書き込むファイル
    wav_file = 'open.wav'  # 音声の出力ファイル
    text = 'ニイタカヤマノボレ'
    # message.send(reply)→音声の順に処理すると同時再生っぽくなります
    jtalk = JTalk(talk_file, wav_file)
    jtalk.exe_talk(text)
if __name__ == "__main__":
    main()
