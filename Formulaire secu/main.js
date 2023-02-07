function verifierConformiteFormulaire() {
  
  let id = document.getElementById("id").value;
  let mdp = document.getElementById("mdp").value;

  /* ici on vérifie si le formulaire contient une valeur 
   et ne contient pas d'espace */
  if (!id || !mdp) {
    return false;
  } else {
    if ((id).includes(" ") || (mdp).includes(" ")) {
      return false;
    } else {
      return true;
    }
  
  }
}


function effacerInput() {

  let id = document.getElementById("id");
  let mdp = document.getElementById("mdp");

  id.value = "";
  mdp.value = "";
}

function Connexion(event) {
  
  let id = document.getElementById("id").value;
  let mdp = document.getElementById("mdp").value;

  // empêche l'envoi du formulaire
  event.preventDefault();

  let mdphash ="";
  let idhash = "";
  
  if(verifierConformiteFormulaire()){
  hashMessage(mdp).then(function (hash) {
    
    mdphash = hash;
    
    hashMessage(id).then(function (hash) {
      
      idhash = hash;

      // ici une fonction ajax de type POST 
      // pour ne pas afficher le mot de passe et l'identifiant dans  l'URL
      $.ajax({
        type: "POST",
        url: "connexion.php",
        data: { m: mdphash, i: idhash},
        success: function (rep) {
          $("#status").text(rep);
        },
      });
    });
  });
}
else
alert("Formulaire non conforme")
}

function Inscription(event) {
  event.preventDefault();
  

  let id = document.getElementById("id").value;
  let mdp = document.getElementById("mdp").value;
  let mdphash ="";
  let idhash = "";

  if(verifierConformiteFormulaire()){
    hashMessage($("#mdp").val()).then(function (hash) {
      mdphash = hash;
      hashMessage($("#id").val()).then(function (hash) {
        idhash = hash;
  
        $.ajax({
          type: "POST",
          url: "inscription.php",
          data: { m: mdphash, i: idhash},
          success: function (rep) {
            $("#status").text(rep);
          },
        });
      });
    });
  }
  else
    alert("Formulaire non conforme")

}

// fonction javascript qui génère du SHA-256
async function hashMessage(message) {
    const msgUint8 = new TextEncoder().encode(message);
    const hashBuffer = await crypto.subtle.digest("SHA-256", msgUint8);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray
      .map((b) => b.toString(16).padStart(2, "0"))
      .join("");
    return hashHex;
}
