<?php
// $nom = 'Dark Souls 3';
// $console = 'ps4';
// $sql = "INSERT INTO `mes_jeux` ( `nom`, `console` )
// VALUES (' " . $nom . " ', ' " . $console . "' );";
// //echo $sql . "<br>";
// $statement = $pdo->query($sql);

//dans $sql ?=marqueur
// $sql = " INSERT INTO mes_jeux ( nom, console ) VALUES ( ?, ?)";
// $statement = $pdo->prepare($sql);
// $nom = 'GTA V';
// $console = 'ps4';
// $statement->bindParam(1, $nom, PDO::PARAM_STR);
// $statement->bindParam(2, $console, PDO::PARAM_STR);

// var_dump(filter_input(INPUT_POST, 'OK'));
// echo "<br/>";
// var_dump(!empty($_POST));
$nom = filter_input(INPUT_POST, 'nom');
$console = filter_input(INPUT_POST, 'console');
//Instancie l'objet PDO
include_once 'connexion.php';

// Vérification de l'existance et la valeur de la variable provenant du paramètre POST
if (!isset($console) or !isset($nom)) {
    echo "Erreur, la variable console et/ou nom est inexistante.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else if (empty($console) or empty($nom)) {
    echo "Erreur, la variable console et/ou nom est vide.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else {
    //Pour des marqueurs plus explicite
    $sql = " INSERT INTO mes_jeux ( nom, console ) VALUES ( :nom, :console )";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':nom', $nom, PDO::PARAM_STR);
    $statement->bindParam(':console', $console, PDO::PARAM_STR);
};

try {
    $statement->execute();
    echo "Le jeu n°" . $pdo->lastInsertId() . " a été enregistré avec succès.<br/>";
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