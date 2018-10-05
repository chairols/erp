<div class="box-body">
    <div class="table-responsive">
        <table class="table no-margin table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-sm">Artículo</th>
                    <th class="text-sm">Cant</th>
                    <th class="text-sm">Pend</th>
                    <th class="text-sm">A Conf</th>
                    <th class="text-sm">Ped</th>
                    <th class="text-sm">Fecha Ped</th>
                    <th class="text-sm">Costo FOB</th>
                    <th class="text-sm">Fecha Prometida</th>
                    <th class="text-sm">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items_backorder as $item) { ?>
                    <tr>
                        <td class="text-sm">
                            <input type="hidden" id="idimportacion_item" value="<?= $item['idimportacion_item'] ?>">
                            <strong><?= $item['articulo'] ?> <?= $item['marca'] ?></strong>
                        </td>
                        <td class="txC text-sm"><?= $item['cantidad'] ?></td>
                        <td class="txC text-sm"><?= $item['cantidad_pendiente'] ?></td>
                        <td class="col-xs-1 text-sm">
                            <input type="text" id="cantidad-<?=$item['idimportacion_item']?>" class="form-control input-sm" value="<?= $item['cantidad_pendiente'] ?>" required>
                        </td>
                        <td class="txC text-sm"><?= $item['idimportacion'] ?></td>
                        <td class="txC text-sm"><?= $item['fecha_pedido'] ?></td>
                        <td class="txR text-sm"><?= number_format($item['costo_fob'], 2); ?></td>
                        <td>
                            <input type="text" id="fecha_confirmacion-<?=$item['idimportacion_item']?>" name="fecha_confirmacion" value="<?= date('d/m/Y') ?>" class="form-control datePicker input-sm" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha" >
                        </td>
                        <td class="text-sm">
                            <button class="btn btn-success btn-xs" onclick="agregar(<?=$item['idimportacion_item']?>);">
                                <i class="fa fa-share"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
if($(".datePicker").length>0)
  {
    $.fn.datepicker.dates['es'] = {
      days: ["Domingo", "Lunes", "Martes", "Miércoles", "Juves", "Viernes", "Sábado"],
      daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      today: "Hoy",
      clear: "Borrar",
      format: "dd/mm/yyyy",
      titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
      weekStart: 1
    };

    $(".datePicker").each(function(){
      datePicker(this);
    });
  }    
</script>