<select id="sucursales_agente" class="form-control chosenSelect" <?php if(empty($sucursales)){ ?> disabled="disabled" <?php } ?> >
  <?php if(empty($sucursales)){ ?>
  <option value="0">Sin Sucursales</option>
  <?php
    }else{
      foreach($sucursales as $sucursal)
      {
  ?>
  <option value="<?= $sucursal['idsucursal'] ?>"><?= $sucursal['sucursal'] ?></option>
  <?php
      }
    }
  ?>
</select>
