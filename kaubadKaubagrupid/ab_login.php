<?php
require("conf.php");
global $connection;
session_start();
/*if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}*/
if (!empty($_POST['login']) && !empty($_POST['pass'])){
    $login=htmlspecialchars(trim($_POST['login']));
    $pass=htmlspecialchars(trim($_POST['pass']));

    $sool='tavalinetext';
    $krypt=crypt($pass, $sool);
    //kontroll, et andmebaasis on selline kasutaja
    $paring="SELECT nimi, onAdmin, koduleht FROM kasutajad WHERE nimi=? AND parool=?";
    $kask=$connection->prepare($paring);
    $kask->bind_param("ss", $login, $krypt);
    $kask->bind_result($kasutaja, $onAdmin, $koduleht);
    $kask->execute();

    if($kask->fetch()){
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $kasutaja;
        $_SESSION['onAdmin'] = $onAdmin;
        if(isset($koduleht)){
            header("Location: $koduleht");
            exit();
        } else{
            header("Location: index.php");
            exit();
        }
    } else {
        echo "<p class='error'>Kasutaja $login või parool $krypt on vale!</p>";
    }
}
?>
    <link rel="stylesheet" href="style.css">
<div class="login_body">
    <div class="loginvorm">
    <div class="login_title">Kaubad ja Kaubagrupid</div>
    <div class="login_subtitle">Tere tulemast!</div>

    <form action="" method="post">

        <div class="input-container ilogin">
        <input type="text" class="input"  name="login" id="login" placeholder="Kasutaja nimi">
        </div>

        <div class="input-container ipass">
        <input type="password" class="input" name="pass" id="pass" placeholder="Salasõna">
        </div>


        <input type="submit" class="login_submit" value="Logi sisse">

    </form>
</div>
</div>
    <?php
    /*CREATE TABLE kasutajad(
        id int PRIMARY KEY AUTO_INCREMENT,
        nimi varchar (10),
        parool text)*/
    ?>