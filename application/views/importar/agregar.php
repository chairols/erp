<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-md-3">Seleccionar Archivo</label>
                    <div class="col-md-6">
                        <input type="file" class="form-control" name="archivo">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Subir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th>Archivo</th>
                        <th>Tamaño</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($archivos as $archivo) { ?>
                    <tr>
                        <td><?=$archivo['name']?></td>
                        <td><?=$archivo['size']?></td>
                        <td><?=$archivo['date']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>