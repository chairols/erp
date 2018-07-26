<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-book"></i> Generar Lista de Precios
        </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">Empresa:</div>
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">Moneda:</div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">
                <input type="text" class="form-control" value="<?= $lista_de_precios['empresa']['empresa'] ?>" disabled="">
            </div>
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">
                <select name="moneda" id="moneda" class="form-control chosenSelect">
                    <?php foreach ($monedas as $moneda) { ?>
                        <option value="<?= $moneda['idmoneda'] ?>"<?= ($moneda['idmoneda'] == $lista_de_precios['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">Fecha de Listado:</div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">
                <input type="text" id="fecha" name="fecha" value="<?= $lista_de_precios['fecha'] ?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">Comentarios:</div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-sm-offset-1">
                <textarea class="form-control"><?= $lista_de_precios['comentarios'] ?></textarea>
            </div>
        </div>
        <br>

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
                                    <input id="articulo" name="articulo" class="form-control" placeholder="Artículo" type="text" value="<?= $this->input->get('articulo') ?>">
                                </div>
                                <div class="input-group col-lg-5 col-md-6 col-sm-5 col-xs-11" style="margin:2px;">
                                    <select name="generico" class="form-control chosenSelect">
                                        <option value="T"<?= ($this->input->get('generico') == "T") ? " selected" : "" ?>>Todos</option>
                                        <option value="P"<?= ($this->input->get('generico') == "P") ? " selected" : "" ?>>Pendientes</option>
                                        <option value="F"<?= ($this->input->get('generico') == "F") ? " selected" : "" ?>>Finalizados</option>
                                    </select>
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
            <div class="box-body" id="CoreSearcherResults">
                <!-- /Content Container -->
                <div class="contentContainer txC" id="SearchResult" object="Quotation">
                    <div class="row ListView ListElement animated fadeIn ">
                        <div class="container-fluid">
                            <!-- ////////////////////////////   Registros   //////////////////////////// -->
                            <?php foreach ($items as $item) { ?>
                                <div class="row listRow listRow2 " id="row_<?= $item['idlista_de_precios_item'] ?>">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="listRowInner">
                                            <span class="smallDetails">Código</span>
                                            <input id="codigo_<?= $item['idlista_de_precios_item'] ?>" class="form-control txC" name="codigo_<?= $item['idlista_de_precios_item'] ?>" value="<?= $item['articulo'] ?>" validateEmpty="Ingrese un código" item="<?= $item['idlista_de_precios_item'] ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-xs-12">
                                        <div class="listRowInner">
                                            <span class="smallDetails">Marca</span>
                                            <input type="text" identificador="<?= $item['idlista_de_precios_item'] ?>" id="TextAutoCompletemarca_<?= $item['idlista_de_precios_item'] ?>" name="TextAutoCompletemarca_<?= $item['idlista_de_precios_item'] ?>" placeholder="Seleccionar Marca" placeholderauto="Proveedor inexistente" class="form-control txC autocompletemarca" objectauto="marcas" actionauto="gets_marcas_ajax" iconauto="ship" idmarca="<?= $item['marcas_idmarca'] ?>" value="<?= $item['marcas_marca'] ?>">
                                            <input type="hidden" identificador="<?= $item['idlista_de_precios_item'] ?>" id="marca_<?= $item['idlista_de_precios_item'] ?>" name="marca_<?= $item['idlista_de_precios_item'] ?>" value="<?= $item['marcas_idmarca'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-xs-12">
                                        <div class="listRowInner" id="progressmarca_<?= $item['idlista_de_precios_item'] ?>"></div>
                                    </div>
                                    <div class="col-sm-2 col-xs-12" style="height: 70px;">
                                        <div class="listRowInner"></div>
                                    </div>
                                    <div class="col-sm-2 col-xs-12">
                                        <div class="listRowInner">
                                            <span class="smallDetails">Precio</span>
                                            <input id="precio_<?= $item['idlista_de_precios_item'] ?>" class="txC form-control" name="precio_<?= $item['idlista_de_precios_item'] ?>" value="<?= $item['precio'] ?>" item="<?= $item['idlista_de_precios_item'] ?>" placeholder="Sin Precio" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-12">
                                        <div class="listRowInner">
                                            <span class="smallDetails">Stock</span>
                                            <input id="stock_<?= $item['idlista_de_precios_item'] ?>" class="txC form-control" name="stock_<?= $item['idlista_de_precios_item'] ?>" value="<?= $item['stock'] ?>" item="<?= $item['idlista_de_precios_item'] ?>" placeholder="Sin Stock" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-xs-12">
                                        <div class="listRowInner">
                                            <span class="smallDetails">Código Genérico</span>
                                            <input type="text" identificador="<?= $item['idlista_de_precios_item'] ?>" id="TextAutoCompletegenerico_<?= $item['idlista_de_precios_item'] ?>" name="TextAutoCompletemarca_<?= $item['idlista_de_precios_item'] ?>" placeholder="Seleccionar Artículo Genérico" placeholderauto="Artículo Genérico Inexistente" class="form-control txC autocompletegenerico" idarticulo_generico="<?= $item['articulos_genericos_idarticulo_generico'] ?>" value="<?= $item['articulos_genericos_articulo_generico'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-xs-12">
                                        <div class="listRowInner" id="progressgenerico_<?= $item['idlista_de_precios_item'] ?>"></div>
                                    </div>
                                    <div class="col-sm-2 col-xs-12" style="height: 70px;">
                                        <div class="listRowInner"></div>
                                    </div>
                                    <div class="listActions flex-justify-center Hidden">
                                        <div>
                                            <span class="roundItemActionsGroup">
                                                <a iditem="<?=$item['idlista_de_precios_item']?>" class="borraritem hint--bottom hint--bounce hint--error" aria-label="Descartar">
                                                    <button class="btn btnRed" type="button">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
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
            <div class="box-footer">
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
        </div>
    </div>
    <pre>
        <?php print_r($items); ?>
    </pre>
</div>