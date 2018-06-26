<div class="box">
	<div class="box-header with-border">
		<!-- Search Filters -->
  	<div class="SearchFilters searchFiltersHorizontal animated fadeIn Hidden" style="margin-bottom:10px;">
      <div class="form-inline" id="SearchFieldsForm">
      	<input id="show_filters" name="show_filters" value="1" type="hidden">
      	<input id="show_grid" name="show_grid" type="hidden">
      	<input id="view_type" name="view_type" value="grid" type="hidden">
      	<input id="view_page" name="view_page" value="1" type="hidden">
      	<input id="view_order_field" name="view_order_field" type="hidden">
      	<input id="view_order_mode" name="view_order_mode" value="DESC" type="hidden">
      	<div class="row">
          <form id="CoreSearcherForm" name="CoreSearcherForm">
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows sort-activated" order="quotation_id" mode="desc"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="quotation_id" name="quotation_id" class="form-control" placeholder="Número de Cotización" type="text">
			        <div id="quotation_idErrorDiv" class="ErrorText Red"></div>
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="code" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
			        <input id="code" name="code" class="form-control inputMask" placeholder="Artículo" type="text">
		          <div id="codeErrorDiv" class="ErrorText Red"></div>
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="order_number" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="order_number" name="order_number" class="form-control " placeholder="Número de Orden" validateonlynumbers="Ingrese únicamente números." type="text">
			        <div id="order_numberErrorDiv" class="ErrorText Red"></div>
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="company" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="company" name="company" class="form-control" placeholder="Empresa" type="text">
			        <div id="companyErrorDiv" class="ErrorText Red"></div>
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="quantity" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="quantity" name="quantity" class="form-control" placeholder="Cantidad" type="text">
			        <div id="quantityErrorDiv" class="ErrorText Red"></div>
            </div>
          </form>
        </div>
        <!-- Submit Button -->
        <button type="button" class="btn btnGreen searchButton">Buscar</button>
        <button type="button" class="btn btnGrey" id="ClearSearchFields">Limpiar</button>
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
	</div>
	<!-- /.box-header -->
	<div class="box-body" id="CoreSearcherResults">
    <!-- /Content Container -->
    <div class="contentContainer txC" id="SearchResult" object="Quotation">
      <div class="row ListView ListElement animated fadeIn ">
        <div class="container-fluid">
          <div class="row listRow listRow2 " id="row_68">
						<div class="col-lg-4 col-md-5 col-sm-5 col-xs-3">
    					<div class="listRowInner">
    						<img class="img-circle hideMobile990" src="../../../../skin/images/quotations/default/default.png" alt="ADOLFO FORTIER S.A.">
    						<span class="listTextStrong">ADOLFO FORTIER S.A.</span>
    						<span class="smallTitle"><b>(ID: 68)</b></span>
    					</div>
				    </div>
    				<div class="col-lg-3 col-md-2 col-sm-2 col-xs-3">
  					  <div class="listRowInner">
  						  <span class="smallTitle">Total</span>
  						  <span class="listTextStrong">
  							  <span class="label label-brown">$ 60.00</span>
  						  </span>
  					  </div>
            </div>
				  </div>
				  <div class="col-lg-1 col-md-2 col-sm-3 col-xs-3">
					  <div class="listRowInner">
						  <span class="smallTitle">Entrega</span>
						    <span class="listTextStrong"><span class="label label-info">03/04/2018</span>
              </span>
					  </div>
				  </div>
				  <div class="col-lg-1 col-md-1 col-sm-1 hideMobile990"></div>
					<div class="animated DetailedInformation Hidden col-md-12">
						<div class="list-margin-top">
						  <div class="row bg-gray" style="padding:5px;">
							  <div class="col-lg-4 col-sm-5 col-xs-12">
								  <div class="listRowInner">
									  <img class=" hideMobile990" src="../../../../skin/images/products/default/default.jpg" alt="16011">
									  <span class="listTextStrong">16011</span>
									  <span class="smallTitle hideMobile990"><b>RODAMIENTO (CBF)</b></span>
								  </div>
							  </div>
							  <div class="col-sm-2 col-xs-12">
								  <div class="listRowInner">
									  <span class="smallTitle">Precio</span>
									  <span class="emailTextResp"><span class="label label-brown">$ 12.00</span></span>
								  </div>
							  </div>
							  <div class="col-sm-3 col-xs-12">
								  <div class="listRowInner">
									  <span class="smallTitle">Cantidad</span>
									  <span class="listTextStrong"><span class="label bg-navy">5</span></span>
								  </div>
							  </div>
						  </div>
						</div>
				  </div>
				  <div class="listActions flex-justify-center Hidden">
  					<div>
              <span class="roundItemActionsGroup">
                <a class="hint--bottom hint--bounce" aria-label="Más información">
                  <button type="button" class="btn bg-navy ExpandButton" id="expand_68"><i class="fa fa-plus"></i></button>
                </a>
                <a class="hint--bottom hint--bounce" aria-label="Ver Detalle" href="view.php?id=68" id="payment_68">
                  <button type="button" class="btn btn-github"><i class="fa fa-eye"></i></button>
                </a>
                <a class="hint--bottom hint--bounce hint--success" aria-label="Crear Orden" process="../../../core/resources/processes/proc.core.php" id="purchase_68" status="">
                  <button type="button" class="btn bg-olive"><i class="fa fa-truck"></i></button>
                </a>
                <a class="hint--bottom hint--bounce hint--info storeElement" aria-label="Archivar" process="../../../core/resources/processes/proc.core.php" id="store_68">
                  <button type="button" class="btn btn-primary"><i class="fa fa-archive"></i></button>
                </a>
                <a href="edit.php?id=68&amp;provider=N&amp;customer=Y&amp;international=N" class="hint--bottom hint--bounce hint--info" aria-label="Editar">
                  <button type="button" class="btn btnBlue"><i class="fa fa-pencil"></i></button>
                </a>
                <a class="deleteElement hint--bottom hint--bounce hint--error" aria-label="Eliminar" process="../../../core/resources/processes/proc.core.php" id="delete_68">
                  <button type="button" class="btn btnRed"><i class="fa fa-trash"></i></button>
                </a>
                <input id="delete_question_68" name="delete_question_68" value="¿Desea eliminar la cotización de <b>ADOLFO FORTIER S.A.</b>?" type="hidden">
                <input id="delete_text_ok_68" name="delete_text_ok_68" value="La cotización de <b>ADOLFO FORTIER S.A.</b> ha sido eliminada." type="hidden">
                <input id="delete_text_error_68" name="delete_text_error_68" value="Hubo un error al intentar eliminar la cotización de <b>ADOLFO FORTIER S.A.</b>." type="hidden">
              </span>
            </div>
					</div>
				</div> <!-- container-fluid -->
      </div> <!-- List row -->
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
              <div class="chosen-container chosen-container-single chosen-container-single-nosearch" title="" id="regsperview_chosen" style="width: 72px;">
                <a class="chosen-single">
                  <span>5</span>
                  <div><b></b></div>
                </a>
                <div class="chosen-drop">
                  <div class="chosen-search">
                    <input class="chosen-search-input" autocomplete="off" readonly="" type="text">
                    <div id="undefinedErrorDiv" class="ErrorText Red"></div>
                  </div>
                  <ul class="chosen-results">
                    <li class="active-result result-selected" style="" data-option-array-index="0">5</li>
                    <li class="active-result" style="" data-option-array-index="1">10</li>
                    <li class="active-result result-selected" style="" data-option-array-index="2">25</li>
                    <li class="active-result" style="" data-option-array-index="3">50</li>
                    <li class="active-result" style="" data-option-array-index="4">100</li>
                  </ul>
                </div>
              </div>
					    <div id="regsperviewErrorDiv" class="ErrorText Red"></div>
            </div>
					  <div class="col-xs-4 col-sm-7 col-md-5" style="margin:0px;padding:0px;margin-top:7px;">
					    &nbsp;de
              <b><span id="TotalRegs">43</span></b>
					  </div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-9">
				  <ul class="paginationRight pagination no-margin pull-right">
            <li class="PrevPage"><a><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
            <li class="active pageElement" page="1"><a>1</a></li>
            <li class="pageElement" page="2"><a>2</a></li>
            <li class="pageElement" page="3"><a>3</a></li>
            <li class="pageElement" page="9"><a>...9</a></li>
            <li class="NextPage"><a><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
          </ul>
				</div>
			</div>
    </div>
    <!-- Paginator -->
	</div>
