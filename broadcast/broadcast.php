<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>已广播</title>
</head>

<body>
<?php
$text="";
$txt="text.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST["text"];
    session_start();
    echo '<p>'.$_SESSION['user'].' 正在说：'.$text.'</p>';
    $mysqli = new mysqli('localhost', 'pi', 'SmartHome', 'smarthome');
    $insert = 'insert into broadcast set content=\''.$text.'\',username=\''.$_SESSION['user'].'\'';
    if (!$mysqli)
    {
        echo '<p>无法连接到数据库！</p>';
        exit;
    }
    $result = $mysqli->query($insert);
    if($result)
    {
        $file=fopen($txt,"w");
        fwrite($file,$text);
        fclose($file);
    }
}

?>

</body>

</html>