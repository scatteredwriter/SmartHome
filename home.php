<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <script type="text/javascript">
        function logout() {
            window.location.href="home.php?logout=1";
        }
    </script>
    <title>智能家居平台</title>
</head>

<body>

    <?php
        session_start();
        if(!isset($_SESSION['user']))
            echo '<script language=\'javascript\' type=\'text/javascript\'>window.location.href="./index.php";</script>';
    ?>

    <p>目前可用功能</p>
    <div class="options">
        <a href="./broadcast">语音广播</a>
        </br>
        <a href="./playmusic">播放音乐</a>
        </br>
        <a href="javascript:logout();">账户注销</a>
        </br>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
            $logout = $_GET['logout'];
            unset($_SESSION['user']);
            echo '<script language=\'javascript\' type=\'text/javascript\'>window.location.href="./index.php";</script>';
        }
    ?>

</body>

</html>