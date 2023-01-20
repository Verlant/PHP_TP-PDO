<?php
include_once 'connexion.php';

$statement = $pdo->query("SELECT * FROM `mes_jeux` ORDER BY id");
// Renvoie la table mes_jeux
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupération et filtrage du paramètre GET
$options = array(
    'options' => array('min_range' => 1, 'max_range' => $result[count($result) - 1]['id']),
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

$sql = "SELECT * FROM `mes_jeux` WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$id = $result['id'];
$nom = $result['nom'];
$console = $result['console'];
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
        <form action="delete.php" method="post">
            <fieldset>
                <legend>Supression du jeu n°<?= $id ?> : <?= $nom ?> sur la console <?= $console ?></legend>
                <ul>
                    <li>Nom : <?= $nom ?></li>
                    <li>Console : <?= $console ?></li>
                </ul>
                <p>Voulez-vous supprimer ce jeux ?</p>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" value="Annuler" name="CANCEL">
                <input type="submit" value="Confirmer" name="OK">
            </fieldset>
        </form>
    </main>
</body>

</html>