<div class="box box-primary">
    <div class="box-header bg-light-blue-gradient">
        <input type="hidden" id="idcotizacion_cliente" value="<?= $cotizacion_cliente['idcotizacion_cliente'] ?>">
        <h3 class="box-title">Cabecera</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <br>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Cliente</label>
                <div class="col-md-6">
                    <input type="text" id="TextAutoCompletecliente" name="TextAutoCompletecliente" placeholder="Cliente" placeholderauto="Cliente inexistente" class="form-control TextAutoComplete" value="<?= $cotizacion_cliente['cliente']['cliente'] ?>" objectauto="clientes" actionauto="gets_clientes_ajax" iconauto="ship">
                    <input type="hidden" id="cliente" name="cliente" value="<?= $cotizacion_cliente['idcliente'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6">
                    <select id="idmoneda" class="form-control chosenSelect">
                        <?php foreach ($monedas as $moneda) { ?>
                            <option value="<?= $moneda['idmoneda'] ?>"<?= ($cotizacion_cliente['idmoneda'] == $moneda['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Fecha de Cotización</label>
                <div class="col-md-6">
                    <input type="text" id="fecha" value="<?= $cotizacion_cliente['fecha_formateada'] ?>" class="form-control input-sm datePicker" placeholder="Seleccione una fecha">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea id="observaciones" class="form-control"><?= $cotizacion_cliente['observaciones'] ?></textarea>
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

        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header bg-light-blue-gradient">
        <h3 class="box-title">Artículos</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <br>
            <div class="row bg-brown">
                <div class="col-lg-2 col-xs-12 text-center">
                    <label class="control-label">Cantidad</label>
                </div>
                <div class="col-lg-4 col-xs-12 text-center">
                    <label class="control-label">Artículo (No se muestra)</label>
                </div>
                <div class="col-lg-4 col-xs-12 text-center">
                    <label class="control-label">Descripción</label>
                </div>
                <div class="col-lg-2 col-xs-12 text-center">
                    <label class="control-label">Precio</label>
                </div>
            </div>
            <div class="row bg-brown">
                <div class="col-lg-2 col-xs-12">
                    <input type="text" id="cantidad" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,8}'">
                </div>
                <div class="col-lg-4 col-xs-12">
                    <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Seleccionar Artículo" placeholderauto="Artículo inexistente" class="form-control input-sm TextAutoComplete" objectauto="articulos" actionauto="gets_articulos_ajax_stock_y_precio" varsauto="estado:=A" iconauto="ship" autofocus>
                    <input type="hidden" id="articulo" name="articulo" value="">
                </div>
                <div class="col-lg-4 col-xs-12">
                    <input type="text" id="descripcion" class="form-control input-sm">
                </div>
                <div class="col-md-2 col-xs-12">
                    <input type="text" id="precio" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="row bg-brown">
                <div class="col-lg-2 col-xs-12 text-center">
                    <label class="control-label">Fecha de Entrega</label>
                </div>
                <div class="col-lg-8 col-xs-12 text-center">
                    <label class="control-label">Observaciones (No se muestra)</label>
                </div>
                <div class="col-lg-2 col-xs-12 text-center">
                    <label class="control-label">Acciones</label>
                </div>
            </div>
            <div class="form-group bg-brown" style="padding-bottom: 10px">
                <div class="col-lg-2 col-xs-12">
                    <input type="text" id="fecha_articulo" value="<?= date('d/m/Y') ?>" class="form-control input-sm datePicker text-center" placeholder="Seleccione una fecha">
                </div>
                <div class="col-lg-8 col-xs-12">
                    <textarea id="observaciones_item" class="form-control"></textarea>
                </div>
                <div class="col-lg-2 col-xs-12 text-center">
                    <button class="btn btn-sm btn-primary" id="agregar">Agregar Artículo</button>
                    <button class="btn btn-sm btn-primary" id="agregar_loading" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                    <br>
                    <div style="padding: 5px;"></div>
                    <button type="button" id="trazabilidad" class="btn btn-sm btn-success" data-toggle="modal" data-target="#trazabilidad-ajax">Trazabilidad</button>


                </div>
            </div>


            <div class="row">
                <div class="col-lg-2 col-xs-12 col-lg-offset-2">
                    <button type="button" class="btn btn-primary hint--top hint--bounce hint--info" data-toggle="modal" data-target=".bs-example-modal-lg" aria-label="Agregar Artículo">
                        <i class="fa fa-cubes"></i> Crear Artículo
                    </button>
                </div>
                <div class="col-lg-2 col-xs-12">
                    <a class="hint--top hint--bounce hint--info" href="/cotizaciones_clientes/pdf/<?= $cotizacion_cliente['idcotizacion_cliente'] ?>/I/" aria-label="Generar PDF" target="_blank">
                        <button class="btn btn-primary" type="button">
                            <i class="fa fa-file-pdf-o"></i> Generar PDF
                        </button>
                    </a>
                </div>
                <div class="col-lg-2 col-xs-12">
                    <a class="hint--top hint--bounce hint--info" href="/cotizaciones_clientes/pdf/<?= $cotizacion_cliente['idcotizacion_cliente'] ?>/D/" aria-label="Descargar PDF" target="_blank">
                        <button class="btn btn-primary" type="button">
                            <i class="fa fa-download"></i> Descargar PDF
                        </button>
                    </a>
                </div>
                <div class="col-lg-2 col-xs-12">
                    <a onclick="confirmar_mail();">
                        <button type="button" class="btn btn-warning hint--top hint--bounce hint--warning"  aria-label="Enviar PDF por Correo">
                            <i class="fa fa-envelope-o"></i> Enviar por Correo
                        </button>
                    </a>

                </div>
            </div>
            <br>

            <div class="form-group" id="articulos_agregados">

            </div>
        </div>
    </div>
</div




<!-- Large modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="box">
                <div class="box-header bg-light-blue-gradient">
                    <h3 class="box-title">
                        <i class="fa fa-certificate"></i> Administrar Artículos
                    </h3>
                    <div class="row">
                        <div id="notificaciones" class="col-md-offset-2 col-md-8">

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="box-title"><strong><h4>Crear Artículo</h4></strong></div>
                            <div class="form-group">
                                <strong>Artículo</strong>
                                <input type="text" id="articulo_agregar" maxlength="255" class="form-control">
                            </div>
                            <div class="form-group">
                                <strong>Marca</strong>
                                <input type="text" id="TextAutoCompletemarca" name="TextAutoCompletemarca" placeholder="Seleccionar Marca" placeholderauto="Marca inexistente" class="form-control TextAutoComplete" value="" objectauto="marcas" actionauto="gets_marcas_ajax" varsauto="estado:=A">
                                <input type="hidden" id="marca" name="marca" value="">
                            </div>
                            <div class="form-group">
                                <strong>Número de Orden</strong>
                                <input type="text" id="numero_orden" maxlength="9" class="form-control">
                            </div>
                            <div class="form-group">
                                <strong>Línea</strong>
                                <input type="text" id="TextAutoCompletelinea" name="TextAutoCompletelinea" placeholder="Seleccionar Línea" placeholderauto="Línea inexistente" class="form-control TextAutoComplete" value="" objectauto="Lineas" actionauto="gets_lineas_ajax" varsauto="estado:=A" iconauto="ship">
                                <input type="hidden" id="linea" name="linea" value="">
                            </div>
                            <div class="box-footer txC">
                                <button class="btn btn-primary" id="creararticulo" type="button">
                                    Crear Artículo
                                </button>
                                <button class="btn btn-primary" id="creararticulo_loading" type="button" style="display: none;">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="trazabilidad-ajax" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
    <div class="modal-dialog modal-lg" role="document" style="width: 100%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Trazabilidad</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 col-xs-12">
                        <h4>Costo</h4>
                        <div id="trazabilidad-costo-loading" class="text-center" style="display: none;">
                            <h2>
                                <i class="fa fa-refresh fa-spin"></i>
                            </h2>
                        </div>
                        <div id="trazabilidad-costo"></div>
                    </div>
                    <div class="col-lg-5 col-xs-12">
                        <h4>Cotizaciones Anteriores</h4>
                        <div id="trazabilidad-cotizaciones-loading" class="text-center" style="display: none;">
                            <h2>
                                <i class="fa fa-refresh fa-spin"></i>
                            </h2>
                        </div>
                        <div id="trazabilidad-cotizaciones"></div>
                    </div>
                    <div class="col-lg-5 col-xs-12">
                        <h4>Ventas Anteriores</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>