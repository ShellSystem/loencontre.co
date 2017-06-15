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
        // $('.status').text('Enviando mensaje a ' + members[i].name);
        break;
      }
    }
  }
  // POST######################################################
  FB.api(
    "/me/feed",
    "POST",
    {
      "message": "Etiqueta al propietario."
    },
    function (response) {
      if (response && !response.error) {
        console.log(response); /* post id will be returned */
      }
      else{
        console.log(response);
      }
    }
    );
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


// ###########################################################
// Extraccion de rostros
// ###########################################################
// Retorna el id de la imagen, si retorna vacio no pertenece a un rostro.
function detectFaceMicrosft (index){
  img = $('#img').get(0).files[0];

  $.ajax({
   type: 'POST',
   url: 'https://westus.api.cognitive.microsoft.com/face/v1.0/detect?',
   data: img,
   beforeSend: function(xhrObj){
            // Request headers
            xhrObj.setRequestHeader("Content-Type","application/octet-stream");
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","2821aa93acd749ba8a7bc585ed2f10dd");
          },
          processData: false
        })
  .done(function(data)
  {
   if (index < 0) {
    var faceId1 = data[0].faceId;
    detectFaceCandidates();
  }else{
    if (data.length == 0) {
      candidates[index].state = 'Eliminado';
    }else{
      candidates[index].faceId = data[0].faceId;
      verifyFaceMicrosft(faceId1, index);
    }

  }
})
  .fail(function(err){
    $.showNotify('Error', 'Ocurrió un error en la deteccion de rostro, intente de nuevo.', 'error');
  });
};


// ###########################################################
// Comparacion de rostros de los candidatos
// ###########################################################
function verifyFaceMicrosft (faceId1, index) {
  var data = {
    faceId1: faceId1,
    faceId2: candidates[index].faceId
  }

  $.ajax({
   type: 'POST',
   url: 'https://westus.api.cognitive.microsoft.com/face/v1.0/verify?',
   data: data,
   beforeSend: function(xhrObj){
            // Request headers
            xhrObj.setRequestHeader("Content-Type",'application/json');
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","07c4d54cefb847c999fde07d0ef6ca9e");
          }
        })
  .done(function(data)
  {
    if (!data.isIdentical) {
      candidates[index].state = 'Eliminado';
    }
    else{
      // $('.status').text('Enviando mensaje a ' + candidates[index].name);
    }
  })
  .fail(function(err){
    $.showNotify('Error', 'Ocurrió un error en la deteccion de rostro, intente de nuevo.', 'error');
  });
};  
