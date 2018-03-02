<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>智能家居平台-登录</title>
    <script language='javascript' type='text/javascript'>
        function error() {
            document.getElementById("error").innerHTML = '密码错误，请重试！';
        }
    </script>
</head>

<body>

    <?php
        session_start();
        if(isset($_SESSION['user']))
            echo '<script language=\'javascript\' type=\'text/javascript\'>window.location.href="./home.php";</script>';
    ?>

    <form class="login" action="" method="post">
        <label class="tips">请输入登录账户：</label>
        <input class="user" type="text" name="user" />
        </br>
        </br>
        <label class="tips">请输入登录密码：</label>
        <input class="password" type="password" name="password" />
        </br>
        <input class="submit" type="submit" name="submit" value="确定" />
        <p id="error"></p>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $_POST["user"];
            $password = $_POST["password"];
            $mysqli=new mysqli('localhost', 'pi', 'SmartHome', 'smarthome');
            if (!$mysqli)
            {
                echo '<p>无法连接到数据库！</p>';
                exit;
            }
            $select = 'select * from user where username=\''.$user.'\' and password=\''.$password.'\'';
            $result = $mysqli->query($select);
            $count = $result->num_rows;
            if($count > 0)
            {
                session_start();
                $_SESSION['user'] = $user;
                echo '<script language=\'javascript\' type=\'text/javascript\'>window.location.href="./home.php";</script>';
            }
            else
            {
                echo '<script language=\'javascript\' type=\'text/javascript\'>error();</script>';
            }
        }
    ?>

</body>

</html>