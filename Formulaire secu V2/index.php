<?php
session_start();
$token = uniqid(rand(), true); // jeton unique
$_SESSION['t'] = $token; // stockage
// heure de création du jeton
$_SESSION['token_time'] = time();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    />
    <title>formulaire</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css" />
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css" />
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
  </head>

  <body style="color: rgb(33, 37, 41);">
    <div class="register-photo">
      <div class="form-container">
        <div class="image-holder"></div>
        <form>
          <h2 class="text-center"><strong>Formulaire</strong></h2>
          
          <div class="form-group">
            <input
              class="form-control"
              type="input"
              id="id"
              name="id"
              placeholder="Identifiant"
            />
          </div>
          
          <div class="form-group">
            <input
              id="mdp"
              class="form-control"
              type="password"
              name="mdp"
              placeholder="Mot de passe"
            />
          </div> 

          <div class="form-group">
            <input 
            type="hidden" 
            name="token"
            id="token" 
            value="<?php echo $token;?>"
            />
          </div>

          <div class="form-group">
            <button class="btn btn-primary btn-block" id="BoutonConnexion" type="submit" onclick="Connexion(event)">
              Connexion
            </button>
            <button class="btn btn-primary btn-block" type="submit" onclick="Inscription(event)">
                Inscription
            </button>
          </div>

          <div class="form-group">
            <i class="btn btn-primary btn-block" onclick="effacerInput(event)">
                Reset
            </i>
          </div>
          <small id="status"></small>
        </form>
      </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="obfuscated.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/crypto-js@4.0.0/crypto-js.min.js"></script>
  </body>
</html>
