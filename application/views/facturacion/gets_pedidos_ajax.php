<select id="idpedido" class="form-control chosenSelect">
    <?php foreach($pedidos as $pedido) { ?>
    <option value="<?=$pedido['idpedido']?>">Pedido N° <?=$pedido['idpedido']?> - <?=$pedido['fecha_formateada']?></option>
    <?php } ?>
</select>
