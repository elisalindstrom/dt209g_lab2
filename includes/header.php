<!doctype html>
<html lang="sv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $sitename . $divider . $title; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header class="header">
        <a href="index.php" class="logo">DT209G Laboration 2</a>

        <nav>
            <ul>
                <li><a href="bucketlist.php" class="<?= ($title == 'Bucketlist') ? 'active' : ''; ?>">Bucketlist</a></li>
                <li><a href="ai.php" class="<?= ($title == 'AI') ? 'active' : ''; ?>">AI</a></li>
            </ul>
        </nav>
    </header>

    <main class=" container">