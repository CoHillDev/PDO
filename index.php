<?php

// $pdo = new \PDO('mysql:host=localhost;dbname=database_name;charset=utf8', 'wilder_username', 'wilder_password');

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);

if (isset($_POST['user_firstname'])){
  //On récupère les informations saisies dans le formulaire
  $firstname = trim($_POST['user_firstname']);
  $lastname = trim($_POST['user_lastname']);
  
  // On prépare notre requête d'insertion
  $query = 'INSERT INTO friend (firstname, lastname) VALUES (:user_firstname, :user_lastname)';
  $statement = $pdo->prepare($query);
  
  // On lie les valeurs saisies dans le formulaire à nos placeholders
  $statement->bindValue(':user_firstname', $firstname, \PDO::PARAM_STR);
  $statement->bindValue(':user_lastname', $lastname, \PDO::PARAM_STR);
  
  $statement->execute(); 
  }

// A exécuter afin d'afficher vos lignes déjà insérées dans la table friends
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friendsList = $statement->fetchAll(PDO::FETCH_ASSOC);
//var_dump($friendsList);

//Cette fonction ne permet pas de renvoyer les retours nuls et les erreurs... À chaque refresh de la page, cela rajoute la derniere entrée, prise en compte des nouvelles entrées en différé...

/*
// Ceci est à titre d'exemple afin d'insérer une ligne dans votre table friends
$query = "INSERT INTO friend (firstname, lastname) VALUES ('Chandler', 'Bing')";
$statement = $pdo->exec($query);
*/

?>

<!DOCTYPE html>
<html lang="en">
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Friend Form</title>
</head>

<body>

  <section>
    <?php // Affichage de la liste des Friends
    ?>
    <div class="border border-danger rounded p-3 m-5 bg-danger">
      <h1>This is a list of Friends main characters :</h1>
      <ul>
        <?php foreach ($friendsList as $friend) : ?>
          <li><?= $friend["firstname"] . ' ' . $friend["lastname"] . '<br>'; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section>
    <div class="container">
      <h2 class="text-center">And you... have you got any friends ?</h2>
      <p class="text-center">Really ?! Well... write down their names </p>

      <form action="index.php" method="post">
        <fieldset>
          <legend>In here :</legend>
          <div>
            <label for="firstname">Firstname</label>
            <input type="text" id="firstname" name="user_firstname" class="form-control" required>
          </div>
          <div>
            <label for="lastname">Lastname</label>
            <input type="text" id="lastname" name="user_lastname" class="form-control" required>
          </div>
          <button type="submit" style="background-color:red; border-color:red; color:white">If you say so... push here !</button>
        </fieldset>
      </form>
    </div>
  </section>
</body>

</html>