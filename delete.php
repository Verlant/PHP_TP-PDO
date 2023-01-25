<?php
include_once 'connexion.php';

$statement = $pdo->query("SELECT * FROM `jeux` ORDER BY id_jeux");
// Renvoie la table mes_jeux
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupération et filtrage du paramètre POST
$options = array(
    'options' => array('min_range' => 1, 'max_range' => $result[count($result) - 1]['id_jeux']),
    'flags' => FILTER_NULL_ON_FAILURE
);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, $options);

$CANCEL = filter_input(INPUT_POST, 'CANCEL');
$OK = filter_input(INPUT_POST, 'OK');

// Vérification de l'existance et la valeur de la variable provenant du paramètre POST
if (!isset($id)) {
    echo "La variable id n'existe pas.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
} else if (empty($id)) {
    echo "La variable id est vide.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
    die;
}

if (isset($OK) and !empty($OK) and $OK == "Confirmer") {
    $sql = "DELETE FROM `jeux` WHERE id_jeux = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $statement->execute();
        echo "Le jeu n°" . $id . " a été supprimé avec succès.<br/>";
        echo "<a href='index.php'>Retour à l'accueil</a>";
    } catch (\Throwable $th) {
        //throw $th;
        echo "Une erreur est survenue lors de l'execution d'une requete à la base de donné.<br/>";
        echo "<a href='index.php'>Retour à l'accueil</a>";
    }
} else if (isset($CANCEL) and !empty($CANCEL) and $CANCEL == "Annuler") {
    echo "La demande de suppression du jeux " . $id . " a été annulé.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
} else {
    echo "Une erreur inconnue est survenue.<br/>";
    echo "<a href='index.php'>Retour à l'accueil</a>";
}
