<?php
//Instancie l'objet PDO
include_once 'connexion.php';

// Renvoie la table mes_jeux
$statement = $pdo->query("SELECT * FROM `jeux` ORDER BY id_jeux");
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$options = array(
    'options' => array('min_range' => 1, 'max_range' => $result[count($result) - 1]['id_jeux']),
    'flags' => FILTER_NULL_ON_FAILURE
);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, $options);

$nom = filter_input(INPUT_POST, 'nom');
$console = filter_input(INPUT_POST, 'console');

// Vérification de l'existance et la valeur de la variable provenant du paramètre POST
if (!isset($console) or !isset($nom) or !isset($id)) {
    echo "Erreur, la variable console et/ou nom et/ou id est inexistante.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else if (empty($console) or empty($nom) or empty($id)) {
    echo "Erreur, la variable console et/ou nom et/ou id est vide.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else {
    //Pour des marqueurs plus explicite
    $sql = " UPDATE jeux SET nom_jeux = :nom, console = :console WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':nom', $nom, PDO::PARAM_STR);
    $statement->bindParam(':console', $console, PDO::PARAM_STR);
}

try {
    $statement->execute();
    echo "Le jeu n°" . $id . " a été modifié avec succès.<br/>";
} catch (PDOException $e) {
    //throw $th;
    // var_dump($th);
    // echo $e->getMessage();
    echo "Une erreur est survenue lors de l'execution d'une requete à la base de donné.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <a href="index.php">Retour à l'accueil</a>
    </main>
</body>

</html>