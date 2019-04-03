<select id="idmoneda" class="form-control chosenSelect">
    <?php foreach($monedas as $moneda) { ?>
    <option value="<?=$moneda['idmoneda']?>"<?=($moneda['idmoneda']==$cliente['idmoneda'])?" selected":""?>><?=$moneda['moneda']?></option>
    <?php } ?>
</select>