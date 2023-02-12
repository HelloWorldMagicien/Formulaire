<?php
require 'C:\config.php';
session_start();

if (!isset($_SESSION["attempt"])) {
  $_SESSION["attempt"] = 0;
}

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

if (Verification() === true && Token() === true ) {
  if ($_SESSION["attempt"] < 3) {
    $mdp = strip_tags($_POST["m"]);
    $username = strip_tags($_POST["i"]);

    try {
      $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    } catch (PDOException $error) {
      echo $error->getMessage();
    }

    $sql = "SELECT idusers FROM testsecu.users WHERE mdp= ? and username= ?";

    $query = $db->prepare($sql);

    $query->bindValue(1, $mdp, PDO::PARAM_STR);
    $query->bindValue(2, $username, PDO::PARAM_STR);

    $query->execute();

    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($users) == 1) {
      $json = [
        "message" => "Vous êtes connecté", "couleur" => "#28a745"
      ];
      echo json_encode($json);
      $_SESSION["attempt"] = 0;
    } else {
      $_SESSION["attempt"] += 1;
      $json = [
        "message" => "Compte non connu, il vous reste ",
        "tentative" =>(4 - $_SESSION["attempt"]),
        "couleur" => "#dc3545"
      ];
      echo json_encode($json);
      $_SESSION["time"] = time();
    }
  } else {
    $compteur = 60 + $_SESSION["time"] - time();

    if ($compteur <= 0){
      $json = [
        "message" => "Vous pouvez vous reconnecter",
        "couleur" => "#007bff"
      ];
      echo json_encode($json);
      $_SESSION["attempt"] = 0;
    }
      
    else{
      $json = [
        "message" => "Trop d'essai veuillez attendre ",
        "tentative" =>0,
        "couleur" => "#dc3545",
        "temps" => $compteur
      ];
      echo json_encode($json);
    }
      
  }
} else {
 header("Location: index.php");
}
