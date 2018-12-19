<div class="box box-primary">
    <div class="box-header">
        <input type="hidden" id="idcotizacion_proveedor" value="<?=$cotizacion_proveedor['idcotizacion_proveedor']?>">
    </div>
    <div class="box-body no-padding">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Proveedor</label>
                <div class="col-md-6">
                    <input type="text" id="TextAutoCompleteproveedor" name="TextAutoCompleteproveedor" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="<?= $cotizacion_proveedor['proveedor']['proveedor'] ?>" objectauto="proveedores" actionauto="gets_proveedores_ajax" iconauto="ship">
                    <input type="hidden" id="proveedor" name="proveedor" value="<?= $cotizacion_proveedor['idproveedor'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6">
                    <select id="idmoneda" class="form-control chosenSelect">
                        <?php foreach ($monedas as $moneda) { ?>
                            <option value="<?= $moneda['idmoneda'] ?>"<?= ($cotizacion_proveedor['idmoneda'] == $moneda['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Fecha de Cotización</label>
                <div class="col-md-6">
                    <input type="text" id="fecha" value="<?= $cotizacion_proveedor['fecha_formateada'] ?>" class="form-control input-sm datePicker" placeholder="Seleccione una fecha">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea id="observaciones" class="form-control"><?= $cotizacion_proveedor['observaciones'] ?></textarea>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="actualizar" class="btn btn-primary">Actualizar Datos</button>
                    <button type="button" id="actualizar_loading" class="btn btn-primary" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label class="control-label col-md-3">Adjuntar Archivos</label>
                <div class="col-md-6">
                    <div class="dropzone" id="dz1"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Archivos Adjuntos</label>
                <div class="col-md-6" id="archivos_adjuntos">
                    
                </div>
            </div>
            <hr>
            <div class="row form-group inline-form-custom bg-brown">
                <div class="col-md-4 col-xs-12 text-center">
                    <label class="control-label">Artículo</label>
                </div>
                <div class="col-md-2 col-xs-12 text-center">
                    <label class="control-label">Precio</label>
                </div>
                <div class="col-md-2 col-xs-12 text-center">
                    <label class="control-label">Cantidad</label>
                </div>
                <div class="col-md-2 col-xs-12 text-center">
                    <label class="control-label">Fecha de Entrega</label>
                </div>
                <div class="col-md-1 col-xs-12 text-center">
                    
                </div>
                <div class="col-md-2 col-xs-12 text-center">
                    <label class="control-label">Acciones</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-xs-12">
                    <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Seleccionar Artículo" placeholderauto="Artículo inexistente" class="form-control input-sm TextAutoComplete" objectauto="articulos" actionauto="gets_articulos_ajax" varsauto="estado:=A" iconauto="ship" autofocus>
                    <input type="hidden" id="articulo" name="articulo" value="">
                </div>
                <div class="col-md-2 col-xs-12">
                    <input type="text" id="precio" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,17}.99'">
                </div>
                <div class="col-md-2 col-xs-12">
                    <input type="text" id="cantidad" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,8}'">
                </div>
                <div class="col-md-2 col-xs-12">
                    <input type="text" id="fecha_articulo" value="<?= date('d/m/Y') ?>" class="form-control input-sm datePicker" placeholder="Seleccione una fecha">
                </div>
                <div class="col-md-1 col-xs-12">
                    
                </div>
                <div class="col-md-2 col-xs-12">
                    <button class="btn btn-sm btn-primary" id="agregar">Agregar</button>
                    <button class="btn btn-sm btn-primary" id="agregar_loading" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group" id="articulos_agregados">
                
            </div>
        </div>
    </div>
</div>