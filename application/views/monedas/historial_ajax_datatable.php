<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-table"></i> <h3 class="box-title">Tabla</h3>
    </div>
    <div class="box-body">
        <div id="tabla">
            <table class="table table-bordered table-striped datatable">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $h) { ?>
                        <tr>
                            <td><?= $h['fecha'] ?></td>
                            <td><?= $h['valor'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(".datatable").DataTable({
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros",
            "zeroRecords": "No hay registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "search":         "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
</script>

