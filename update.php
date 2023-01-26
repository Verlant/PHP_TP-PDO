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
    $sql = "SELECT * FROM console WHERE nom_console = :nom_console";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':nom_console', $console, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // $pdo->beginTransaction();

    if ($result == false) {
        echo "La console " . $console . " n'existe pas, réessayez avec une console déjà existante.<br/>";
        echo "<a href='index.php'>Retour à l'accueil</a>";
        die;
    }

    //Pour des marqueurs plus explicite
    $sql_jeux = " UPDATE jeux SET nom_jeux = :nom_jeux, console_id = :console_id WHERE id_jeux = :id_jeux";
    $statement_jeux = $pdo->prepare($sql_jeux);
    $statement_jeux->bindParam(':id_jeux', $id, PDO::PARAM_INT);
    $statement_jeux->bindParam(':nom_jeux', $nom, PDO::PARAM_STR);
    $statement_jeux->bindParam(':console_id', $result["id_console"], PDO::PARAM_INT);
}

try {
    $statement_jeux->execute();
    echo "Le jeu n°" . $id . " a été modifié avec succès.<br/>";
    // $pdo->commit();
} catch (PDOException $e) {
    // throw $e;
    // var_dump($e);
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