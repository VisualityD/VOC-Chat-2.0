<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
include("cron.php");
$login = "";
if ($_COOKIE['login']) {
    $login = $_COOKIE['login'];
} elseif ($_SESSION['login']) {
    $login = $_SESSION['login'];
}
$form = "<form action='login.php' method='post'><div class='str'><input type='text' name='login' placeholder='Ник' value='".$login."' class='input'></div><div class='str'><input type='password' name='pass' class='input' placeholder='Пароль'></div><div class='str'><span class='left'>Страница входа:</span> <select name='go' class='input'><option value='1'>Моя страница</option><option>Чат</option></select></div><div class='str'><label><input type='checkbox' name='add' checked> Запомнить меня</label></div><div class='str'><button class='btn btn-info'><i class='icon-ok icon-white'></i> &nbsp;Войти</button></div></form>";

///заводим в чат робота
if (rand(1, 3) == 2) {
    $arr_ids = array(29, 30, 28, 10, 31, 32, 34);
    $login_id = rand(0, count($arr_ids));
    $ids = $arr_ids[$login_id]."+";
    $time = time() + 1800;
    @mysql_query("UPDATE users SET online='1',onlinetime='$time' WHERE id='$ids' LIMIT 1");
}
///заводим в чат робота
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $conf['chatname']; ?></title>
    <link rel="stylesheet" href="<?= $css_url; ?>bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="<?= $css_url; ?>all.css" type="text/css"/>
    <link rel="stylesheet" href="<?= $css_url; ?>index.css" type="text/css"/>
    <script>
        //выводим форму входа
        function noCoo() {
            $id('forma').innerHTML = "<?=$form;?>";
            delete_cookie("login");
            delete_cookie("pass");
        }

    </script>
    <!--[if IE]>
    <style>
        body {
            background-image: none !important;
            text-align: center;
            color: red !important;
            background-color: black !important;
            font-size: 18px;
        }
    </style>
    <script type="text/javascript">
        window.onload = function () {
            alert("Внимание! Ваш браузер будет не корректно работать с сайтом. Настойчиво рекомендуем использовать другой браузер (рекомендуем google chrome) для этого сайта. Извините за неудобства!");
        }
    </script>
    <![endif]-->
    <?
    include("copy_image.php"); ?>
</head>
<body>
<?php
if (!$connect) {
    $top = 1;
}
include("top.php"); ?>
<div id="main">
    <div id="m_left">
        <?php
        if (!$connect) { ?>
            <div class="m_top">Вход на сайт</div>
            <div id="forma">
                <?
                //проверяем может ли пользователь зайти в чат
                $loggg = $_COOKIE['login'];
                $passs = $_COOKIE['pass'];
                $sql_text_prov = "SELECT id FROM users WHERE login='$loggg' AND pass='$passs'	LIMIT 1";
                $sql_prov = mysql_query($sql_text_prov);
                if ($sql_prov) {
                    $sql_prov_arr = mysql_fetch_array($sql_prov);
                }
                if ($sql_prov_arr['id'] > 0 and isset($_COOKIE['pass']) and isset($_COOKIE['login'])) {
                    ?>
                    <br>
                    <form action="login.php" method="post">
                        <input type="hidden" name="coo" value="1">
                        Привет <b><?= $_COOKIE['login']; ?></b>!<br><br>
                        <button class="btn btn-info">Войти как <?= $_COOKIE['login']; ?></button>
                        <br>
                    </form>
                    или
                    <button onclick="noCoo()" class="btn">Сменить ник</button>
                    <br><br>

                <?php
                } else {
                    echo $form;
                    echo "<div class='regUrl'><a href=\"regestration.php\">Регистрация </a></div>";
                } ?>
            </div>
        <?php
        } else { ?>
            <div class="m_top">Навигация</div>
            <?php
            include("menu.php"); ?>
        <?php
        } ?>
    </div>
    <div id="m_right">
        <div class="m_top">Добро пожаловать</div>
        <div class="str2">
            <p>
                &nbsp;&nbsp; Социальные сети, чаты, онлайн игры, приложения, анонимные вопросовые порталы в посление время стали очень
                популярны и полезны в нашей жизни, а новые технологии растут быстрее чем люди успевают воспринимать и
                привыкать к ним. Наш сайт включает в себя самые новые технологии и в тоже время очень простой и понятный
                для любого пользователя, как продвинутого, так и новичка в интернете.
                <br>
                &nbsp;&nbsp; Зачем регистрироватся на разных
                сайтах где Вам на одном из них нравится общатся с друзьями, на другом знакомится и задавать анонимные
                вопросы другим, еще на одном играть в игры, если можно пользоватся всем этим на одном
                сайте и при этом совершенно бесплатно. Зайти на сайт можно без регистрации* придумав только себе
                ник и пароль. Позже уже можно подключить e-mail адрес чтобы обезопасить свой аккаунт и снять
                ограничения с него. Все просто, не так ли?
                <br>
                &nbsp;&nbsp; Пройдя легкую регистрацию перед Вами открываются много возможностей оформления
                своего ника, стиля, страници дабы выделится среди других пользователей. Структура онлайн игр
                и чата устроена так, что Вам несомненно захочется снова и снова заходить и быть активным на сайте,
                получать за это привелегии и хорошое настроение.
                <br>
                &nbsp;&nbsp; Еще сомневаетесь регистрироватся ли Вам? Просто
                попробуйте и потом решите, это быстро и бесплатно!

            <div class="top_photo">
                <span>Пару случайных фотографий, набравшие больше всего голосов:</span>

                <?php
                $alboms_text = "SELECT id,id_user,albom,photo,likes FROM photos WHERE likes > 0 AND id_user < 63 ORDER BY likes DESC, date DESC LIMIT 16";
                $albom_arr = mysql_query($alboms_text);
                if ($albom_arr) {
                    $photo = mysql_fetch_array($albom_arr);
                }
                do {
                    $id = $photo['id_user'];
                    $login = getLogin($id);
                    if (mb_strlen($login, "utf-8") > 9) {
                        $login = mb_substr($login, 0, 9, "utf-8")."..";
                    }
                    $dir_profile = "users/".floor(
                            $id / 1000
                        ).'/'.$id."/photos/".$photo['albom']."/mini".$photo['photo'].".jpg";
                    echo "<div class='photo'><a href='".$sile_url."/id".$id."?alb=".$photo['albom']."&photo=".$photo['id']."'><img src='".$dir_profile."' alt='$login'></a><div><a href='".$sile_url."/id".$id."'>$login</a> (".$photo['likes'].")</div></div>";
                } while ($photo = mysql_fetch_array($albom_arr));
                ?>

            </div>
            <br>
            <div class="center"><a href="pages/new.php" target="_blank">Нововведения</a></div>
            </p>
        </div>
    </div>

</div>

<script type="text/javascript" src="js/all.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<?php include("copy.php"); ?>
</body>
</html>
