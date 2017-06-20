var faceId1;
// ###########################################################
// Extraccion de rostros
// ###########################################################
// Retorna el id de la imagen, si retorna vacio no pertenece a un rostro.
function detectFaceMicrosft (processData, img, index){
  if (processData) {
    data = JSON.stringify({url: img});
  }else{
    data = img
  }
  $.ajax({
   type: 'POST',
   url: 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect?',
   data: data,
   beforeSend: function(xhrObj){
    if (processData) {
      xhrObj.setRequestHeader("Content-Type","application/json");
    }else{
      xhrObj.setRequestHeader("Content-Type","application/octet-stream");
    }
    xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","b6ea34fcf4fe481da484c8463341d470");  

  },
  processData: processData
})
  .done(function(data){
    if (index < 0) {
      faceId1 = data[0].faceId;
      detectFaceCandidates();
    }else{
      if (data.length == 0) {
        candidates[index].state = 'Eliminado';
        console.log("- Candidato "+ index + " eliminado por no tener cara");
      }else{        
        console.log("+ Candidato "+ index + " activo por tener cara");
        candidates[index].faceId = data[0].faceId;
        verifyFaceMicrosft(index);
      }
      if (allCandidatesDeleted()) {
        makePost();
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
function verifyFaceMicrosft (index) {
  var data = JSON.stringify({
    faceId1: faceId1,
    faceId2: candidates[index].faceId
  });
  $.ajax({
   type: 'POST',
   url: 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/verify?',
   data: data,
   beforeSend: function(xhrObj){
    xhrObj.setRequestHeader("Content-Type",'application/json');
    xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","0bd13b21afb34f1989e3369dc30c1419");
  }
})
  .done(function(data){
    if (!data.isIdentical) {
      candidates[index].state = 'Eliminado';
      console.log("- Candidato "+ index + " eliminado por ser no similar al carné");
    }
    else{
      selected.push(candidates[index]);
      candidates[index].state = 'Eliminado';
      console.log("+ Candidato "+ index + " seleccionado por ser similar al carné");
    }
    if (allCandidatesDeleted()) {
      makePost();
    }
  })
  .fail(function(err){
    $.showNotify('Error', 'Ocurrió un error en la deteccion de rostro, intente de nuevo.', 'error');
  });
};  


// ###########################################################
// Clasificacion de miembros del grupo de facebook por rostro
// ###########################################################
function classifierMembersFacebookPicture() {
  img = $('#img').get(0).files[0];
  detectFaceMicrosft(false,img ,-1);
};


// ###########################################################
// Extraccion imagenes de los candidatos de su perfil
// ###########################################################
function detectFaceCandidates() {
  for (var i = candidates.length - 1; i >= 0; i--) {
    detectFaceMicrosft(true,candidates[i].picture.data.url,i);
  }
};


// ###########################################################
// Realiza post en facebook y lanza el post en encontre.co
// ###########################################################
function makePost() {
  if (selected.length == 0) {
    $.showNotify('Candidatos', 'Ningun perfil ha sido identificado como dueño del carné', 'error');
    $.showNotify('Candidatos', 'Enviando mensaje a candidatos iniciales.', 'success');
    for (var i = candidates.length - 1; i >= 0; i--) {
      postToFeed(candidates[i].id);
    }
    console.log(' ');
    console.log('Ningun perfil ha sido identificado');
  }else{
    $.showNotify('Candidatos', "Identificados posibles dueños del carné, enviando mensaje.", 'success');
    console.log(' ');
    console.log('Lista de seleccionados');
    console.log(selected);
    for (var i = selected.length - 1; i >= 0; i--) {
      postToFeed(selected[i].id);
    }
  }
  newPost(name, userConnected);
}


// ###########################################################
// Revisa si todos los candidatos fueron eliminados
// ###########################################################
function allCandidatesDeleted() {
  for (var i = candidates.length - 1; i >= 0; i--) {
    if (candidates[i].state == 'Activo') {
      return false;
    }
  }
  return true;
}
