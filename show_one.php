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
    die;
} else if (empty($id)) {
    echo "La variable id est vide";
    die;
};

// Façon non sécurisé car un utilisateur pourrai injecter une requete SQL par l'URL
// $statement = $pdo->query("SELECT * FROM `mes_jeux` WHERE id = " . $id);

$sql = "SELECT * FROM `jeux` JOIN `console` ON console_id = id_console WHERE id_jeux = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();

// Récupère le résultat
$result = $statement->fetch(PDO::FETCH_ASSOC);

// Affichage
echo 'Mon jeu numéro : ' . $result['id_jeux'];
echo '<br>';
echo 'Nom : ' . $result['nom_jeux'];
echo '<br>';
echo 'Sur console : ' . $result['nom_console'];
