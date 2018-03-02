<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>智能家居-播放音乐</title>
    <script type="text/javascript">
        function getcurplay() {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != '')
                        curmusic(xmlhttp.responseText);
                    else {
                        document.getElementById("curplaydiv").innerHTML = '';
                        document.getElementById("curplaydiv").style = "padding: 0px 0px 0px 0px;";
                        document.getElementById("playingmusic").innerHTML = '';
                        document.getElementById("playingmusic").style = "padding: 0px 0px 0px 0px;";
                        document.getElementById("downloaddiv").innerHTML = '';
                        document.getElementById("downloaddiv").style = "padding: 0px 0px 0px 0px;";
                    }
                }
            }
            xmlhttp.open("GET", "curplay.php", true);
            xmlhttp.send();
        }
        function playmusic(songmid, singername, songname) {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "playmusic.php?songmid=" + songmid + "&singername=" + singername + "&songname=" + songname, true);
            xmlhttp.send();
        }
        function changemusic() {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "playmusic.php", true);
            xmlhttp.send();
        }
        function curmusic(info) {
            document.getElementById("curplaydiv").innerHTML = '正在播放：' + info;
            document.getElementById("curplaydiv").style = "padding: 5px 0px 5px 0px;";
            document.getElementById("playingmusic").innerHTML = '<a href="javascript:changemusic();">点击切歌</a>';
            document.getElementById("playingmusic").style = "padding: 5px 0px 5px 0px;";
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("downloaddiv").innerHTML = '<a href="' + xmlhttp.responseText + '">点击下载歌曲</a>';
                    document.getElementById("downloaddiv").style = "padding: 5px 0px 5px 0px;";
                }
            }
            xmlhttp.open("POST", "curplay.php", true);
            xmlhttp.send();
        }
        window.setInterval(getcurplay,1000);
    </script>
</head>

<body>
    <?php
        session_start();
        if(!isset($_SESSION['user']))
            echo '<script language=\'javascript\' type=\'text/javascript\'>window.location.href="../index.php";</script>';
    ?>
    
    <form action="" method="post">
        <p>输入搜索关键字：</p>
        <input class="text" type="text" name="keyword" />
        </br>
        <input class="submit" type="submit" name="submit" value="搜索" />
        <div id="curplaydiv"></div>
        <div id="playingmusic"></div>
        <div id="downloaddiv"></div>
   </form>

    <?php              
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['keyword'])) {
                $url='http://i.y.qq.com/s.music/fcgi-bin/search_for_qq_cp?g_tk=5381&uin=0&format=jsonp&inCharset=utf-8&outCharset=utf-8&notice=0&platform=h5&needNewCode=1&w={0}&zhidaqu=1&catZhida=1&t=0&flag=1&ie=utf-8&sem=1&aggr=0&perpage=20&n=30&p=1&remoteplace=txt.mqq.all&_=1460982060643';
                $keyword = urlencode($_POST['keyword']);
                $url = str_replace('{0}',$keyword,$url);
                $result = file_get_contents($url);
                $result = str_replace('callback(','',$result);
                $result = substr($result,0,strlen($result)-1);
                $result = json_decode($result);
                if ($result != NULL) {
                    $list = $result->data->song->list;
                    if(count($list) > 0){
                        echo '<div class="musiclist">';
                        for($i = 0;$i < count($list) ; $i++){
                            $music = $list[$i];
                            $singer='';
                            for($j = 0; $j < count($music->singer); $j++) {
                                if($j > 0)
                                    $singer = $singer.'/';
                                $singer = $singer.$music->singer[$j]->name;
                            }
                            echo '<a class="music" href="javascript:playmusic(\''.$music->songmid.'\',\''.$singer.'\',\''.$music->songname.'\');">'.$singer.' - '.$music->songname.'</a>';
                        }
                        echo '</div>';
                    }
                }
            }
        }
    ?>

</body>

</html>