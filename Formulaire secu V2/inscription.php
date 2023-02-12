<?php
require 'C:\config.php';
session_start();

function Verification()
{
  if (isset($_POST["m"]) && isset($_POST["i"])) {
    if (sizeof($_POST["m"]) > 0 && sizeof($_POST["i"]) > 0) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function Token()
{
  if (isset($_SESSION['t']) && isset($_SESSION['token_time']) && isset($_POST['t'])) {
    if ($_SESSION['t'] == $_POST['t']) {
      return true;
    }
    else{
      return false;
    }
  }
  else{
    return false;
  }
}

if (Verification() === true && Token() === true) {
  $mdp = strip_tags($_POST["m"]);
  $username = strip_tags($_POST["i"]);

  try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
  } catch (PDOException $error) {
    echo $error->getMessage();
  }

  $sql = "SELECT idusers FROM `testsecu`.`users` WHERE `username` LIKE ?";

  $query = $db->prepare($sql);
  $query->bindValue(1, '%' . $username . '%', PDO::PARAM_STR);


  $query->execute();

  $users = $query->fetchAll(PDO::FETCH_ASSOC);

  if (sizeof($users) == 0) {
    $sql = "INSERT INTO `testsecu`.`users` (`username`, `mdp`) VALUES (:username,:mdp);";


    $query = $db->prepare($sql);

    $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $query->bindValue(':username', $username, PDO::PARAM_STR);

    if ($query->execute()) {
      $json = [
        "message" => "Création du compte réussi, vous pouvez vous connecter", "couleur" => "#28a745"
      ];
      echo json_encode($json);
    }
  } else {
    $json = [
      "message" => "Un compte a déjà été créé sous ce pseudonyme",
      "couleur" => "#dc3545"
    ];
    echo json_encode($json);
  }
} else {
  header("Location: index.php");
}
