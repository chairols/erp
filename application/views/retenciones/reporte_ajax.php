<link rel="stylesheet" href="/assets/vendors/DataTables-1.10.18/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/assets/vendors/DataTables-1.10.18/Buttons-1.5.4/css/buttons.dataTables.min.css">

<h1 class="text-center" id="loading">
    <i class="fa fa-refresh fa-spin"></i>
</h1>

<div id="pagina" style="display: none;">
    <?php if ($provincia['idjurisdiccion_afip'] == '914' || $provincia['idjurisdiccion_afip'] == '902' || $provincia['idjurisdiccion_afip'] == '901') { ?>
        <div class="pull-right">
            <input type="hidden" id="idjurisdiccion" value="<?= $provincia['idjurisdiccion_afip'] ?>">
            <input type="hidden" id="fecha_desde" value="<?= $where['fecha_desde'] ?>">
            <input type="hidden" id="fecha_hasta" value="<?= $where['fecha_hasta'] ?>">
            <button class="btn btn-primary" id="declaracion"><i class="fa fa-download"></i> Descargar Declaración Jurada</button>
        </div>
        <br><br><br>
    <?php } ?>
    <table id="example" class="display" style="width:100%">
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
</div>

<!--<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/jQuery-3.3.1/jquery-3.3.1.min.js"></script>-->
<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="/assets/vendors/DataTables-1.10.18/Buttons-1.5.4/js/buttons.html5.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function (data, row, column, node) {
                        // Strip $ from salary column to make it numeric
                        return column === 5 ?
                                data.replace(/[$,]/g, '') :
                                data;
                    }
                }
            }
        };
        $("#example").DataTable({
            "language": {
                "url": "/assets/vendors/DataTables-1.10.18/spanish.json"
            },
            dom: 'Bfrtip',
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excelHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdfHtml5'
                })
            ]
        });

        $("#loading").hide();
        $("#pagina").show();
        
        document.title = "Reporte de Retenciones - (<?=$provincia['cuenta_retenciones']?>) - <?=$provincia['provincia']?>";
    });

    $("#declaracion").click(function () {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/retenciones/ddjj/");
        form.setAttribute("target", "_blank");

        var jurisdiccion = document.createElement("input");
        jurisdiccion.setAttribute("name", "idjurisdiccion_afip");
        jurisdiccion.setAttribute("value", $("#idjurisdiccion").val());
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