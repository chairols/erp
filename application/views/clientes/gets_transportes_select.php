<select id="transporte" class="form-control chosenSelect">
    <?php foreach($transportes as $transporte) { ?>
    <option value="<?=$transporte['idtransporte']?>"<?=($transporte['idtransporte']==$sucursal['idtransporte'])?" selected":""?>><?=$transporte['transporte']?></option>
    <?php } ?>
</select>