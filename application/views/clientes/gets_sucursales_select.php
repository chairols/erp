<select id="idsucursal" class="form-control chosenSelect">
    <?php foreach($sucursales as $sucursal) { ?>
    <option value="<?=$sucursal['idcliente_sucursal']?>"><?=$sucursal['sucursal']?></option>
    <?php } ?>
</select>

<script type="text/javascript">
    $("#idsucursal").change(function() {
        gets_transportes();
    });
</script>