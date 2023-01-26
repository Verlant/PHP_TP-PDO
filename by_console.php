<?php
include_once 'connexion.php';

// Renvoie la table console
$statement = $pdo->query("SELECT * FROM `console` ORDER BY id_console");
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupération et filtrage du paramètre GET
$options = array(
    'options' => array('min_range' => 1, 'max_range' => $result[count($result) - 1]['id_console']),
    'flags' => FILTER_NULL_ON_FAILURE
);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, $options);

$sql = "SELECT * FROM `console` WHERE id_console = :id_console";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id_console', $id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$console = $result['nom_console'];

// Vérification de l'existance et la valeur de la variable provenant du paramètre GET
if (!isset($id)) {
    echo "Erreur, la variable id est inexistante<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else if (empty($id)) {
    echo "Erreur, la variable id est vide<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else {
    $sql = " SELECT * FROM jeux JOIN console ON console_id = id_console WHERE id_console=:id_console ORDER BY nom_jeux";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id_console', $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
};


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
                <li><?= $table_row['nom_jeux'] ?>
                    <ul>
                        <li><a href="show_one.php?id=<?= $table_row['id_jeux'] ?>">Voir ce jeu en détail</a></li>
                        <li><a href="form_update.php?id=<?= $table_row['id_jeux'] ?>">Modifier ce jeux</a></li>
                    </ul>
                </li><br />
            <?php endforeach ?>
        </ul>
        <a href='index.php'>Retour à l'accueil</a>
    </main>
</body>

</html>