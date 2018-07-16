<div class="box">
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
                    <?php foreach ($articulos as $articulo) { ?>
                        <div class="row listRow listRow2 " id="row_<?=$articulo['idarticulo_generico']?>">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-7">
                                <div class="listRowInner">
                                    <!--<img class="img-circle hideMobile990" src="../../../../skin/images/quotations/default/default.png" alt="ADOLFO FORTIER S.A.">-->
                                    <span class="listTextStrong"><?= $articulo['articulo_generico'] ?></span>
                                    <span class="smallTitle"><b>(ID: <?= $articulo['idarticulo_generico'] ?>)</b></span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 hideMobile990">
                                <div class="listRowInner">
                                    <span class="smallTitle">Línea</span>
                                    <span class="listTextStrong"><span class="label label-info"><?= $articulo['linea'] ?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 hideMobile990">
                                <div class="listRowInner">
                                    <span class="smallTitle">Artículos</span>
                                    <span class="listTextStrong">
                                        <span class="label label-info">
                                            <?=count($articulo['articulos'])?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 hideMobile990">
                                <div class="listRowInner">
                                    <span class="smallTitle">Stock</span>
                                    <?php 
                                    $stock = 0;
                                    foreach($articulo['articulos'] as $a) {
                                        $stock += $a['stock'];
                                    }
                                    ?>
                                    <span class="listTextStrong">
                                        <span class="label <?=($stock > 0)?"label-primary":"label-danger"?>">
                                            <?= $stock ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 hideMobile990"></div>
                            <!-- ////////////////////////////   Información Detallada   //////////////////////////// -->
                            <div class="animated DetailedInformation Hidden col-md-12">
                                <div class="list-margin-top">
                                    <div class="row bg-gray" style="padding:5px;">
                                        <?php foreach($articulo['articulos'] as $art) { ?>
                                        <div class='col-lg-4 col-sm-5 col-xs-12'>
                                            <div class="listRowInner">
                                                <!--<img class=" hideMobile990" src="../../../../skin/images/products/default/default.jpg" alt="16011">-->
                                                <span class="listTextStrong"><?=$art['articulo']?></span>
                                                <span class="smallTitle hideMobile990"><strong><?=$art['linea']?></strong></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-12">
                                            <div class="listRowInner">
                                                <span class="smallTitle">Marca</span>
                                                <span class="emailTextResp">
                                                    <span class="label label-primary"><?=$art['marca']?></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12">
                                            <div class="listRowInner">
                                                <span class="smallTitle">Stock</span>
                                                <span class="listTextStrong"><span class="label bg-navy"><?= $art['stock'] ?></span></span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="listActions flex-justify-center Hidden">
                                <div>
                                    <span class="roundItemActionsGroup">
                                        <a class="hint--bottom hint--bounce" aria-label="Más información">
                                            <button type="button" class="btn bg-navy ExpandButton" id="expand_<?=$articulo['idarticulo_generico']?>"><i class="fa fa-plus"></i></button>
                                        </a>
                                        <a class="hint--bottom hint--bounce" aria-label="Ver Detalle" href="/articulos/modificar/<?= $articulo['idarticulo_generico'] ?>/" id="view_<?=$articulo['idarticulo_generico']?>">
                                            <button type="button" class="btn btn-github"><i class="fa fa-eye"></i></button>
                                        </a>
                                        <!-- <a class="hint--bottom hint--bounce hint--success" aria-label="Crear Orden" process="../../../core/resources/processes/proc.core.php" id="purchase_<?= $articulo['idarticulo'] ?>" status="">
                                          <button type="button" class="btn bg-olive"><i class="fa fa-truck"></i></button>
                                        </a>
                                        <a class="hint--bottom hint--bounce hint--info storeElement" aria-label="Archivar" url="../../../core/resources/processes/proc.core.php" id="store_<?= $articulo['idarticulo'] ?>">
                                          <button type="button" class="btn btn-primary"><i class="fa fa-archive"></i></button>
                                        </a> -->
                                        <a href="/articulos/modificar/<?= $articulo['idarticulo_generico'] ?>/" class="hint--bottom hint--bounce hint--info" aria-label="Editar">
                                            <button type="button" class="btn btnBlue"><i class="fa fa-pencil"></i></button>
                                        </a>
                                        <a class="deleteElement hint--bottom hint--bounce hint--error" aria-label="Eliminar" url="/sucursales/gets_sucusales_ajax/" campo="idsucursal" success="" error="" id="delete_<?= $articulo['idarticulo_generico'] ?>">
                                            <button type="button" class="btn btnRed"><i class="fa fa-trash"></i></button>
                                        </a>
                                        <input id="delete_question_<?= $articulo['idarticulo_generico'] ?>" value="¿Desea eliminar el artículo <b><?= htmlspecialchars($articulo['articulo_generico']) ?></b>?" type="hidden">
                                        <input id="delete_text_ok_<?= $articulo['idarticulo_generico'] ?>" value="El artículo <b><?= htmlspecialchars($articulo['articulo_generico']) ?></b> ha sido eliminado." type="hidden">
                                        <input id="delete_text_error_<?= $articulo['idarticulo_generico'] ?>" value="Hubo un error al intentar eliminar el artículo <b><?= htmlspecialchars($articulo['articulo_generico']) ?></b>." type="hidden">
                                    </span>
                                </div>
                            </div>
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
                        <div class="col-xs-5 col-sm-3 col-md-4" style="margin:0px;padding:0px;margin-top:7px;">
                            <span class="pull-right">Mostrando&nbsp;</span>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-3 txC" style="margin:0px;padding:0px;">
                            <select id="regsperview" name="regsperview" class="form-control chosenSelect txC" firstvalue="" firsttext="" style="display: none;">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25" selected="selected">25</option>
                                <option value="50">50</option><option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-xs-4 col-sm-7 col-md-5" style="margin:0px;padding:0px;margin-top:7px;">
                            &nbsp;de
                            <b><span id="TotalRegs"><?= $total_rows ?></span></b>
                        </div>
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
</div>
