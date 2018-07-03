
$("#agregar").click(function () {
if(validador.validateFields("*"))
{
  alertify.confirm("Se agregará la moneda <strong>"+$("#moneda").val()+"</strong><br><strong>¿Desea confirmar?</strong>", function(e){
    if(e)
    {
      datos = {
          'moneda': $("#moneda").val(),
          'simbolo': $("#simbolo").val(),
          'codigo_afip': $("#codigo_afip").val()
      };
      $.ajax({
          type: 'POST',
          url: '/monedas/agregar_ajax/',
          data: datos,
          beforeSend: function () {

          },
          success: function (data) {
              resultado = $.parseJSON(data);
              if (resultado['status'] == 'error') {
                notifyError(resultado['data']);
              } else if (resultado['status'] == 'ok') {
                  notifySuccess("Se agregó correctamente");
                  document.getElementById("moneda").value = "";
                  document.getElementById("simbolo").value = "";
                  document.getElementById("codigo_afip").value = "";
              }
          }
      });

    }
  });
}


    // alertify.defaults.transition = "slide";
    // alertify.defaults.theme.ok = "btn btn-success";
    // alertify.defaults.theme.cancel = "btn btn-danger";
    // alertify.defaults.theme.input = "form-control";
    // alertify.defaults.notifier = {
    //     delay: 3,
    //     position: 'bottom-right',
    //     closeButton: false
    // };
    // alertify.defaults.glossary = {
    //     ok: "Agregar",
    //     cancel: "Cancelar"
    // };
    //
    // alertify.confirm(
    //         "<strong>¿Desea confirmar?</strong>",
    //         "Se agregará la moneda <strong>"+$("#moneda").val()+"</strong>",
    //         function () {
    //
    //         },
    //         function () {
    //             alertify.error("Se canceló la operación");
    //         }
    // );

});
