var usuarios = [];

$(document).ready(function (){
  $.ajax({
    url : '../models/anexo20/c_ClaveProdServ.json',
    dataType: 'json',
    success : function (json){
      // console.log(json);

      //var data = $.parseJSON(json);
      var data = json;
      var arrayprodserv = [];

      var i = 0;

      for(element in data){
        if(i == 10){
          break;
        }
        console.log("Clave: " + element + " Desc: " + data[element]);
        i++;
      }
    }
  });
});