</div>



  <div class="box">
      <div class="box-header">
          <form method="GET" class="input-group input-group-sm col-md-5">
              <input class="form-control pull-left" name="articulo" placeholder="Artículo" type="text">
              <div class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
          </form>
          <div class="box-tools">
              <ul class="pagination pagination-sm no-margin pull-right">
                  <?= $links ?>
              </ul>
          </div>
      </div>
      <div class="box-body no-padding">
          <table class="table table-bordered table-hover table-striped">
              <tbody>
                  <tr>
                      <th>Artículo</th>
                      <th>Marca</th>
                      <th>Línea</th>
                      <th>Stock</th>
                      <th>Genérico</th>
                      <th>Acciones</th>
                  </tr>
                  <?php foreach ($articulos as $articulo) { ?>
                      <tr>
                          <td><?= $articulo['articulo'] ?></td>
                          <td><?= $articulo['marca'] ?></td>
                          <td><?= $articulo['linea'] ?></td>
                          <td>
                          <?php if ($articulo['stock'] > 0) { ?>
                              <span class="label label-success"><?= $articulo['stock'] ?></span>
                          <?php } else { ?>
                              <span class="label label-danger"><?= $articulo['stock'] ?></span>
                              <? } ?>
                              </td>
                              <td><?= $articulo['articulo_generico'] ?></td>
                              <td>
                                  <a href="/articulos/modificar/<?= $articulo['idarticulo'] ?>/" data-pacement="top" data-toggle="tooltip" data-original-title="Modificar" class="tooltips">
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
              <div class="box-tools">
                  <ul class="pagination pagination-sm no-margin pull-right">
                      <?= $links ?>
              </ul>
          </div>
      </div>
  </div>
