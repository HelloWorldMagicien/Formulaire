//Partie AJAX
		$.ajax({
					url: "../Json/données.json",
					method: "GET",
					dataType: "json",
					success: function(data)
					{
	
	console.log("json");
/*
Variable
*/
var invisible=document.getElementsByTagName('small');
var mdp=document.getElementsByTagName('input');
var formu=document.getElementById('form');
var no_mail=1;


//Vérification de la présence de l'email dans le json
formu.addEventListener('submit',function verifierFormulaire(e){

					for(let i=0;i<data.length;i++)
					{
						if(mdp[0].value==data[i].email)
						{
							invisible[0].className="text-danger visible";
							e.preventDefault();
							break;
						}
						else{
							invisible[0].className="text-danger invisible";
							}
					}
					
					
																})
					}
				});

//Partie Javascript

/*
Variable
*/
var vérif=true;
var invisible=document.getElementsByTagName('small');
var mdp=document.getElementsByTagName('input');
var formu=document.getElementById('form');

//Vérifications des champs
formu.addEventListener('submit',function verifierFormulaire(e){

//Vérification email
if (mdp[0].value == "")
																{
																	e.preventDefault();
																	mdp[0].style.borderColor = "red";
																}
	else{mdp[0].style.borderColor = "green";}

//Vérification mot de passe
	if (mdp[1].value == "")
																{
																	e.preventDefault();
																	mdp[1].style.borderColor = "red";
																}
	else{mdp[1].style.borderColor = "green";}

		if (mdp[2].value == ""){
											e.preventDefault();
											mdp[2].style.borderColor = "red";
								}

		if (mdp[2].value == ""&&mdp[1].value == ""){
											e.preventDefault();
											mdp[2].style.borderColor = "red";
											invisible[1].className="text-danger invisible";
								}

//Vérification similitude mot de passe
else{
	 if(mdp[1].value!=mdp[2].value)
			{
				mdp[2].style.borderColor = "red";
				invisible[1].className="text-danger visible";
				e.preventDefault();
			}
else	{
		mdp[2].style.borderColor = "green";
		invisible[1].className="text-danger invisible";
		
		}
	}

//Vérification des termes(checkbox)
	if(mdp[3].checked == false)
		{
			document.getElementsByTagName('label')[0].style.color="red";
			e.preventDefault();
		}
		
	else
	{
		document.getElementsByTagName('label')[0].style.color="black";
	}

});

