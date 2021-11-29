<?php
//kaubagruppide haldus
require("conf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ab_login.php');
    exit();
}

require("functions.php");

if(isset($_REQUEST["kaubagrupi_lisamine"])){
    addCommodityGroup($_REQUEST["kaubagrupp"]);
    header("Location: kaubagrupid.php");
    exit();
}
if(isset($_REQUEST["delete"])) {
    deleteCommodityGroup($_REQUEST["delete"]);
    header("Location: kaubagrupid.php");
}

$commondityGroup = CommondityGroupData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title> Kaubagrupide haldus</title>
</head>
<body>
<header class="header">
    <p><?= $_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logout.php" method="post" class="logivalja">
        <input type="submit" value="Logi välja" name="logout">
    </form>
    <div class="container">
        <h1>Kaubagrupide haldus</h1>
    </div>
</header>
<main class="main">
    <div class="container">
    <table>
    <tbody>
        <thead>
        <tr>
            <th>Id</th>
            <th>Kaubagrupp</th>
            <th></th>
        </tr>
        </thead>
            <?php foreach ($commondityGroup as $group): ?>
                <tr>
                    <td><strong><?=$group->id ;?></strong></td>
                    <td><?=$group->kaubagrupp ;?></td>
                    <td>
                        <a title="Kustuta kaubagrupp" class="deleteBtn" href="kaubagrupid.php?delete=<?=$group->id?>"
                           onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="kaubagrupid.php" class="lisamisvorm">
            <h2>Kaubagrupi lisamine:</h2>
            <dl>
                <dt><br></dt>
                <dd><input type="text" name="kaubagrupp" placeholder="Sisesta kaubagrupp..." required></dd>
                <br>
                <input type="submit" name="kaubagrupi_lisamine" value="Lisa kaubagrupp">
            </dl>
        </form>
    </div>
</main>
</body>
</html>
<?php
/*
 * CREATE TABLE maakond(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    maakonna_nimi varchar(100),
    maakonna_keskus varchar(100)
    );

INSERT INTO maakond(maakonna_nimi, maakonna_keskus)
VALUES ('Harjumaa', 'Tallinn');
INSERT INTO maakond(maakonna_nimi, maakonna_keskus)
VALUES ('Tartumaa', 'Tartu');

CREATE TABLE inimene(
    id int not null PRIMARY KEY AUTO_INCREMENT,
    eesnimi varchar(100),
    perekonnanimi varchar(100),
    maakonna_id int,
    FOREIGN KEY (maakonna_id) REFERENCES maakond(id)
    )
 * */
?>
