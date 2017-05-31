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