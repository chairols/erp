<div class="col-md-12">
    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body no-padding">
            <form method="POST" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-3">Parámetro</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="100" class="form-control" id="parametro" name="parametro" placeholder="Nombre del Parámetro" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Tipo de Parámetro</label>
                    <div class="col-md-6">
                        <select name="tipo" id="tipo" class="form-control chosenSelect">
                            <?php foreach ($tipos as $tipo) { ?>
                                <option value="<?= $tipo['idparametro_tipo'] ?>"><?= $tipo['parametro_tipo'] ?></option>
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
            </form>
        </div>
    </div>
</div>