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
        $.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');

            getOCRMicrosft(response);
          }else{
        $.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');

            console.log('Error obtener datos de usuario desde facebook');
            $('.status').text('Error obtener datos de usuario desde facebook');
          }

        });
      }else{
        $.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');
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
function getMembersFacebook (nameDetect) {
  $('.status').text('Obteniendo miembros');
  refresh('');

  function refresh(after) {
    FB.api(
      '/'+idGroup+'/members','GET',{'fields':'name,link,picture.type(large)','limit':'1000','after':after},
      function(response) {
        if (response && !response.error) {
          members = members.concat(response.data);
          try {
            refresh(response.paging.cursors.after);
            console.log(members.length);
          }
          catch(e){
            $('.status').text('Clasificando por nombre');
            classifierMembersFacebookName(nameDetect);
          }
        }
      }
      );
  }
};

function classifierMembersFacebookName (nameDetect) {
  combinationsName = combinations(nameDetect);
  for (var i = members.length - 1; i >= 0; i--) {
    for (var j = combinationsName.length - 1; j >= 0; j--) {
      if(cleanString(members[i].name) == cleanString(combinationsName[j]))
      {
        members[i].state = 'Activo';
        candidates.push(members[i]);
        $('.status').text('Enviando mensaje a ' + members[i].name);
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

//Deteccion de rostro candidatos
function classifierMembersFacebookPicture() {
  detectFaceMicrosft(-1);
};

function detectFaceCandidates() {
  for (var i = candidates.length - 1; i >= 0; i--) {
    detectFaceMicrosft(candidates[i].picture.data.url,i);
  }
};

// comparacion de rostros
//Retorna el id de la imagen, si retorna vacio no pertenece a un rostro.
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
    console.log(err);
  });
};

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
      $('.status').text('Enviando mensaje a ' + candidates[index].name);
    }
  })
  .fail(function(err){
    console.log(err);
  });
};  
