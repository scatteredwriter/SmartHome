# coding=utf-8

import requests
import re
import os
import sys

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'}


def getVkey():
    url = 'http://base.music.qq.com/fcgi-bin/fcg_musicexpress.fcg?json=3&guid=3449771088&g_tk=1840524495&hostUin=0&format=jsonp&inCharset=GB2312&outCharset=GB2312&notice=0&platform=yqq&needNewCode=0'
    result = requests.get(url, headers=headers)
    result = re.findall(r'"key": "(.*)"', result.text)
    vkey = result[0]
    return vkey


def getMusic(mid, vkey):
    url = 'http://dl.stream.qqmusic.qq.com/M500%s.mp3?vkey=%s&guid=3449771088&fromtag=27'
    if mid and vkey:
        url = url % (mid, vkey)
        return url


param = sys.argv[1]
music = getMusic(param, getVkey())
print(music)
