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
                <label class="control-label col-md-3">Pedidos</label>
                <div class="col-md-6" id="resultado">
                    <select class="form-control chosenSelect">
                        
                    </select>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="crear" class="btn btn-primary">Crear</button>
                    <button type="button" id="crear_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>