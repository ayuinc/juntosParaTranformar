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
    $(".line:nth-child(17)").addClass("hidden");
    $("#freeform_categoria_de_postulacion_3").click(function(){
      $("form>div.ff_composer>div:nth-child(5)").removeClass("hidden");
    });
    $("#freeform_categoria_de_postulacion_2").click(function(){
      $("form>div.ff_composer>div:nth-child(5)").addClass("hidden");
    });
    $("#freeform_categoria_de_postulacion_1").click(function(){
      $("form>div.ff_composer>div:nth-child(5)").addClass("hidden");
    });
    $("#freeform_acepto").click(function(){
      $(".line:nth-child(17)").removeClass("hidden");
    });
});

$(document).ready(function() {
  $(".menu-oculto-xs").click(function(e) {
    e.preventDefault();
    $(".oculto-xs").toggle();
  });
});

$('#freeform_fecha_de_nacimiento,#freeform_fecha_de_inicio_dd-mm-yyyy,#freeform_fecha_de_termino_dd-mm-yyyy,#freeform_fecha_de_inicio,#freeform_fecha_de_termino_a_la_actualidad,#freeform_fecha_de_inicio_exp,#freeform_fecha_de_termino_a_la_actualidad_exp').attr('type',"date");

$('#freeform_logros').attr('maxlength', '100').parent().addClass('textarea-wrapper');
$('#freeform_logros_exp').attr('maxlength', '100').parent().addClass('textarea-wrapper');                 
$('#freeform_que_otra_beca_pasantia_has_ganado_y_en_que_ano').attr('maxlength', '100').parent().addClass('textarea-wrapper');
$('#freeform_en_que_pais_te_gustaria_realizar_tu_pasantia_puedes_nombrar_3_paises_por_orden_de_preferencia').attr('maxlength', '100').parent().addClass('textarea-wrapper');
$('#freeform_en_que_restaurante_establecimiento_te_gustaria_realizar_tu_pasantia_puedes_nombrar_3_lugares_por_orden_de_preferencia').attr('maxlength', '100').parent().addClass('textarea-wrapper');
$("unit size1of1").addClass("hidden");

