<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-3">Nombre de la Empresa</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="empresa" value="<?= $parametro['empresa'] ?>" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Actividad</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="actividad" value="<?= $parametro['actividad'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Dirección</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="direccion" value="<?= $parametro['direccion'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Código Postal</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="8" class="form-control" id="codigo_postal" value="<?= $parametro['codigo_postal'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Provincia</label>
                    <div class="col-md-6">
                        <select id="idprovincia" class="form-control chosenSelect">
                            <?php foreach ($provincias as $provincia) { ?>
                                <option value="<?= $provincia['idprovincia'] ?>"<?= ($provincia['idprovincia'] == $parametro['idprovincia'] ? " selected" : "") ?>><?= $provincia['provincia'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Teléfono</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="telefono" value="<?= $parametro['telefono'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">E-mail</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="255" class="form-control" id="email" value="<?= $parametro['email'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Tipo de Responsable</label>
                    <div class="col-md-6">
                        <select id="idtipo_responsable" class="form-control chosenSelect">
                            <?php foreach ($tipos_responsables as $tipo_responsable) { ?>
                                <option value="<?= $tipo_responsable['idtipo_responsable'] ?>"<?= ($tipo_responsable['idtipo_responsable'] == $parametro['idtipo_responsable'] ? " selected" : "") ?>><?= $tipo_responsable['tipo_responsable'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">CUIT</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="11" class="form-control" id="cuit" value="<?= $parametro['cuit'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Número de Ingresos Brutos</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="14" class="form-control" id="ingresos_brutos" value="<?= $parametro['ingresos_brutos'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Número de Importador</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="14" class="form-control" id="numero_importador" value="<?= $parametro['numero_importador'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Factor de Corrección</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="9" class="form-control" id="factor_correccion" value="<?= $parametro['factor_correccion'] ?>">
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
</div>