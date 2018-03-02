# coding=utf-8

import requests
import json
import re
import os
import time
import urllib.request
import threading
import pymysql


headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'}


text_file = '/var/www/html/smarthome/broadcast/text.txt'


def gettext():
    _file = open(text_file, 'r')
    result = _file.read()
    _file.close()
    os.remove(text_file)
    return result


def getvoice(text):
    text = urllib.parse.quote(text)
    tokenurl = 'https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=Pp1PNrUVnECO7LH7Ki4uQxnx&client_secret=0b1ab78a06e3b571c8e76143849b85d5'
    result = requests.get(tokenurl, headers=headers)
    result = json.loads(result.text)
    url = 'http://tsn.baidu.com//text2audio?tex=%s&tok=%s&lan=zh&ctp=1&cuid=7808972&pit=5&vol=15&per=0' % (
        text, result['access_token'])
    os.system('mpg123 -q "%s"' % url)


def getmusic():
    db = pymysql.connect('localhost', 'pi', 'SmartHome', 'smarthome')
    select = 'select * from curplay order by addtime limit 1'
    cursor = db.cursor()
    cursor.execute(select)
    result = cursor.fetchall()
    if cursor.rowcount > 0:
        result = result[0][3]
    else:
        result = None
    return result


def playover():
    db = pymysql.connect('localhost', 'pi', 'SmartHome', 'smarthome')
    select = 'select * from curplay order by addtime limit 1'
    cursor = db.cursor()
    cursor.execute(select)
    result = cursor.fetchall()
    if cursor.rowcount > 0:
        delete = 'delete from curplay where songmid=\'' + result[0][0] + '\''
        cursor.execute(delete)
        db.commit()
    db.close()


def broadcast():
    while True:
        try:
            text = gettext()
            print(text)
            if(text):
                getvoice(text)
        except:
            pass


def playmusic():
    while True:
        try:
            music = getmusic()
            print(music)
            if(music):
                os.system('mpg123 -q "%s"' % music)
                playover()
        except:
            pass


if __name__ == '__main__':
    broadcast_th = threading.Thread(target=broadcast, name='Broadcast')
    playmusic_th = threading.Thread(target=playmusic, name='PlayMusic')
    broadcast_th.start()
    playmusic_th.start()
    broadcast_th.join()
    playmusic_th.join()
