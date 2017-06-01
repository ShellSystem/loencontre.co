// Id grupo UPTC
var idGroup = 5347104545 
var members = new Array();
var candidates = new Array();
var name = new Array();
var combinationsName = new Array();

function newPostAction(){
  FB.getLoginStatus(function(response) {
    loginStatusVerificate(response);
  });
}

function loginStatusVerificate(response){
  if(response.status != 'conected'){    
    FB.login(function(response) { // Solicita inicio de sesion

      if(response.status = 'connected'){

        FB.api('/me?fields=id,name,email', function(response) {
          
          if(response.email != ''){ // Todo bien con los datos
            $('.status').text('Conectado con facebook');
            getOCRMicrosft(response);
          }else{
            console.log('Error obtener datos de usuario desde facebook');
            $('.status').text('Error obtener datos de usuario desde facebook');
          }

        });
      }else{
        console.log("Error al iniciar sesión con facebook");
        $('.status').text('Error al iniciar sesión con facebook');
      }

    });
  }else{
    $('.status').text('No se pudo conectar con facebook');
  }
}

function exitFacebook(){
  FB.logout(function(response) {
   console.log(response);
   $('.status').text('Sesion de facebook cerrada');
  });
}


// Obtencion de miembros del grupo UPTC
function getMembersFacebook () {
    $('.status').text('Obteniendo miembros');
    FB.login().then(function() {
      refresh('');
    });

    function refresh(after) {
      FB.api('/'+idGroup+'/members','GET',{'fields':'name,link,picture.type(large)','limit':'1000','after':after}).then( 
        function(response) {
          members = members.concat(response.data);
          try {
            refresh(response.paging.cursors.after);
          }
          catch(e){
            $('.status').text('Clasificando por nombre');
            classifierMembersFacebookName();
          }
        },
        function(err) {
          $('.status').text('Error');
          console.log(err);
        });
    }
  };

function classifierMembersFacebookName () {
    combinationsName = combinations(nameDetect);
    for (var i = members.length - 1; i >= 0; i--) {
      for (var j = combinationsName.length - 1; j >= 0; j--) {
        if(cleanString(members[i].name) == cleanString(combinationsName[j]))
        {
          members[i].state = 'Activo';
          candidates.push(members[i]);
          break;
        }
      }
    }
    if (candidates.length == 1) {
      $('.status').text('Enviando mensaje a ' + candidates[0].name);
    }else{
      $('.status').text('Clasificando por foto de perfil');
      // terminar esto
      classifierMembersFacebookPicture();
    }
  };