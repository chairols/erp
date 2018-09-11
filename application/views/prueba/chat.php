<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>
        <script language="javascript" src="/assets/vendors/jQuery/jquery-2.2.3.min.js"></script>
        <script language="javascript">
            var timestamp = null;
            function cargar_push()
            {
                $.ajax({
                    async: true,
                    type: "POST",
                    url: "/prueba/httpush/",
                    data: "&timestamp=" + timestamp,
                    dataType: "html",
                    success: function (data)
                    {
                        resultado = $.parseJSON(data);
                        console.log(resultado);
                        msg1 = '';
                        msg2 = '';
                        for (i = 0; i < resultado.length; i++) {
                            if (resultado[i].tipo == '1') {
                                msg1 += resultado[i].mensaje + '<br>';
                            }
                            if (resultado[i].tipo == '2') {
                                msg2 += resultado[i].mensaje + '<br>';
                            }
                        }
                        $("#div1").html(msg1);
                        $("#div2").html(msg2);
                        /*
                         var json = eval("(" + data + ")");
                         timestamp = json.timestamp;
                         mensaje = json.mensaje;
                         id = json.id;
                         status = json.status;
                         tipo = json.tipo;
                         */
                        if (timestamp == null)
                        {

                        } else
                        {
                            $.ajax({
                                async: true,
                                type: "POST",
                                url: "mensajes.php",
                                data: "",
                                dataType: "html",
                                success: function (data)
                                {
                                    $('#div' + tipo).html(data);
                                }
                            });
                        }
                        setTimeout('cargar_push()', 1000);

                    }
                });
            }

            $(document).ready(function ()
            {
                cargar_push();


                $("#boton").click(function () {

                    $.ajax({
                        async: true,
                        type: "POST",
                        url: "/prueba/arba/30610668727",
                        data: "",
                        dataType: "html",
                        beforeSend: function () {
                            $("#div3").html("Cargando ...");
                        },
                        success: function (data)
                        {
                            $('#div3').html(data);
                        }
                    });
                });
            });


        </script>

    </head>

    <body>
        <div id="div1" style="width:200px; height:200px; float:left;">
            div 1
        </div>
        <div id="div2" style="width:200px; height:200px; float:left;">
            div 2
        </div>

        <div id="div3" style="width: 200px; height: 200px; float: left">
            div 3
        </div>

        <div style="width: 200px; height: 200px; float: left">
            <button type="button" id="boton">Haceme click gato</button>
        </div>

    </body>
</html>