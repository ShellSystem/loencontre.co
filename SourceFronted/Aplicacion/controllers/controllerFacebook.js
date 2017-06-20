// ###########################################################
// Id grupo UPTC
// ###########################################################
var idGroup = 5347104545 

var members = new Array();
var candidates = new Array();
var name = new Array();
var combinationsName = new Array();


// ###########################################################
// Activacion de la conexion con la cuenta de facebook
// ###########################################################
function newPostAction(){
  FB.getLoginStatus(function(response) {
    loginStatusVerificate(response);
  });
}

function share(name, image){
    $("#facebook-description").attr('content', name)
    $("#facebook-image").attr('content', image)
    
    FB.ui({
        method : 'share',
        href : "http://loencontre.co/Aplicacion/",
      }, function(response) {
         console.log(response)
        
      });

  }


// ###########################################################
// Extraccion de datos del usuario de la cuenta de facebook
// ###########################################################
function loginStatusVerificate(response){
  if(response.status != 'conected'){    
    FB.login(function(response) {
      if(response.status = 'connected'){
        FB.api('/me?fields=id,name,email', function(response) {
          if(response.email != ''){ 
            $.showLoading("Conectado con facebook")
            getOCRMicrosft(response);
          }else{
            $.showNotify('Error', 'Error obtener datos de usuario desde facebook. Intente de nuevo', 'error');
          }

        });
      }else{
        $.showNotify('Error', 'Error al iniciar sesión con facebook', 'error');
      }

    });
  }else{
    $.showNotify('Error', 'No se pudo conectar con facebook', 'error');
  }
}


// ###########################################################
// Desconexion de la cuenta de facebook
// ###########################################################
function exitFacebook(){
  FB.logout(function(response) {
   $.showLoading("Sesion de facebook cerrada");
 });
}


// ###########################################################
// Obtencion de miembros del grupo de facebook
// ###########################################################
function getMembersFacebook (nameDetect) {
  $.showLoading('Obteniendo miembros ...');
  refresh('');

  function refresh(after) {
    FB.api(
      '/'+idGroup+'/members','GET',{'fields':'name,link,picture.type(large)','limit':'1000','after':after},
      function(response) {
        if (response && !response.error) {
          members = members.concat(response.data);
          try {
            refresh(response.paging.cursors.after);
            $.showLoading('Numero de miembros: ' + members.length);
          }
          catch(e){
            $.showLoading('Clasificando por nombre ...');
            classifierMembersFacebookName(nameDetect);
          }
        }
      }
      );
  }
};


// ###########################################################
// Clasificacion de miembros del grupo de facebook por nombre
// ###########################################################
function classifierMembersFacebookName (nameDetect) {
  combinationsName = combinations(nameDetect);
  for (var i = members.length - 1; i >= 0; i--) {
    for (var j = combinationsName.length - 1; j >= 0; j--) {
      if(cleanString(members[i].name) == cleanString(combinationsName[j]))
      {
        members[i].state = 'Activo';
        candidates.push(members[i]);
        console.log("texto");
        console.log('Enviando mensaje a ' + candidates[index].name);
        break;
      }
    }
  }
  // POST######################################################
  // FB.api(
  //   "/me/feed",
  //   "POST",
  //   {
  //     "message": "Etiqueta al propietario."
  //   },
  //   function (response) {
  //     if (response && !response.error) {
  //       console.log(response); /* post id will be returned */
  //     }
  //     else{
  //       console.log(response);
  //     }
  //   }
  //   );
  // POST######################################################
  // if (candidates.length == 1) {
  //   //REALIZAR POST AQUI
  //   $('.status').text('Enviando mensaje a ' + candidates[0].name);
  // }else{
  //   $('.status').text('Clasificando por foto de perfil');
  //     // terminar esto
  //     classifierMembersFacebookPicture();
  //   }
};


// ###########################################################
// Clasificacion de miembros del grupo de facebook por rostro
// ###########################################################
function classifierMembersFacebookPicture() {
  detectFaceMicrosft(-1);
};


// ###########################################################
// Extraccion imagenes de los candidatos de su perfil
// ###########################################################
function detectFaceCandidates() {
  for (var i = candidates.length - 1; i >= 0; i--) {
    detectFaceMicrosft(candidates[i].picture.data.url,i);
  }
};


