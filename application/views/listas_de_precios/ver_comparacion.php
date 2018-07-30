<div class="box box-primary">
    <div class="box-header with-border">
        <!-- Search Filters -->
        <div class="SearchFilters searchFiltersHorizontal animated fadeIn Hidden" style="margin-bottom:10px;">
            <div class="form-inline" id="SearchFieldsForm">
                <input id="show_filters" name="show_filters" value="1" type="hidden">
                <input id="view_page" name="view_page" value="1" type="hidden">
                <!-- <input id="view_order_field" name="view_order_field" type="hidden">
                <input id="view_order_mode" name="view_order_mode" value="DESC" type="hidden"> -->
                <form id="CoreSearcherForm" name="CoreSearcherForm" method="GET">
                    <!-- ////////////////////////////   Formulario de Búsqueda //////////////////////////// -->
                    <div class="row">
                        <div class="input-group col-lg-5 col-md-6 col-sm-5 col-xs-11" style="margin:2px;">
                            <input id="articulo_generico" name="articulo_generico" class="form-control" placeholder="Artículo" type="text">
                        </div>
                        <div class="input-group col-lg-5 col-md-6 col-sm-5 col-xs-11" style="margin:2px;">
                            <input id="numero_orden" name="numero_orden" class="form-control " placeholder="Número de Orden" validateonlynumbers="Ingrese únicamente números." type="text">
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btnGreen searchButton">Buscar</button>
                    <button type="button" class="btn btnGrey" id="ClearSearchFields">Limpiar</button>
                    <!-- ////////////////////////////   Formulario de Búsqueda //////////////////////////// -->
                </form>
                <!-- Decoration Arrow -->
                <div class="arrow-right-border">
                    <div class="arrow-right-sf"></div>
                </div>
                <!-- Decoration Arrow -->
            </div>
        </div>
        <!-- /Search Filters -->
        <!-- Select All -->
        <button aria-label="Seleccionar todos" type="button" id="SelectAll" class="btn animated fadeIn NewElementButton hint--bottom-right hint--bounce"><i class="fa fa-square-o"></i></button>
        <button type="button" aria-label="Deseleccionar todos" id="UnselectAll" class="btn animated fadeIn NewElementButton Hidden hint--bottom-right hint--bounce"><i class="fa fa-square"></i></button>
        <!--/Select All -->
        <!-- Remove All -->
        <button type="button" aria-label="Eliminar Seleccionados" title="Borrar registros seleccionados" class="btn bg-red animated fadeIn NewElementButton Hidden DeleteSelectedElements hint--bottom hint--bounce hint--error"><i class="fa fa-trash-o"></i></button>
        <!-- /Remove All -->
        <!-- Activate All -->
        <button type="button" aria-label="Activar Seleccionados" class="btn btnGreen animated fadeIn NewElementButton Hidden ActivateSelectedElements hint--bottom hint--bounce hint--success"><i class="fa fa-check-circle"></i></button>
        <!-- /Activate All -->
        <!-- Expand All -->
        <button type="button" aria-label="Expandir Seleccionados" title="Expandir registros seleccionados" class="btn bg-blue animated fadeIn NewElementButton Hidden ExpandSelectedElements hint--bottom hint--bounce hint--primary"><i class="fa fa-list-alt"></i></button>
        <!-- /Expand All -->
        <a href="new.php?&amp;provider=N&amp;customer=Y&amp;international=N" class="hint--bottom hint--bounce hint--success" aria-label="Nueva Cotización"><button type="button" class="NewElementButton btn btnGreen animated fadeIn"><i class="fa fa-plus-square"></i></button></a>
        <input id="selected_ids" name="selected_ids" value="" type="hidden">
        <div class="changeView">
            <button aria-label="Buscar" class="ShowFilters SearchElement btn hint--bottom hint--bounce"><i class="fa fa-search"></i></button>
        </div>
        <br>
        <div class="form-inline paginationLeft">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-3 col-md-9">
                    <ul class="paginationRight pagination no-margin pull-right">
                        <?= $links ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body" id="CoreSearcherResults">
        <!-- /Content Container -->
        <div class="contentContainer txC" id="SearchResult" object="Quotation">
            <div class="row ListView ListElement animated fadeIn ">
                <div class="container-fluid">
                    <!-- ////////////////////////////   Registros   //////////////////////////// -->
                    <?php foreach ($items as $item) { ?>
                        <div class="row listRow listRow2 " id="row_<?= $item['idlista_de_precios_comparacion_item'] ?>">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="listRowInner">
                                    <span class="smallTitle text-muted">Código Genérico</span>
                                    <span class="listTextStrong">
                                        <span class="label bg-purple">
                                            <?= $item['articulo_generico'] ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <div class="listRowInner">
                                    <span class="smallTitle">Stock</span>
                                    <span class="listTextStrong">
                                        <span class="label label-default">
                                            <?php
                                            $stock = 0;
                                            $stock_minimo = 0;
                                            foreach ($item['articulos'] as $articulo) {
                                                $stock += $articulo['stock'];
                                                $stock_minimo += $articulo['stock_min'];
                                            }
                                            ?>
                                            <?= $stock ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <div class="listRowInner">
                                    <span class="smallTitle">Stock Mínimo</span>
                                    <span class="listTextStrong">
                                        <span class="label bg-teal-active">
                                            <?= $stock_minimo ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <div class="listRowInner">
                                    <span class="smallTitle">Balance Stock</span>
                                    <span class="listTextStrong">
                                        <?php if (($stock - $stock_minimo) < 0) { ?>
                                            <span class="label label-danger">
                                            <?php } else { ?>
                                                <span class="label bg-olive">
                                                    <? } ?>
                                                    <?= ($stock - $stock_minimo) ?>
                                                </span>
                                            </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="listRowInner">
                                        <span class="smallTitle"></span>
                                        <span class="listTextStrong"></span>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 hideMobile990"></div>
                                <!-- ////////////////////////////   Información Detallada   //////////////////////////// -->
                                <div class="animated DetailedInformation col-xs-12">
                                    <div class="list-margin-top row" style="background-color: #EEE; padding-top: 5px;">
                                        <div class="col-xs-1">
                                            <span class="listTextStrong">Posición</span>
                                        </div>
                                        <div class="col-xs-2">Proveedor</div>
                                        <div class="col-xs-3">
                                            Cód. Prov -> Roller
                                            <br>
                                            Marca
                                        </div>
                                        <div class="col-xs-1">Precio</div>
                                        <div class="col-xs-3">Stock</div>
                                        <div class="col-xs-1">Ordenar</div>
                                    </div>
                                </div>

                                <?php foreach ($item['items'] as $i) { ?>
                                    <div class="animated DetailedInformation col-xs-12">
                                        <div class="row bg-gray" style="padding-top: 10px; padding-bottom: 10px;">
                                            <div class="col-xs-1">
                                                <div class="listRowInner">
                                                    <span class="label label-success">XXX</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="listRowInner">
                                                    <span class="label label-primary"><?= $i['empresa'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="listRowInner">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <span class="smallTitle">
                                                                <span class="label label-brown"><?= $item['articulo_generico'] ?></span>
                                                                ->
                                                                <span class="label label-brown"><?= $i['articulo'] ?></span>
                                                            </span>
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <span class="listTextStrong">
                                                                <span class="label label-info"><?= $i['marca'] ?></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">
                                                <div class="listRowInner">
                                                    <span class="label label-success"><?= $i['precio'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="listRowInner">
                                                    <span class="label label-primary hint--bottom hint--bounce hint--info" data-toggle="tooltip" data-original-title="Stock del Proveedor">
                                                        <?= $i['stock'] ?>
                                                    </span>
                                                    -
                                                    <span class="label bg-teal-active hint--bottom hint--bounce hint--info" data-toggle="tooltip" data-original-title="Stock Mínimo">
                                                        <?php
                                                        if ($i['articulo_completo']) {
                                                            echo $i['articulo_completo']['stock_min'];
                                                        } else {
                                                            echo "0";
                                                        }
                                                        ?>
                                                    </span>
                                                    -
                                                    <span class="label label-default hint--bottom hint--bounce" data-toggle="tooltip" data-original-title="Stock Actual (Depósito + Importaciones)">
                                                        <?php
                                                        if ($i['articulo_completo']) {
                                                            echo ($i['articulo_completo']['stock'] + $i['articulo_completo']['stock_pending']);
                                                        } else {
                                                            echo "0";
                                                        }
                                                        ?>
                                                    </span>
                                                    -
                                                    <?php if (($i['articulo_completo']['stock'] + $i['articulo_completo']['stock_pending'] - $i['articulo_completo']['stock_min']) < 0) { ?>
                                                        <span class="label label-danger hint--bottom hint--bounce" data-toggle="tooltip" data-original-title="Cantidad a Pedir"><?= ($i['articulo_completo']['stock'] + $i['articulo_completo']['stock_pending'] - $i['articulo_completo']['stock_min']) ?></span>
            <?php } else { ?>
                                                        <span class="label label-success hint--bottom hint--bounce" data-toggle="tooltip" data-original-title="Stock OK"><?= ($i['articulo_completo']['stock'] + $i['articulo_completo']['stock_pending'] - $i['articulo_completo']['stock_min']) ?></span>
            <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
        <?php } ?>
                            </div>
    <?php } ?>
                        <!-- ////////////////////////////   Registros   //////////////////////////// -->
                    </div> <!-- container-fluid -->
                </div>
                <input id="totalregs" name="totalregs" value="43" type="hidden">
            </div>
            <!-- /Content Container -->
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            <!-- Paginator -->
            <div class="form-inline paginationLeft">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="row">

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <ul class="paginationRight pagination no-margin pull-right">
    <?= $links ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Paginator -->
        </div>
        <pre>
    <?php print_r($items) ?>
    </pre>
</div>
