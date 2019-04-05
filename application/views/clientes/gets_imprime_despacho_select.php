<select id="imprime_despacho" class="form-control chosenSelect">
    <option value="S"<?=($cliente['idempresa_tipo']=='1')?" selected":""?>>SI</option>
    <option value="N"<?=($cliente['idempresa_tipo']=='2')?" selected":""?>>NO</option>
</select>