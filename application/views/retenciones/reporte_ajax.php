<link rel="stylesheet" href="/assets/vendors/DataTables-1.10.18/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/assets/vendors/DataTables-1.10.18/Buttons-1.5.4/css/buttons.dataTables.min.css">

<h1 class="text-center" id="loading">
    <i class="fa fa-refresh fa-spin"></i>
</h1>

<table id="example" class="display" style="width:100%; display: none;">
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
        $("#example").show();
    });
</script>