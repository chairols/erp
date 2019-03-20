<div class="box box-primary">
    <div class="box-header">
        
    </div>
    <div class="box-body no-padding">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-xs-3">Usuario</label>
                <div class="col-xs-6">
                    <input type="text" id="usuario" maxlength="20" class="form-control" value="<?= $perfil['usuario'] ?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Nombre</label>
                <div class="col-xs-6">
                    <input type="text" id="nombre" maxlength="100" class="form-control" value="<?= $perfil['nombre'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Apellido</label>
                <div class="col-xs-6">
                    <input type="text" id="apellido" maxlength="100" class="form-control" value="<?= $perfil['apellido'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Email</label>
                <div class="col-xs-6">
                    <input type="email" id="email" maxlength="255" class="form-control" value="<?= $perfil['email'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Teléfono</label>
                <div class="col-xs-6">
                    <input type="text" id="telefono" maxlength="255" class="form-control" value="<?= $perfil['telefono'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Contraseña Actual</label>
                <div class="col-xs-6">
                    <input type="password" id="password" maxlength="100" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Nueva Contraseña</label>
                <div class="col-xs-6">
                    <input type="password" id="nuevopass" maxlength="100" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Confirmar Nueva Contraseña</label>
                <div class="col-xs-6">
                    <input type="password" id="nuevopassconf" maxlength="100" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Imagen</label>
                <div class="col-xs-6">
                    <div class="dropzone" id="dz1"></div>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="modificar" class="btn btn-success">Modificar</button>
                </div>
            </div>
        </div>
    </div>
</div>
