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
                            <input id="empresa" name="empresa" class="form-control" placeholder="Empresa" value="<?= $this->input->get('empresa'); ?>" type="text">
                        </div>
                        <div class="input-group col-lg-5 col-md-6 col-sm-5 col-xs-11" style="martin:2px;">
                            <select class="form-control chosenSelect" id="importaciones_estado" name="importaciones_estado">
                                <option value="">Todas</option>
                                <option value="P"<?= ($this->input->get('importaciones_estado') == 'P') ? " selected" : "" ?>>Pedido</option>
                                <option value="C"<?= ($this->input->get('importaciones_estado') == 'C') ? " selected" : "" ?>>Confirmado</option>
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


    <div class="box-body no-padding">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Moneda</th>
                    <th># Items</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importaciones as $importacion) { ?>
                    <tr>
                        <td><?= $importacion['idimportacion'] ?></td>
                        <td><?= $importacion['proveedor'] ?></td>
                        <td><span class="label label-success"><?= $importacion['moneda'] ?></span></td>
                        <td><span class="label label-brown"><?= $importacion['cantidad_items'] ?></span></td>
                        <td>
                            <?php
                            switch ($importacion['importaciones_estado']) {
                                case 'P':
                                    echo "<span class='label label-danger'>PEDIDO</span>";
                                    break;
                                case 'C':
                                    echo "<span class='label label-warning'>CONFIRMADO</span>";
                                    break;
                                case 'E':
                                    echo "<span class='label label-primary'>EMBARCADO</span>";
                                    break;
                                case 'D':
                                    echo "<span class='label label-success'>DESPACHADO</span>";
                                    break;
                                default:
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="/importaciones/agregar_items/<?= $importacion['idimportacion'] ?>/" class="hint--top hint--bounce hint--info" aria-label="Modificar">
                                <button class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix">
        <div class="pull-left">
            <strong>Total <?= $total_rows ?> registros.</strong>
        </div>
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