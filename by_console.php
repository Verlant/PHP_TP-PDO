<?php
include_once 'connexion.php';

// Récupération et filtrage du paramètre GET
$regexp = '/^[A-Za-z0-9\s]*$|^$/';
$options = array(
    'options' => array('regexp' => $regexp),
    'flags' => FILTER_NULL_ON_FAILURE
);
$console = filter_input(INPUT_GET, 'console');

// Vérification de l'existance et la valeur de la variable provenant du paramètre GET
if (!isset($console)) {
    echo "Erreur, la variable console est inexistante<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else if (empty($console)) {
    echo "Erreur, la variable console est vide<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else {
    $sql = " SELECT * FROM mes_jeux WHERE console=:console ORDER BY nom";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':console', $console, PDO::PARAM_STR);
    $statement->execute();
};



$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeux par console</title>
</head>

<body>
    <main>
        <h1>Ma liste de jeux vidéos sur la console <?= $console ?>:</h1>
        <ul>
            <?php foreach ($result as $index => $table_row) : ?>
                <li><?= $table_row['nom'] ?>
                    <ul>
                        <li><a href="show_one.php?id=<?= $table_row['id'] ?>">Voir ce jeu en détail</a></li>
                        <li><a href="form_update.php?id=<?= $table_row['id'] ?>">Modifier ce jeux</a></li>
                    </ul>
                </li><br />
            <?php endforeach ?>
        </ul>
        <a href='index.php'>Retour à l'accueil</a>
    </main>
</body>

</html>