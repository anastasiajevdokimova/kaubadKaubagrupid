<?php
require("conf.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ab_login.php');
    exit();
}

require("functions.php");
$sort = "kaubanimi";
$search_term = "";
if(isset($_REQUEST["sort"])) {
    $sort = $_REQUEST["sort"];
}
if(isset($_REQUEST["search_term"])) {
    $search_term = $_REQUEST["search_term"];
}
if(isset($_REQUEST["kaubagrupi_lisamine"]) && ($_POST['kaubagrupp_nimi']) && isset($commodity_group)){
    addCommodityGroup($_REQUEST["kaubagrupp_nimi"]);
    header("Location: index.php");
    exit();
}
if(isset($_REQUEST["kauba_lisamine"]) && !empty($_POST['kaubanimi'])) {
    addItem($_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
    header("Location: index.php");
    exit();
}
if(isset($_REQUEST["delete"])) {
    deleteItem($_REQUEST["delete"]);
}
if(isset($_REQUEST["save"])) {
    saveItem($_REQUEST["changed_id"], $_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
}
$goods = ItemData($sort, $search_term);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title> Kaubad ja Kaubagrupid</title>
    </head>
    <body>
    <header class="header">
        <p><?= $_SESSION["kasutaja"]?> on sisse logitud</p>
        <form action="logout.php" method="post">
            <input type="submit" value="Logi välja" name="logout">
        </form>
        <div class="container">
            <h1>Tabelid |  Kaubad ja Kaubagrupid</h1>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <form action="index.php">
                <input type="text" name="search_term" placeholder="Otsi...">
            </form>
        </div>
        <?php if(isset($_REQUEST["edit"])): ?>
            <?php foreach($goods as $product): ?>
                <?php if($product->id == intval($_REQUEST["edit"])): ?>
                    <div class="container">
                        <form action="index.php">
                            <input type="hidden" name="changed_id" value="<?=$product->id ?>"/>
                            <input type="text" name="nimi" value="<?=$product->kaubanimi?>">
                            <input type="text" name="hind" value="<?=$product->hind?>">
                            <?php echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id"); ?>
                            <a title="Katkesta muutmine" class="cancelBtn" href="index.php" name="cancel">X</a>
                            <input type="submit" name="save" value="&#10004;">
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="container">
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th><a href="index.php?sort=nimi">Nimi</a></th>
                    <th><a href="index.php?sort=hind">Hind</a></th>
                    <th><a href="index.php?sort=kaubagrupp">Kaubagrupp</a></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($goods as $product): ?>
                    <tr>
                        <td><strong><?=$product->id ?></strong></td>
                        <td><?=$product->kaubanimi ?></td>
                        <td><?=$product->hind ?></td>
                        <td><?=$product->kaubagrupp ?></td>
                        <td>
                            <a title="Kustuta kaupa" class="deleteBtn" href="index.php?delete=<?=$product->id?>"
                               onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                            <a title="Muuda kaupa" class="editBtn" href="index.php?edit=<?=$product->id?>">&#9998;</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <form action="index.php">
                <h2>Kaubagrupi lisamine:</h2>
                <dl>
                    <dt>Kaubagrupi nimi:</dt>
                    <dd><input type="text" name="kaubagrupp_nimi" placeholder="Sisesta kaubagrupp..."></dd>
                    <input type="submit" name="kaubagrupi_lisamine" value="Lisa kaubagrupp">
                </dl>
            </form>
            <form action="index.php">
                <h2>Kauba lisamine:</h2>
                <dl>
                    <dt>Kaubanimi:</dt>
                    <dd><input type="text" name="kaubanimi" placeholder="Sisesta kaubanimi..."></dd>
                    <dt>Hind:</dt>
                    <dd><input type="text" name="hind" placeholder="Sisesta hind..."></dd>
                    <dt>Kaubagrupp</dt>
                    <dd><?php
                        echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id");
                        ?></dd>
                    <input type="submit" name="kauba_lisamine" value="Lisa kaup">
                </dl>
            </form>
        </div>
    </main>
    </body>
    </html>
<?php
/*
 * CREATE TABLE kaubad(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    kaubanimi varchar(100),
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