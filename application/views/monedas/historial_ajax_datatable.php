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
    $(".datatable").DataTable();
</script>

