<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>智能家居-语音广播</title>
</head>

<body>

    <?php
        session_start();
        if(!isset($_SESSION['user']))
            echo '<script language=\'javascript\' type=\'text/javascript\'>window.location.href="../index.php";</script>';
    ?>

    <form action="broadcast.php" method="post">
        <p>输入你想说的话：</p>
        <input class="text" type="text" name="text" />
        </br>
        <input class="submit" type="submit" name="submit" value="确定" />
    </form>

    <?php
        $mysqli = new mysqli('localhost', 'pi', 'SmartHome', 'smarthome');
        $select='select content from broadcast';
        if (!$mysqli)
        {
            echo '<p>无法连接到数据库！</p>';
            exit;
        }
        $result = $mysqli->query($select);
        $broadcast_count = $result->num_rows;
        if($broadcast_count > 0)
        {
            echo '<div class="history">';
            echo '<p class="title">历史广播记录：</p>';
            for($i = 0;$i < $broadcast_count;$i++)
            {
                $row = $result->fetch_assoc();
                echo "<p>".$row['content']."</p>";
            }
            echo '</div>';
        }
        $result->free();
        $mysqli->close();
    ?>

    <!-- <?php
            header("Content-type: text/html; charset=utf-8");
            $text = "";
            $txt = "history.txt";
            if(is_file($txt)){
                $file = fopen($txt,"r");
                $text = fread($file, filesize($txt));
                if($text){
                    $sens = explode("\n", $text);
                    echo '<div class="history">';
                    echo '<p class="title">历史广播记录：</p>';
                    for($i = 0; $i < count($sens); $i++){
                        echo "<p>".$sens[$i]."</p>";
                    }
                    echo '</div>';
                }
                fclose($file);
            }
        ?> -->

</body>

</html>