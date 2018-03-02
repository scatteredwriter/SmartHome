# coding=utf-8

import os
import pymysql


def changemusic():
    db = pymysql.connect('localhost', 'pi', 'SmartHome', 'smarthome')
    select = 'select * from curplay order by addtime limit 1'
    cursor = db.cursor()
    cursor.execute(select)
    result = cursor.fetchall()
    if cursor.rowcount > 0:
        result = result[0][0]
        if(result):
            os.system(
                'sudo kill $(ps aux | grep -m 3 %s | awk \'{print $2}\')' % result)


changemusic()
