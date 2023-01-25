<?php
//Instancie l'objet PDO
include_once 'connexion.php';
// Utilise la méthode query afin de récupérer un PDOStatement
$statement = $pdo->query("SELECT * FROM `jeux` ORDER BY id_jeux");

// Récupère le résultat
// $result = $statement->fetch(PDO::FETCH_OBJ);

// Renvoie la table mes_jeux
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupération et filtrage du paramètre GET
$options = array(
    'options' => array('min_range' => 1, 'max_range' => $result[count($result) - 1]['id_jeux']),
    'flags' => FILTER_NULL_ON_FAILURE
);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, $options);

// Observons le résultat
// var_dump($result);
// echo "<br/>";

// Quel mode permet d’obtenir un objet ? Quelle est la classe de cet objet ?
// Le mode PDO::FETCH_OBJ permet a la méthode fetch de retourner une ligne du résultat
// de la requête SQL renvoyé par query() en une instance de la classe stdClass

// $result = $statement->fetchAll();

// var_dump($result);
// echo "<br/>";
// print_r($result);

// - Que se passe-t-il ?
// - Quel est le type de $result dans ce cas
// - Quelle méthode est la plus adaptée à la requête, pourquoi ?

// La méthode fetchAll() renvoie toutes les lignes du résultat de la requete renvoyé par la méthode query(),
// fetchAll crée 1 tableau (appelons le tableau_1) de 4 éléments, 1 ligne de résultat de requete par éléments.

// Dans chaque élément du tableau_1 il renvoie le résultat de la méthode fetch() correspondant a chaque ligne
// du résultat de la requete SQL renvoyé par query().

// C-a-d tableau_1[0] = fetch() de la 1e ligne du résultat de la requete SQL renvoyé par query()
// C-a-d tableau_1[1] = fetch() de la 2e ligne du résultat de la requete SQL renvoyé par query()
// C-a-d tableau_1[2] = fetch() de la 3e ligne du résultat de la requete SQL renvoyé par query()
// C-a-d tableau_1[3] = fetch() de la 4e ligne du résultat de la requete SQL renvoyé par query()
// C-a-d tableau_1[n-1] = fetch() de la n-ieme ligne du résultat de la requete SQL renvoyé par query()

// Au final fetchAll() est une méthode reccursive/boucle appelant la méthode fetch() pour toutes les ligne du résultat de la requete SQL
// Petit détails, si la méthodfe fetch() a deja été appelé avant la methode fetchAll() pour la meme requete SQL,
// fetchAll() ignorera la ligne de requete renvoyé par fetch() et renverra toutes les lignes restante non traité par une methode fetch()
// Pour notre requete le methode fetchAll() est a utilisé car cette requete renvoie plus qu'une ligne.

$statement = $pdo->query("SELECT * FROM `jeux` JOIN `console` ON console_id = id_console ORDER BY nom_jeux");
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement_console = $pdo->query("SELECT * FROM console");
$result_console = $statement_console->fetchAll(PDO::FETCH_ASSOC);

// var_dump($result_console);
// var_dump($result);
// $id = $result[0]["id"];
// $id = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO</title>
</head>

<body>
    <main>
        <h1>Listes des jeux classé par console</h1>
        <ul>
            <!-- <li><a href="by_console.php?console=ps4">Tous les jeux PS4</a></li>
            <li><a href="by_console.php?console=xbox serie">Tous les jeux Xbox serie</a></li>
            <li><a href="by_console.php?console=switch">Tous les jeux Switch</a></li> -->

            <?php foreach ($result_console as $index => $table_row) : ?>
                <li><a href="by_console.php?id=<?= $table_row["id_console"] ?>">Tous les jeux <?= $table_row["nom_console"] ?></a></li>
            <?php endforeach ?>
        </ul>



        <h1>Ma liste de jeux classé par ordre alphabétique</h1>
        <ul>
            <li><a href="form_insert.php">Ajouter un nouveau jeux</a></li><br />
            <?php foreach ($result as $index => $table_row) : ?>
                <li><?= $table_row['nom_jeux'] ?> sur la console <?= $table_row['nom_console'] ?>
                    <ul>
                        <li><a href="show_one.php?id=<?= $table_row['id_jeux'] ?>">Voir ce jeu en détail</a></li>
                        <li><a href="form_update.php?id=<?= $table_row['id_jeux'] ?>">Modifier ce jeux</a></li>
                        <li><a href="form_delete.php?id=<?= $table_row['id_jeux'] ?>">Supprimer ce jeux</a></li>
                    </ul>
                </li><br />
            <?php endforeach ?>
        </ul>
    </main>
</body>

</html>