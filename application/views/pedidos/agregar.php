<div class="box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Cliente</label>
                <div class="col-md-6">
                    <input type="text" id="TextAutoCompletecliente" name="TextAutoCompletecliente" placeholder="Cliente" placeholderauto="Cliente inexistente" class="form-control TextAutoComplete" value="" objectauto="clientes" actionauto="gets_clientes_ajax" iconauto="ship" autofocus>
                    <input type="hidden" id="cliente" name="cliente" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Sucursal</label>
                <div class="col-md-6" id="div-sucursal">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Transporte</label>
                <div class="col-md-6" id="div-transportes">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Condición de Venta</label>
                <div class="col-md-6" id="div-condiciones">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Comisiones</label>
                <div class="col-md-6">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Imprime Despacho</label>
                <div class="col-md-6">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Orden de Compra</label>
                <div class="col-md-6">
                    <input class="form-control" id="ordendecompra">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6" id="div-monedas">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Dólar Oficial</label>
                <div class="col-md-6">
                    <input type="text" class="form-control inputMask" value="<?=$dolar['valor']?>" data-inputmask="'mask': '9{1,2}.999999'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Factor de Corrección</label>
                <div class="col-md-6">
                    <input type="text" class="form-control inputMask" value="<?=$parametro['factor_correccion']?>" data-inputmask="'mask': '9{1,2}.99'">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Porcentaje de IVA</label>
                <div class="col-md-6">
                    
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Concepto a Facturar</label>
                <div class="col-md-6">
                    
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