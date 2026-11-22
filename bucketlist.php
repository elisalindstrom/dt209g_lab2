<?php
require_once "includes/config.php";
require_once "classes/Bucketlist.class.php";

$title = "Bucketlist";
include("includes/header.php");

// Skapar objekt
$bucketlist = new Bucketlist();

$items = $bucketlist->getItems();
?>

<section>
    <h1>Min bucketlist</h1>
    <?php if (!empty($items)) { ?>
        <ul>
            <?php foreach ($items as $item) { ?>
                <li>
                    <h2><?= $item["name"]; ?></h2>
                    <p><?= $item["description"]; ?></p>
                    <p>Prioritet: <?= $item["priority"]; ?></p>
                    <p>Tillagd: <?= $item["created_at"]; ?></p>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Det finns inget sparat i din bucketlist!</p>
    <?php } ?>
</section>

<?php include("includes/footer.php");
