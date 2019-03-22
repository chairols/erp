<select id="idcondicion_de_venta" class="form-control chosenSelect">
    <?php foreach($condiciones as $condicion) { ?>
    <option value="<?=$condicion['idcondicion_de_venta']?>"<?=($condicion['idcondicion_de_venta']==$cliente['idcondicion_de_venta'])?" selected":""?>><?=$condicion['condicion_de_venta']?></option>
    <?php } ?>
</select>
