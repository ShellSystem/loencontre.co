// ###########################################################
// Extraccion de rostros
// ###########################################################
// Retorna el id de la imagen, si retorna vacio no pertenece a un rostro.
function detectFaceMicrosft (index){
  img = $('#img').get(0).files[0];

  $.ajax({
   type: 'POST',
   url: 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect?',
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
   url: 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/verify?',
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
