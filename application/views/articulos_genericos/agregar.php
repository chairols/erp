<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            Agregar Artículo Genérico
        </h3>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label">Línea</label>
                <div class="col-sm-6">
                    <input type="text" id="TextAutoCompletelinea" name="TextAutoCompletelinea" placeholder="Seleccionar Línea" placeholderauto="Línea Inexistente" class="form-control TextAutoComplete" value="" objectauto="Lineas" actionauto="gets_lineas_ajax" varsauto="estado:=A" iconauto="" autofocus>
                    <input type="hidden" id="linea" name="linea" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Código</label>
                <div class="col-sm-6">
                    <input id="articulo_generico" class="form-control" name="articulo_generico" type="text" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Número de Orden</label>
                <div class="col-sm-6">
                    <input id="numero_orden" class="form-control" name="numero_orden" type="text">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <button type="button" class="btn btn-success" id="agregar">Crear Artículo Genérico</button>
                    <button type="button" class="btn btn-success" id="loading" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
        </div>

        
        
        
    </div>
</div>


