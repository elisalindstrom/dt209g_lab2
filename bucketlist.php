<?php
require_once "includes/config.php";
require_once "classes/Bucketlist.class.php";

$title = "Bucketlist";
include("includes/header.php");

// Skapar objekt
$bucketlist = new Bucketlist();

$name = "";
$description = "";
$priority = "";
?>

<section>
    <h1>Lägg till ny sak</h1>

    <form method="post" action="bucketlist.php" autocomplete="off">
        <?php
        // Radera post

        // Lägg till post
        // Kontroll om formulär är ifylld efter submitted
        if (isset($_POST["name"])) {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $priority = $_POST["priority"];

            $success = true;

            if (!$bucketlist->setName($name)) {
                $success = false;
                echo "<p class='error message'>Du måste ange ett namn!</p>";
            }

            if (!$bucketlist->setDescription($description)) {
                $success = false;
                echo "<p class='error message'>Du måste ange en beskrivning!</p>";
            }

            if (!$bucketlist->setPriority($priority)) {
                $success = false;
                echo "<p class='error message'>Du måste välja en prioritering!</p>";
            }

            if ($success) {
                if ($bucketlist->addItem($name, $description, $priority)) {
                    echo "<p class='message'>Ny sak tillagd!</p>";
                    $name = "";
                    $description = "";
                    $priority = 0;
                } else {
                    echo "<p class='error message'>Fel vid lagring!</p>";
                }
            }
        }
        ?>
        <div>
            <label for="name">Namn</label>
            <input id="name" name="name" type="text" value="<?= $name; ?>">
        </div>

        <div>
            <label for="description">Beskrivning</label>
            <textarea id="description" name="description" rows="2"><?= $description; ?></textarea>
        </div>

        <div>
            <label for="priority">Prioritet</label>
            <select id="priority" name="priority">
                <option value="0">Välj typ</option>
                <option value="1" <?= ($priority == 1) ? "selected" : ""; ?>>Hög</option>
                <option value="2" <?= ($priority == 2) ? "selected" : ""; ?>>Medel</option>
                <option value="3" <?= ($priority == 3) ? "selected" : ""; ?>>Låg</option>
            </select>
        </div>

        <button type="submit">Lägg till</button>
    </form>
</section>

<?php
// Hämta uppdaterad lista
$items = $bucketlist->getItems();
?>

<section>
    <h2>Min bucketlist</h2>
    <?php if (!empty($items)) { ?>
        <ul class="bucketlist">
            <?php foreach ($items as $item) { ?>
                <li>
                    <div class="list-top">
                        <div>
                            <h3><?= $item["name"]; ?></h3>
                            <p><?= $item["description"]; ?></p>
                        </div>
                        <div>
                            <?php
                            if ($item["priority"] == 1) {
                                $prio = "Hög";
                            } elseif ($item["priority"] == 2) {
                                $prio = "Medel";
                            } else {
                                $prio = "Låg";
                            } ?>
                            <p>Prio: <?= $prio; ?></p>
                            <p>Tillagd: <?= date("Y-m-d", strtotime($item["created_at"])); ?></p>
                        </div>
                    </div>
                    <div class="list-bottom">
                        <a href="bucketlist.php?deleteid=<?= $item["id"]; ?>">Ta bort</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Det finns inget sparat i din bucketlist!</p>
    <?php } ?>
</section>

<?php include("includes/footer.php");
