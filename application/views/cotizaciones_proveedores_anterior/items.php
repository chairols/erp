<div class="innerContainer main_form">

    <form id="Crear" enctype="multipart/form-data" method="POST">

        <!-- Proveedor -->
        <h4 class="subTitleB"><i class="fa fa-ship"></i> <span class="fs12">Proveedor:</span> <?= $proveedor[ 'proveedor' ] ?></h4>
        <!-- /Proveedor -->

        <!-- Moneda -->
        <h4 class="subTitleB"><i class="fa fa-money"></i> <span class="fs12">Moneda:</span> <?= $moneda[ 'simbolo' ] ?></h4>
        <!-- /Moneda -->

        <!-- Fecha -->
        <h4 class="subTitleB"><i class="fa fa-calendar"></i> <span class="fs12">Fecha de Cotizaci&oacute;n:</span> <?= $cotizacion[ 'fecha_cotizacion' ] ?></h4>
        <!-- /Fecha -->

        <!-- Vencimiento -->
        <h4 class="subTitleB"><i class="fa fa-calendar-times-o"></i> <span class="fs12">Vencimiento:</span> <?= $cotizacion[ 'dias_vencimiento' ] ?> días ( <?= $cotizacion[ 'fecha_vencimiento' ] ?> )</h4>
        <!-- /Vencimiento -->

        <?php if( $cotizacion[ 'notas' ] ) { ?>

        <!-- Notas -->
        <h4 class="subTitleB"><i class="fa fa-pencil-square"></i> <span class="fs12">Notas:</span> <?= $cotizacion[ 'notas' ] ?></h4>
        <!-- /Notas -->

        <?php } ?>

        <!-- <br> -->

        <!-- <h4 class="subTitleB"><i class="fa fa-file"></i> Archivos Adjuntos</h4>

        <div id="DropzoneCotizacion" class="dropzone txC" subir="/cotizaciones_proveedores/subir_archivo/" eliminar="/cotizaciones_proveedores/eliminar_archivo/">

        </div> -->

        <hr>

        <h4 class="subTitleB"><i class="fa fa-cubes"></i> Agregar Artículos</h4>

        <div class="row">

            <div class="col-xs-3 txC">
                <strong>Artículo</strong>
                <br>

                <input type="text" id="TextAutoCompletearticulo" name="TextAutoCompletearticulo" placeholder="Artículo" placeholderauto="Artículo inexistente" class="form-control input-sm TextAutoComplete" value="" validateEmpty="Seleccione un artículo." objectauto="Articulos" actionauto="gets_articulos_ajax" iconauto="cube">
                <input type="hidden" id="articulo" name="articulo" value="">
            </div>

            <div class="col-xs-1 txC">
                <strong>Precio</strong><br>
                <input id="precio" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,8}'" type="text">
            </div>

            <div class="col-xs-1 txC">
                <strong>Cantidad</strong><br>
                <input id="cantidad" class="form-control input-sm inputMask" data-inputmask="'mask': '9{1,8}'" type="text">
            </div>

            <div class="col-xs-2 txC">
                <strong>Dias de Entrega</strong><br>
                <input id="dias_entrega" value="0" class="form-control input-sm txC" placeholder="Ingrese una catidad de días" type="text">
            </div>

            <div class="col-xs-2 txC">
                <strong>Fecha de Entrega</strong><br>
                <input id="fecha_entrega" value="<?= date( 'd/m/Y' ) ?>" class="form-control input-sm txC" placeholder="Ingrese una catidad de días" type="text" disabled="disabled">
            </div>

            <div class="col-xs-3 txC">

                <span id="div-boton-agregar" class=" txC">
                    <button id="agregar" class="btn btn-info " type="button"><i class="fa fa-plus"></i> Agregar</button>
                </span>

                <span id="div-boton-loading" class="input-group-btn Hidden txC">
                    <button class="btn btn-info " type="button">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </span>

            </div>

        </div>

        <hr>

        <div class="row">
            <div class="col-xs-12 table-responsive" id="body-tabla-items">

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th class="txC">Artículo</th>
                            <th class="txC">Precio</th>
                            <th class="txC">Cantidad</th>
                            <th class="txC">Dias de Entrega</th>
                            <th class="txC">Fecha de Entrega</th>
                            <th class="txC">Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td class="txC">6023 RS</td>
                            <td class="txC"><?= $moneda[ 'simbolo' ] ?> 123.31</td>
                            <td class="txC">19</td>
                            <td class="txC">10</td>
                            <td class="txC"><?= date( 'd/m/Y' ) ?></td>
                            <td class="txC"><?= $moneda[ 'simbolo' ] ?> 2,342.89</td>
                            <td class="txC">

                                <button class="btn bg-black btn-xs" onclick="borrar_item(94)">
                                    <i class="fa fa-book"></i>
                                </button>

                                <button class="btn btn-danger btn-xs" onclick="borrar_item(94)">
                                    <i class="fa fa-trash-o"></i>
                                </button>

                            </td>
                        </tr>

                    </tbody>

                </table>

                <div class="row">

                    <div class="col-xs-6"></div>

                    <div class="col-xs-6">

                        <div class="table-responsive">

                            <table class="table">

                                <tbody>

                                    <tr>

                                        <th style="width: 50%">Total Cotización</th>

                                        <td><?= $moneda[ 'simbolo' ] ?> 2,342.89</td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- <hr>

        <div class="row txC">

            <button type="button" class="btn btn-success btnGreen" id="BotonAgregar"><i class="fa fa-plus"></i> Agregar Items</button>

            <button type="button" class="btn btn-error btnRed" id="BtnCancel"><i class="fa fa-times"></i> Cancelar</button>

        </div> -->

    </form>

</div>
