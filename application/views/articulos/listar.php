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
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows sort-activated" order="idarticulo" mode="desc"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="idarticulo" name="idarticulo" class="form-control" validateonlynumbers="Ingrese únicamente números." placeholder="ID de Artículo" type="text">
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="code" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
			        <input id="articulo" name="articulo" value="" class="form-control inputMask" placeholder="Código" type="text">
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="order_number" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="order_number" name="order_number" class="form-control " placeholder="Número de Orden" validateonlynumbers="Ingrese únicamente números." type="text">
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="company" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="rack" name="rack" class="form-control" placeholder="Rack" type="text">
            </div>
            <div class="input-group col-lg-3 col-md-3 col-sm-5 col-xs-11" style="margin:2px;">
				      <span class="input-group-addon order-arrows " order="quantity" mode="DESC"><i class="fa fa-sort-alpha-desc"></i></span>
				      <input id="idmarca" name="idmarca" class="form-control" placeholder="ID Marca" type="text">
            </div>
        	</div>
	        <!-- Submit Button -->
	        <button type="button" class="btn btnGreen searchButton">Buscar</button>
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
		<!-- Seleccionar Todos -->
  	<button aria-label="Seleccionar todos" type="button" id="SelectAll" class="btn animated fadeIn NewElementButton hint--bottom-right hint--bounce"><i class="fa fa-square-o"></i></button>
		<!-- Deseleccionar Todos -->
  	<button type="button" aria-label="Deseleccionar todos" id="UnselectAll" class="btn animated fadeIn NewElementButton Hidden hint--bottom-right hint--bounce"><i class="fa fa-square"></i></button>
  	<!-- Borrar Seleccionados -->
  	<button type="button" aria-label="Eliminar Seleccionados" msjok="¡Los artículos han sido eliminados con éxito!" msjerror="Hubo un error al intentar eliminar los artículos." msjpregunta="¿Desea eliminar los artículos seleccionados?" title="Borrar registros seleccionados" class="btn bg-red animated fadeIn NewElementButton Hidden DeleteSelectedElements hint--bottom hint--bounce hint--error"><i class="fa fa-trash-o"></i></button>
  	<!-- Activar Seleccionados -->
  	<button type="button" aria-label="Activar Seleccionados" msjok="¡Los artículos han sido activados con éxito!" msjerror="Hubo un error al intentar activar los artículos." msjpregunta="¿Desea activar los artículos seleccionados?" class="btn btnGreen animated fadeIn NewElementButton Hidden ActivateSelectedElements hint--bottom hint--bounce hint--success"><i class="fa fa-check-circle"></i></button>
  	<!-- Expandir Seleccionados -->
  	<button type="button" aria-label="Expandir Seleccionados" title="Expandir registros seleccionados" class="btn bg-navy animated fadeIn NewElementButton Hidden ExpandSelectedElements hint--bottom hint--bounce hint--primary"><i class="fa fa-plus"></i></button>
		<!-- Contraer Seleccionados -->
		<button type="button" aria-label="Contraer Seleccionados" title="Contraer registros seleccionados" class="btn bg-navy animated fadeIn NewElementButton Hidden ContractSelectedElements hint--bottom hint--bounce hint--primary"><i class="fa fa-minus"></i></button>
  	<!-- Ir a pantalla de creación -->
  	<a href="/articulos/crear/" class="hint--bottom hint--bounce hint--success" aria-label="Nuevo Artículo"><button type="button" class="NewElementButton btn btnGreen animated fadeIn"><i class="fa fa-plus-square-o"></i></button></a>

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
					<!-- ////////////////////////////   Registros   //////////////////////////// -->
					<?php $color_fila = 'listRow2'; ?>
					<?php foreach ($articulos as $articulo) { ?>
					<?php $color_fila = $color_fila == ' listRow2 '? '':' listRow2 '; ?>
          <div class="row listRow <?= $color_fila ?> " id="row_<?= $articulo['idarticulo'] ?>">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    					<div class="listRowInner">
    						<img class="img-circle hideMobile990" src="/assets/sistema/imagenes/default/producto.jpg" alt="<?= $articulo['articulo'] ?>">
    						<span class="listTextStrong"><?= $articulo['articulo'] ?></span>
    						<span class="smallTitle"><b>(ID: <?= $articulo['idarticulo'] ?>)</b></span>
    					</div>
				    </div>
    				<div class="col-lg-3 col-md-2 col-sm-2 col-xs-3">
  					  <div class="listRowInner">
  						  <span class="smallTitle">Marca</span>
  						  <span class="listTextStrong">
  							  <span class="label label-brown"><?= $articulo['marca'] ?></span>
  						  </span>
  					  </div>
            </div>
					  <div class="col-lg-1 col-md-2 col-sm-3 col-xs-3">
						  <div class="listRowInner">
							  <span class="smallTitle">Línea</span>
							    <span class="listTextStrong"><span class="label label-info"><?= $articulo['linea'] ?></span>
	              </span>
						  </div>
					  </div>
						<div class="col-sm-3 col-xs-12">
							<div class="listRowInner">
								<span class="smallTitle">Stock</span>
								<span class="listTextStrong"><span class="label bg-navy"><?=$articulo['stock']?></span></span>
							</div>
						</div>
				  	<div class="col-lg-1 col-md-1 col-sm-1 hideMobile990"></div>
						<!-- ////////////////////////////   Información Detallada   //////////////////////////// -->
						<div class="animated DetailedInformation Hidden col-md-12">
							<div class="list-margin-top">
							  <div class="row bg-gray" style="padding:5px;">
								  <div class="col-lg-4 col-sm-5 col-xs-12">
									  <div class="listRowInner">
										  <img class=" hideMobile990" src="/assets/sistema/imagenes/default/categoria.png" alt="<?= $articulo['articulo'] ?>">
										  <span class="listTextStrong">Otros datos</span>
										  <span class="smallTitle hideMobile990"><b>Otros datos</b></span>
									  </div>
								  </div>
								  <div class="col-sm-2 col-xs-12">
									  <div class="listRowInner">
										  <span class="smallTitle">Marca</span>
										  <span class="emailTextResp"><span class="label label-brown"><?=$articulo['marca']?></span></span>
									  </div>
								  </div>
									<div class="col-sm-2 col-xs-12">
									  <div class="listRowInner">
										  <span class="smallTitle">Línea</span>
										  <span class="emailTextResp"><span class="label label-brown"><?=$articulo['linea']?></span></span>
									  </div>
								  </div>
								  <div class="col-sm-3 col-xs-12">
									  <div class="listRowInner">
										  <span class="smallTitle">Stock</span>
										  <span class="listTextStrong"><span class="label bg-navy"><?=$articulo['stock']?></span></span>
									  </div>
								  </div>
							  </div>
							</div>
					  </div>
				  	<div class="listActions flex-justify-center Hidden">
	  					<div>
	              <span class="roundItemActionsGroup">
	                <a class="hint--bottom hint--bounce" aria-label="Más información">
	                  <button type="button" class="btn bg-navy ExpandButton" id="expand_<?=$articulo['idarticulo']?>"><i class="fa fa-plus"></i></button>
	                </a>
	                <a class="hint--bottom hint--bounce" aria-label="Ver Detalle" href="/articulos/modificar/<?= $articulo['idarticulo'] ?>/" id="view_68">
	                  <button type="button" class="btn btn-github"><i class="fa fa-eye"></i></button>
	                </a>
	                <!-- <a class="hint--bottom hint--bounce hint--success" aria-label="Crear Orden" process="../../../core/resources/processes/proc.core.php" id="purchase_<?= $articulo['idarticulo'] ?>" status="">
	                  <button type="button" class="btn bg-olive"><i class="fa fa-truck"></i></button>
	                </a>
	                <a class="hint--bottom hint--bounce hint--info storeElement" aria-label="Archivar" url="../../../core/resources/processes/proc.core.php" id="store_<?= $articulo['idarticulo'] ?>">
	                  <button type="button" class="btn btn-primary"><i class="fa fa-archive"></i></button>
	                </a> -->
									<!-- Editar -->
	                <a href="/articulos/modificar/<?= $articulo['idarticulo'] ?>/" class="hint--bottom hint--bounce hint--info" aria-label="Editar">
	                  <button type="button" class="btn btnBlue"><i class="fa fa-pencil"></i></button>
	                </a>
									<?php //if($articulo['estado']=='A'){?>
									<!-- Borrar -->
									<a class="deleteElement hint--bottom hint--bounce hint--error" aria-label="Eliminar" url="/articulos/borrar_ajax/" campo="idarticulo" msjok="El artículo <b><?= htmlspecialchars($articulo['articulo'])?></b> ha sido eliminado." msjerror="Hubo un error al intentar eliminar el artículo <b><?= htmlspecialchars($articulo['articulo'])?></b>." msjpregunta="¿Desea eliminar el artículo <b><?= htmlspecialchars($articulo['articulo'])?></b>?" id="delete_<?= $articulo['idarticulo'] ?>">
	                  <button type="button" class="btn btnRed"><i class="fa fa-trash"></i></button>
	                </a>
								<?php //} if($articulo['estado']=='I'){?>
									<!-- Activar -->
	                <!-- <a class="activateElement hint--bottom hint--bounce hint--success" aria-label="Activar" url="/articulos/activar_ajax/" campo="idarticulo" msjok="El artículo <b><?= htmlspecialchars($articulo['articulo'])?></b> ha sido activado." msjerror="Hubo un error al intentar activar el artículo <b><?= htmlspecialchars($articulo['articulo'])?></b>." msjpregunta="¿Desea activar el artículo <b><?= htmlspecialchars($articulo['articulo'])?></b>?" id="activate_<?= $articulo['idarticulo'] ?>">
	                  <button type="button" class="btn btnGreen"><i class="fa fa-check-circle"></i></button>
	                </a> -->
								<?php //}?>
	              </span>
	            </div>
						</div>
					</div>
					<?php } ?>
					<!-- ////////////////////////////   Registros   //////////////////////////// -->
				</div> <!-- container-fluid -->
      </div>
      <input id="totalregs" name="totalregs" value="<?= $total_rows	?>" type="hidden">
    </div>
    <!-- /Content Container -->
  </div><!-- /.box-body -->
	<div class="box-footer clearfix">
		<!-- Paginator -->
		<div class="form-inline paginationLeft">
			<div class="row">
			  <div class="col-xs-12 col-sm-3 col-md-4">
					<div class="row">
					  <div class="col-xs-5 col-sm-3 col-md-4" style="margin:0px;padding:0px;margin-top:7px;">
					    <span class="pull-right">Mostrando&nbsp;</span>
					  </div>
					  <div class="col-xs-12 col-sm-3 col-md-3 txC" style="margin:0px;padding:0px;">
					    <select id="regsperview" name="regsperview" class="form-control chosenSelect txC" firstvalue="" firsttext="" style="display: none;">

								<option value="5" <?php if($per_page == 5){echo 'selected="selected"';}?>>5</option>
                <option value="10" <?php if($per_page == 10){echo 'selected="selected"';}?>>10</option>
                <option value="25" <?php if($per_page == 25){echo 'selected="selected"';}?>>25</option>
                <option value="50" <?php if($per_page == 50){echo 'selected="selected"';}?>>50</option>
								<option value="100" <?php if($per_page == 100){echo 'selected="selected"';}?>>100</option>
              </select>
            </div>
					  <div class="col-xs-12 col-sm-5 col-md-5" style="margin:0px;padding:0px;margin-top:7px;">
					    &nbsp;de
              <b><span id="TotalRegs"><?= $total_rows ?></span></b>
					  </div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 txC">
					<div class="row">
				    <div class="col-xs-4 txR" style="margin-right:0px;padding-right:2px;margin-top:6px;">
				      Página N°
				    </div>
				    <div class="col-xs-4" style="margin:0px;padding:0px;">
				      <input type="text" id="ir_a_pagina_input" class="input-sm form-control" placeholder="0" style="width:100%;" />
				    </div>
						<div class="col-xs-4 txL" style="margin-left:0px;padding-left:2px;">
				      <button type="button" url="<?= $base_url?>" id="ir_a_pagina_button" id="ir_a_pagina" name="button" class="btn btn-sm btn-default" style="margin:0px;">Ir</button>
				    </div>
				  </div>


						<!--  <button type="button" class="btn btn-primary" name="button">Ir</button>	</button> -->
				</div>
				<div class="col-xs-12 col-sm-5 col-md-5">
				  <ul class="paginationRight pagination no-margin pull-right">
            <?= $links ?>
          </ul>
				</div>
			</div>
    </div>
    <!-- Paginator -->
	</div>
</div>
