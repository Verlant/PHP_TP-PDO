<?php
include_once 'connexion.php';

$statement = $pdo->query("SELECT * FROM `jeux` ORDER BY id_jeux");
// Renvoie la table mes_jeux
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupération et filtrage du paramètre GET
$options = array(
    'options' => array('min_range' => 1, 'max_range' => $result[count($result) - 1]['id_jeux']),
    'flags' => FILTER_NULL_ON_FAILURE
);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, $options);

// Vérification de l'existance et la valeur de la variable provenant du paramètre GET
if (!isset($id)) {
    echo "La variable id n'existe pas.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else if (empty($id)) {
    echo "La variable id est vide.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
};

$sql = "SELECT * FROM `jeux` JOIN console ON console_id = id_console WHERE id_jeux = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$id = $result['id_jeux'];
$nom = $result['nom_jeux'];
$console = $result['nom_console'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>

<body>
    <main>
        <form action="update.php" method="post">
            <fieldset>
                <legend>Modification du jeu n°<?= $id ?> : <?= $nom ?> sur la console <?= $console ?></legend>
                <input type="hidden" name="id" value="<?= $id ?>">
                <label for="nom">Nouveau nom : </label>
                <input type="text" name="nom" id="nom" value="<?= $nom ?>">
                <label for="console">Nouvelle console : </label>
                <input type="text" name="console" id="console" value="<?= $console ?>">
                <input type="reset" value="Effacer">
                <input type="submit" value="Ok" name="OK">
            </fieldset>
        </form>
    </main>
</body>

</html>