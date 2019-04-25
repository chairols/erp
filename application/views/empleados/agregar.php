<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Agregar Empleado</h3>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-6">
                    <input id="nombre" class="form-control" type="text" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Apellido</label>
                <div class="col-sm-6">
                    <input id="apellido" class="form-control" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Legajo</label>
                <div class="col-sm-6" id="legajo_div">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Fecha de Ingreso</label>
                <div class="col-sm-6">
                    <input type="text" id="fecha_ingreso" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Sueldo Bruto</label>
                <div class="col-sm-6">
                    <input type="text" id="sueldo_bruto" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">O.S.E.C.A.C.</label>
                <div class="col-sm-6">
                    <select class="control-label chosenSelect" id="osecac">
                        <option value="N">NO</option>
                        <option value="S">SI</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Sección</label>
                <div class="col-sm-6">
                    <select id="idseccion" class="form-control chosenSelect">
                        <?php foreach ($calificaciones as $calificacion) { ?>
                            <option value="<?= $calificacion['idcalificacion'] ?>"><?= $calificacion['calificacion'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Categoría</label>
                <div class="col-sm-6" id="categoria_div">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Calificación Personal</label>
                <div class="col-sm-6" id="calificacion_div">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Usuario en Sistema</label>
                <div class="col-sm-6">
                    <select id="idusuario" class="form-control chosenSelect">
                        <option value="0">--- Sin Usuario ---</option>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <option value="<?= $usuario['idusuario'] ?>"><?= $usuario['nombre'] ?> <?= $usuario['apellido'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" id="agregar">Agregar Empleado</button>
                <button class="btn btn-primary" id="agregar_loading" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
</div>