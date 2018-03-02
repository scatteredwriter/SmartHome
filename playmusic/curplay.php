<?php
    header("Content-type: text/html; charset=utf-8");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $mysqli = new mysqli('localhost', 'pi', 'SmartHome', 'smarthome');
        $select='select * from curplay order by addtime limit 1';
        if (!$mysqli)
        {
            echo '';
            exit;
        }
        $result = $mysqli->query($select);
        $curplay_count = $result->num_rows;
        if($curplay_count > 0)
        {
            $row = $result->fetch_assoc();
            echo $row['singername'].' - '.$row['songname'];
        }
        else
            echo '';
        $result->free();
        $mysqli->close();
    }
    else {
        $mysqli = new mysqli('localhost', 'pi', 'SmartHome', 'smarthome');
        $select='select * from curplay order by addtime limit 1';
        if (!$mysqli)
        {
            echo '';
            exit;
        }
        $result = $mysqli->query($select);
        $curplay_count = $result->num_rows;
        if($curplay_count > 0)
        {
            $row = $result->fetch_assoc();
            echo $row['url'];
        }
        else
            echo '';
        $result->free();
        $mysqli->close();
    }
?>