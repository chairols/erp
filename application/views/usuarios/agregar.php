<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-3">Usuario</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="20" class="form-control" id="usuario" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Contraseña</label>
                    <div class="col-md-6">
                        <input type="password" maxlength="40" class="form-control" id="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Repetir Contraseña</label>
                    <div class="col-md-6">
                        <input type="password" maxlength="40" class="form-control" id="password2">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Nombre</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="100" class="form-control" id="nombre">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Apellido</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="100" class="form-control" id="apellido">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">E-mail</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Teléfono</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="telefono">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Perfil</label>
                    <div class="col-md-6">
                        <select id="idperfil" class="chosenSelect">
                            <?php foreach ($perfiles as $perfil) { ?>
                                <option value="<?= $perfil['idperfil'] ?>"><?= $perfil['perfil'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="button" id="agregar" class="btn btn-success">Agregar</button>
                        <button type="reset" class="btn btn-primary">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>