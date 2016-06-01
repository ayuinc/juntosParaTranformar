$(document).ready(function() {

  function validar(event) {
     return /[0-9]|\./.test(String.fromCharCode(event.keyCode)) && !event.shiftKey;
  }

  $('#freeform_dni').keypress(function(e) {
      return validar(e);
  });
  $('#freeform_telefono_celular_o_fijo').keypress(function(e) {
      return validar(e);
  });
  $('#freeform_telefono_insitucion').keypress(function(e) {
      return validar(e);
  });
  $('#freeform_duracion_en_meses').keypress(function(e) {
      return validar(e);
  });
  $('#freeform_ponderado_final_nota_en_numeros').keypress(function(e) {
      return validar(e);
  });
});
$("button").click(function(){
    $("p").removeClass("intro");
});
$(document).ready(function() {
    $("#freeform_categoria_de_postulacion_1").click(function(){
      $("form>div.ff_composer>div:nth-child(5)").removeClass("hidden");
    });
    $("#freeform_categoria_de_postulacion_2").click(function(){
      $("form>div.ff_composer>div:nth-child(5)").removeClass("hidden");
    });
    $("#freeform_categoria_de_postulacion_3").click(function(){
      $("form>div.ff_composer>div:nth-child(5)").removeClass("hidden");
    });
});