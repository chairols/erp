<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body no-padding">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Cliente</label>
                <div class="col-md-6">
                    <input type="text" id="TextAutoCompletecliente" name="TextAutoCompletecliente" placeholder="Cliente" placeholderauto="Cliente inexistente" class="form-control TextAutoComplete" value="" objectauto="clientes" actionauto="gets_clientes_ajax" varsauto="estado:=A" iconauto="ship" autofocus="">
                    <input type="hidden" id="cliente" name="cliente" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Sucursal</label>
                <div class="col-md-6" id="sucursal">
                    <select id="idcliente_sucursal" class="form-control chosenSelect">
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6">
                    <select id="idmoneda" class="form-control chosenSelect">
                        <?php foreach ($monedas as $moneda) { ?>
                            <option value="<?= $moneda['idmoneda'] ?>"><?= $moneda['moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Atención</label>
                <div class="col-md-6">
                    <input type="text" id="atencion" class="form-control" placeholder="Sr. Juan Perez" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Fecha de Cotización</label>
                <div class="col-md-6">
                    <input type="text" id="fecha" value="<?= date('d/m/Y') ?>" class="form-control datePicker" placeholder="Seleccione una fecha">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea id="observaciones" class="form-control"></textarea>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_loading" class="btn btn-primary" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>