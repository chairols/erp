<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <form method="POST" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label col-md-3">Nombre</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="nombre" id="nombre" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Certificado</label>
                <div class="col-md-6">
                    <input type="file" accept=".crt" class="form-control" name="certificado" id="certificado">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Clave</label>
                <div class="col-md-6">
                    <input type="file" class="form-control" name="clave" id="clave">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Fecha Desde</label>
                <div class="col-md-6">
                    <input type="text" id="fecha_desde" name="fecha_desde" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Fecha Hasta</label>
                <div class="col-md-6">
                    <input type="text" id="fecha_hasta" name="fecha_hasta" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" id="agregar" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>