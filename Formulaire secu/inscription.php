<?php
//header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
session_start();

  if(isset($_POST["m"]) && isset($_POST["i"])){
    $mdp = strip_tags($_POST["m"]);
    $username = strip_tags($_POST["i"]);
    
    try{
      $db = new PDO('mysql:host=localhost;dbname=exo1','root','');
    }
    catch(PDOException $error){
      echo $error->getMessage();
    }

    $sql = "SELECT idusers FROM `exo1`.`users` WHERE `username` LIKE ?";
    
    // eviter les injections SQL
    $query = $db->prepare($sql);
    $query->bindValue(1, '%'.$username.'%',PDO::PARAM_STR);
    
    
    $query->execute();
    
    $users = $query->fetchAll(PDO::FETCH_ASSOC);    

    if(sizeof($users) == 0){
      $sql = "INSERT INTO `exo1`.`users` (`username`, `mdp`) VALUES (:username,:mdp);";
    
    
      $query = $db->prepare($sql);
      
      $query->bindValue(':mdp', $mdp ,PDO::PARAM_STR);
      $query->bindValue(':username', $username ,PDO::PARAM_STR);
      
      if($query->execute())
        echo "Création du compte réussi, vous pouvez vous connecter";
    }else
      echo "Un compte à déjà été créé sous ce pseudonyme";
  
  }

 

?>

