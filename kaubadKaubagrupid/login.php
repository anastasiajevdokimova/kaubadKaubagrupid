<?php
//require("conf.php");
session_start();
/*if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}*/
if (!empty($_POST['login']) && !empty($_POST['pass'])){
    $login=$_POST['login'];
    $pass=$_POST['pass'];
    if ($login=='admin' && $pass=='admin'){
        $_SESSION['tuvastamine']='tere tulemast!';
        header('Location: kaubagrupid.php');
    }
    elseif($login=='tava' && $pass=='12346'){
        header('Location: kaubad.php');
    }
}
?>

<h1>Login vorm</h1>
<table>
    <form action="" method="post">
        <tr>
            <td>Kasutaja nimi</td>
            <td>
                <input type="text" name="login" placeholder="Kasutaja">
            </td>
        </tr>
        <tr>
            <td>Salasõna</td>
            <td>
                <input type="password" name="pass">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Logi sisse">
            </td>
        </tr>
    </form>
</table>
