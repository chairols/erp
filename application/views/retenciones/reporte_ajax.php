<h3 class="text-center">
    <strong>
        Jurisdicción: <?= $provincia['idjurisdiccion_afip'] ?> - <?= $provincia['provincia'] ?>
    </strong>
</h3>
<input type="hidden" id="jurisdiccion" value="<?=$provincia['idjurisdiccion_afip']?>">
<input type="hidden" id="fecha_desde" value="<?=$where['fecha_desde']?>">
<input type="hidden" id="fecha_hasta" value="<?=$where['fecha_hasta']?>">

<table class="table table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th class="text-right">Retención</th>
            <th class="text-right">Fecha</th>
            <th class="text-right">Proveedor</th>
            <th class="text-right">Alícuota</th>
            <th class="text-right">Monto Retenido</th>
            <th class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $subtotal = 0; ?>
        <?php foreach ($retenciones as $retencion) { ?>
            <?php $subtotal += $retencion['monto_retenido']; ?>
            <tr class="text-right">
                <td><?= str_pad($retencion['punto'], 4, '0', STR_PAD_LEFT) ?>-<?= str_pad($retencion['numero'], 8, '0', STR_PAD_LEFT) ?></td>
                <td><?= $retencion['fecha_formateada'] ?></td>
                <td><?= $retencion['proveedor'] ?></td>
                <td><?= $retencion['alicuota'] ?></td>
                <td><?= number_format($retencion['monto_retenido'], 2) ?></td>
                <td><?= number_format($subtotal, 2) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="pull-right">
    <button id="pdf" class="btn btn-primary">Generar PDF</button>
</div>

<script type="text/javascript">
    $("#pdf").click(function () {
        
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/retenciones/reporte_pdf/");
        form.setAttribute("target", "_blank");

        var jurisdiccion = document.createElement("input");
        jurisdiccion.setAttribute("name", "idjurisdiccion_afip");
        jurisdiccion.setAttribute("value", $("#jurisdiccion").val());
        form.appendChild(jurisdiccion);
        
        var fecha_desde = document.createElement("input");
        fecha_desde.setAttribute("name", "fecha_desde");
        fecha_desde.setAttribute("value", $("#fecha_desde").val());
        form.appendChild(fecha_desde);
        
        var fecha_hasta = document.createElement("input");
        fecha_hasta.setAttribute("name", "fecha_hasta");
        fecha_hasta.setAttribute("value", $("#fecha_hasta").val());
        form.appendChild(fecha_hasta);
        
        document.body.appendChild(form);    // Not entirely sure if this is necessary           
        form.submit();
    });
</script>