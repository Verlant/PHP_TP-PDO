<?php
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
        <form action="insert.php" method="post">
            <fieldset>
                <legend>Ajout d'un jeux à ma collection</legend>
                <label for="nom">Nom : </label>
                <input type="text" name="nom" id="nom">
                <label for="console">Console : </label>
                <input type="text" name="console" id="console">
                <input type="reset" value="Effacer">
                <input type="submit" value="Ok" name="OK">
            </fieldset>
        </form>
    </main>
</body>

</html>