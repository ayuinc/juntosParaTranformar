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

$(document).ready(function() {
    $('#freeform_categoria_de_postulacion_1').attr( "checked","checked" );
    $("input[name$='categoria_de_postulacion']").click(function() {
        // var test = $(this).();
        if ($(this).val() != 'Si') {

          $("form>div.ff_composer>div:nth-child(5)").children().eq(10).children().eq(1).addClass('visibility');
        }
        else {
          $(".ff_composer").children().eq(10).children().eq(1).removeClass('hidden');
        }

    });

    $('#freeform_esta_inscrita_en_registros_publicos_2').click(function() {
        if ($(this).val() == 'No') {

          $("input[name='ruc']").val("");
          $("input[name='cuando_se_constituyeron_dd_mm_yyyy']").val("");
        }
    });
});