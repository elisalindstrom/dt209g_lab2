<?php
require_once "includes/config.php";
require_once "classes/Bucketlist.class.php";

// Skapar objekt
$bucketlist = new Bucketlist();

$name = "";
$description = "";
$priority = 0;
$message = "";

// Bekräftelse ny sak tillagd
if (isset($_GET["added"])) {
    $message .= "<p class 'message'>Ny sak tillagd!</p>";
}

// Radera post
if (isset($_GET["deleteid"])) {
    $deleteid = intval($_GET["deleteid"]);

    if ($bucketlist->deleteItem($deleteid)) {
        $message .= "<p class='message'>Saken har raderats!</p>";
    } else {
        $message .= "<p class='error message'>Fel vid raderingen!</p>";
    }
}

// Lägg till post
// Kontroll om formulär är skickat
if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $priority = intval($_POST["priority"]);

    $success = true;

    // Kontroll om formulär är ifyllt
    if (!$bucketlist->setName($name)) {
        $success = false;
        $message .= "<p class='error message'>Du måste ange ett namn!</p>";
    }

    if (!$bucketlist->setDescription($description)) {
        $success = false;
        $message .= "<p class='error message'>Du måste ange en beskrivning!</p>";
    }

    if (!$bucketlist->setPriority($priority)) {
        $success = false;
        $message .= "<p class='error message'>Du måste välja en prioritering!</p>";
    }

    if ($success) {
        if ($bucketlist->addItem($name, $description, $priority)) {
            header("Location: bucketlist.php?added=1");
            exit();
        } else {
            $message .= "<p class='error message'>Fel vid lagring!</p>";
        }
    }
}

$title = "Bucketlist";
include("includes/header.php");
?>

<section>
    <h1>Lägg till ny sak</h1>
    <form method="post" action="bucketlist.php" autocomplete="off">
        <?= $message; ?>
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
