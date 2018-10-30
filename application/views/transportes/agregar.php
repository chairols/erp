<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Nombre de Transporte</label>
                <div class="col-md-6">
                    <input type="text" maxlength="255" class="form-control" id="transporte" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Dirección</label>
                <div class="col-md-6">
                    <input type="text" maxlength="255" class="form-control" id="direccion">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Código Postal</label>
                <div class="col-md-6">
                    <input type="text" maxlength="8" class="form-control" id="codigo_postal">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Localidad</label>
                <div class="col-md-6">
                    <input type="text" maxlength="100" class="form-control" id="localidad">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Provincia</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idprovincia">
                        <?php foreach ($provincias as $provincia) { ?>
                            <option value="<?= $provincia['idprovincia'] ?>"><?= $provincia['provincia'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Teléfonos</label>
                <div class="col-md-6">
                    <input type="text" maxlength="255" class="form-control" id="telefono">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Tipo de IVA</label>
                <div class="col-md-6">
                    <select class="form-control chosenSelect" id="idtipo_responsable">
                        <?php foreach ($tipos_responsables as $tipo_responsable) { ?>
                            <option value="<?= $tipo_responsable['idtipo_responsable'] ?>"><?= $tipo_responsable['tipo_responsable'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">CUIT</label>
                <div class="col-md-6">
                    <input type="text" class="form-control inputMask" id="cuit" data-inputmask="'mask': '99-99999999-9'">
                </div>
            </div>
            <div class="bootstrap-timepicker">
                <div class="form-group">
                    <label class="control-label col-md-3">Horario de Entrega</label>
                    <div class="col-md-3">
                        <div class="input-group">
                            <pepe></pepe>
                            <input type="text" class="form-control timepicker" id="horario_desde">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" id="horario_hasta">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea class="form-control" id="observaciones"></textarea>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>