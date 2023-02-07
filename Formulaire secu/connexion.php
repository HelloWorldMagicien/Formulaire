<?php
//header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
session_start();

if(!isset($_SESSION["attempt"])){
  $_SESSION["attempt"]=0;
}

//  s'il y a eu moins de 3 tentatives de connexion
if($_SESSION["attempt"]<3){
  // vérifie l'existance des variables post m et i
  // pour empêcher une mauvaise utilisation du script
  if(isset($_POST["m"]) && isset($_POST["i"])){
    // utilisation de la fonction strip_tags 
    // pour retirer les balises html pour empêcher les attaques de type XSS
    $mdp = strip_tags($_POST["m"]);
    $username = strip_tags($_POST["i"]);
    
    try{
      $db = new PDO('mysql:host=localhost;dbname=exo1','root','');
    }
    catch(PDOException $error){
      echo $error->getMessage();
    }
    
    $sql = "SELECT idusers FROM exo1.users WHERE mdp= ? and username= ?";
    
    // utilisation de prepare pour empêcher les  injections SQL
    $query = $db->prepare($sql);
    
    // assignation des valeurs formatés à la requête prepare
    $query->bindValue(1, $mdp ,PDO::PARAM_STR);
    $query->bindValue(2, $username ,PDO::PARAM_STR);
    
    $query->execute();
    
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
  
    // si la requête renvoie un utilisateur alors il peut se connecter
    if(sizeof($users) == 1){
      echo "Vous êtes connecté";
      session_destroy();
    }
    
    // essai de tentatives de connexion limités à 3
    else{
      $_SESSION["attempt"]+=1;
      echo "Compte non connu, il vous reste ".+(4-$_SESSION["attempt"])." essais";
      $_SESSION["time"]=time();      
    }
      
  }
}

// si tentatives dépassées alors il faut attendre 60 secondes
else{
  $compteur=60+$_SESSION["time"]-time();
  

  if($compteur <=0)
    session_destroy();
  else
    echo "Trop d'essai veuillez attendre ".$compteur." secondes";
}

 

?>

