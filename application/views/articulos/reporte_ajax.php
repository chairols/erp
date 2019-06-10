<link rel="stylesheet" href="/assets/vendors/DataTables-1.10.18/DataTables-1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/assets/vendors/DataTables-1.10.18/Buttons-1.5.4/css/buttons.dataTables.min.css">

<h1 class="text-center" id="loading">
    <i class="fa fa-refresh fa-spin"></i>
</h1>

<div id="pagina" style="display: none;">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th class="text-right">Línea</th>
                <th class="text-right">Artículo</th>
                <th class="text-right">Marca</th>
                <th class="text-right">Stock</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Estantería</th>
                <th class="text-right">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($articulos as $articulo) { ?>
            <tr>
                <td class="text-right"><?=$articulo['linea']?></td>
                <td class="text-right"><?=$articulo['articulo']?></td>
                <td class="text-right"><?=$articulo['marca']?></td>
                <td class="text-right"><?=$articulo['stock']?></td>
                <td class="text-right"><?=number_format($articulo['precio'], 2)?></td>
                <td class="text-right"><?=$articulo['rack']?></td>
                <td class="text-right"><?=$articulo['observaciones']?></td>
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
    $(document).ready(function() {
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
        
    });
</script>