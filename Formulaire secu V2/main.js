var startingSeconds = 60;

function verifierConformiteFormulaire() {
  

  let id = document.getElementById("id").value;
  let mdp = document.getElementById("mdp").value;

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


function effacerInput(event) {

  event.preventDefault

  let id = document.getElementById("id");
  let mdp = document.getElementById("mdp");

  id.value = "";
  mdp.value = "";
}

function timer(){
// Update the count down every 1 second
var x = setInterval(function() {

  // Decrement the number of seconds
  startingSeconds--;
  $("#status").text(`Trop d'essai veuillez attendre ${startingSeconds} secondes`);
    
  // If the count down is finished, write some text 
  if (startingSeconds === 0) {
    clearInterval(x);
    $("#BoutonConnexion").attr("disabled",false)
  }
}, 1000);  
}

function Connexion(event) {
  
  let id = document.getElementById("id").value;
  let mdp = document.getElementById("mdp").value;
  let token = document.getElementById("token").value;

  event.preventDefault();

  let mdphash ="";
  let idhash = "";
  
  if(verifierConformiteFormulaire()){
  hashMessage(mdp).then(function (hash) {
    
    mdphash = hash;
    
    hashMessage(id).then(function (hash) {
      
      idhash = hash;

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "connexion.php",
        data: { m: mdphash, i: idhash, t:token},
        success: function (rep) {
          if(rep.tentative>1)
            $("#status").text(`${rep.message} ${rep.tentative} tentatives`);
          else if(rep.tentative == 1)
            $("#status").text(`${rep.message} ${rep.tentative} tentative`);
          else if (rep.tentative == 0){
            $("#BoutonConnexion").attr("disabled",true)
            $("#status").text(`${rep.message} ${rep.temps} secondes`);
            startingSeconds = rep.temps;
            timer();

          }
          else
            $("#status").text(`${rep.message}`);

          $("#status").css('color', rep.couleur);
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
  let token = document.getElementById("token").value;
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
          dataType: "json",
          data: { m: mdphash, i: idhash,t:token},
          success: function (rep) {
            $("#status").text(rep.message);
            $("#status").css('color', rep.couleur);
          },
        });
      });
    });
  }
  else
    alert("Formulaire non conforme")

}

async function hashMessage(message) {
    const msgUint8 = new TextEncoder().encode(message);
    const hashBuffer = await crypto.subtle.digest("SHA-256", msgUint8);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray
      .map((b) => b.toString(16).padStart(2, "0"))
      .join("");
    return hashHex;
}
