<button type="button" onclick="ajax();">Apretame</button>
<div id="resultado"></div>

<!-- jQuery 2.2.3 -->
<script src="/assets/vendors/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    function ajax() {

        $.ajax({
            type: 'GET',
            url: 'https://api.preguntados.com/api/users/17739425/games/7515046183',
            headers: {
                "Eter-Session": "ap_session=44e023f8cd12ee539ed490e592337d6c1103464f"
            },
            beforeSend: function () {

            },
            success: function (data) {
                resultado = $.parseJSON(data);
                $("#resultado").html(resultado);
            },
            error: function (xhr) { // if error occured

            }
        });

    }
</script>