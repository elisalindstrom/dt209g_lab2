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
        <ul class="bucketlist">
            <?php foreach ($items as $item) { ?>
                <li>
                    <div class="list-top">
                        <div>
                            <h2><?= $item["name"]; ?></h2>
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
