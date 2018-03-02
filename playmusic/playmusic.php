<?php
    header("Content-type: text/html; charset=utf-8");
    $music='';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(!empty($_GET['songmid'])) {
            $songmid = $_GET['songmid'];
            $songname = $_GET['songname'];
            $singname = $_GET['singername'];
            $music = shell_exec('python3 music.py '.$_GET['songmid']);
            session_start();
            $username = $_SESSION['user'];
            echo $music;
            $mysqli = new mysqli('localhost', 'pi', 'SmartHome', 'smarthome');
            $insert = 'insert into curplay set songmid=\''.$songmid.'\',songname=\''.$songname.'\',singername=\''.$singname.'\',url=\''.$music.'\',username=\''.$username.'\'';
            if (!$mysqli)
            {
                echo '<p>无法连接到数据库！</p>';
                exit;
            }
            $result = $mysqli->query($insert);
        }
    }
    else{
        shell_exec('python3 changemusic.py');
    }
?>