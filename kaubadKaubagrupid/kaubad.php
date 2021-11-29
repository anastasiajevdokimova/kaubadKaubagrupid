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
if(isset($_REQUEST["kauba_lisamine"])) {
    addItem($_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
    header("Location: kaubad.php");
    exit();
}
if(isset($_REQUEST["delete"])) {
    deleteItem($_REQUEST["delete"]);
    header("Location: kaubad.php");
}
if(isset($_REQUEST["save"])) {
    saveItem($_REQUEST["changed_id"], $_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["id"]);
    header("Location: kaubad.php");
}
$goods = ItemData($sort, $search_term);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title> Kaubad</title>
    </head>
    <body>
    <header class="header">
        <p><?= $_SESSION["kasutaja"]?> on sisse logitud</p>
        <form action="logout.php" method="post" class="logivalja">
            <input type="submit" value="Logi välja" name="logout">
        </form>
        <div class="container">
            <h1>Kaubade lisamine</h1>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <form action="kaubad.php">
                <input type="text" class="search" name="search_term" placeholder="Otsi...">
                <br>
            </form>
        </div>
        <?php if(isset($_REQUEST["edit"])): ?>
            <?php foreach($goods as $product): ?>
                <?php if($product->id == intval($_REQUEST["edit"])): ?>
                    <div class="container">
                        <form action="kaubad.php" class="editform">
                            <input type="hidden" name="changed_id" value="<?=$product->id ?>"/>
                            <input type="text" name="kaubanimi" value="<?=$product->kaubanimi?>" required>
                            <input type="text" name="hind" value="<?=$product->hind?>" required>
                            <?php echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "id"); ?>
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
                    <th><a class="link" href="kaubad.php?sort=kaubanimi">Kaubanimi</a></th>
                    <th><a class="link" href="kaubad.php?sort=hind">Hind</a></th>
                    <th><a class="link" href="kaubad.php?sort=kaubagrupp">Kaubagrupp</a></th>
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
                            <a title="Kustuta kaupa" class="deleteBtn" href="kaubad.php?delete=<?=$product->id?>"
                               onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                            <a title="Muuda kaupa" class="editBtn" href="kaubad.php?edit=<?=$product->id?>">&#9998;</a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="kaubad.php" class="lisamisvorm">
                <h2>Kauba lisamine:</h2>
                <dl>
                    <dt><br></dt>
                    <dd><input type="text" name="kaubanimi" placeholder="Sisesta kaubanimi..." required></dd>
                    <dt><br></dt>
                    <dd><input type="text" name="hind" placeholder="Sisesta hind..." required></dd>
                    <dt><br></dt>
                    <dd><?php
                        echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id");
                        ?></dd>
                    <br>
                    <input type="submit" name="kauba_lisamine" value="Lisa kaup">
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