<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="items" id="items" value="1">
<input type="hidden" name="type_id" id="type_id" value="">
<input type="hidden" name="company_type" id="company_type" value="">
<input type="hidden" name="creation_date" id="creation_date" value="<?=date("Y-m-d")?>">
<input type="hidden" name="qfilecount" id="qfilecount" value="0.00">

<?php //include_once('window.quotation.php'); ?>
<?php //include_once('window.product.php'); ?>
<?php //include_once('window.agent.php'); ?>
<?php //if($Customer=='Y') include_once('window.email.php'); ?>

<?php $this->view('/cotizaciones/ventanas/articulo'); ?>
<?php $this->view('/cotizaciones/ventanas/trazabilidad'); ?>
<?php $this->view('/cotizaciones/ventanas/agente'); ?>
<?php $this->view('/cotizaciones/ventanas/email'); ?>

<div class="box animated fadeIn" style="min-width:99%">
  <div class="box-header flex-justify-center">
    <div class="innerContainer main_form" style="min-width:100%">
      <form id="QuotationForm">
        <h4 class="subTitleB"><i class="fa fa-ship"></i> Proveedor</h4>
          <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
              <!-- Autocomplete Empresas -->
              <input type="text" id="TextAutoCompleteempresa" name="TextAutoCompleteempresa" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un proveedor." objectauto="Empresas" actionauto="gets_empresas_ajax" varsauto="proveedor:=Y" iconauto="ship">
              <input type="hidden" id="empresa" name="empresa" value="">
            </div>
          </div>
          <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
              <div id="agent-wrapper">
                <input type="hidden" name="agent" id="agent" value="">
                <strong><button type="button" class="btn btn-lg btn-warning" id="ShowAgentBtn"><i class="fa fa-times"></i> Seleccionar Contacto</button></strong>
              </div>
            </div>
          </div>
          <h4 class="subTitleB"><i class="fa fa-money"></i> Moneda</h4>
          <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
              <select class="form-control chosenSelect" name="moneda" id="moneda" validateEmpty="Seleccione una Moneda" data-placeholder="Seleccione una Moneda">
                <?php foreach ($monedas as $moneda){ ?>
                  <option value="<?=$moneda['idmoneda']?>"><?=$moneda['moneda']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Cotizaci&oacute;n</h4>
          <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
              <input type="text" name="fechareal" id="fechareal" value="<?=date('d/m/Y')?>" class="form-control delivery_date" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">
            </div>
          </div>
          <h4 class="subTitleB"><i class="fa fa-calendar-times-o"></i> Vencimiento</h4>
          <div class="row form-group inline-form-custom">
            <div class="col-xs-12 col-sm-3">
              <input type="text" id="diasvencimiento" name="diasvencimiento" value="10" class="form-control" validateEmpty="Ingrese cantidad de d&iacute;as" placeholder="Ingrese cantidad de d&iacute;as">
            </div>
            <div class="col-xs-12 col-sm-9">
              <input type="text" id="fechavencimiento" name="fechavencimiento" value="<?=date('d/m/Y', $fecha_vencimiento)?>" disabled="disabled" class="form-control" placeholder="Fecha Vencimiento">
            </div>
          </div>
          <?php //if($Provider=="Y"){ ?>
          <h4 class="subTitleB"><i class="fa fa-file"></i> Archivos Adjuntos</h4>
          <div class="row form-group inline-form-custom">
            <div class="col-xs-12">
              <div id="DropzoneQuotation" class="dropzone txC"></div>
            </div>
          </div>
          <div class="row Hidden" id="QFileWrapper"></div>
          <br>
          <?php // } ?>
          <h4 class="subTitleB"><i class="fa fa-cubes"></i> Art&iacute;culos</h4>
          <div style="margin:0px 10px; min-width:90%;">
            <div class="row form-group inline-form-custom bg-brown" style="margin-bottom:0px!important;">
              <div class="col-xs-4 txC">
                <strong>Art&iacute;culo</strong>
              </div>
              <div class="col-xs-1 txC">
                <strong>Precio</strong>
              </div>
              <div class="col-xs-1 txC">
                <strong>Cantidad</strong>
              </div>
              <div class="col-xs-2 txC">
                <strong>Fecha de Entrega</strong>
              </div>
              <div class="col-xs-1 txC">
                <strong>D&iacute;as</strong>
              </div>
              <div class="col-xs-1 txC"><strong>Costo</strong></div>
              <div class="col-xs-2 txC">
                <strong>Acciones</strong>
              </div>
            </div>
            <hr style="margin-top:0px!important;margin-bottom:0px!important;">
            <!--- ITEMS --->
            <div id="ItemWrapper">
              <!--- NEW ITEM --->
              <div id="item_row_1" item="1" class="row form-group inline-form-custom ItemRow bg-gray" style="margin-bottom:0px!important;padding:10px 0px!important;">
                <form id="item_form_1" name="item_form_1">
                  <div class="col-xs-4 txC">
                    <span id="Item1" class="Hidden ItemText1"></span>
                    <input type="text" id="TextAutoCompleteitem_1" name="TextAutoCompleteitem_1" objectauto="Articulos" actionauto="gets_articulos_autocomplete_ajax" value="" class="TextAutoComplete ItemField1 txC form-control itemSelect" validateEmpty="Seleccione un Art&iacute;culo" placeholder="Ingrese un c&oacute;digo" placeholderauto="C&oacute;digo no encontrado" item="1" iconauto="cube" />
                    <input type="hidden" name="item_1" id="item_1" value="">
                    <?php //echo Core::InsertElement("autocomplete","item_1",'','ItemField1 txC form-control itemSelect','validateEmpty="Seleccione un Art&iacute;culo" placeholder="Ingrese un c&oacute;digo" placeholderauto="C&oacute;digo no encontrado" item="1" iconauto="cube"','Product','SearchCodes');?>
                  </div>
                  <div class="col-xs-1 txC">
                    <span id="Precio1" class="Hidden ItemText1"></span>
                    <input type="text" name="precio_1" id="precio_1" class="ItemField1 form-control txC calcable inputMask" value="" data-inputmask="'mask': '9{+}.99'" placeholder="Precio" validateEmpty="Ingrese un precio">
                    <?php //echo Core::InsertElement('text','price_1','','ItemField1 form-control txC calcable inputMask','data-inputmask="\'mask\': \'9{+}.99\'" placeholder="Precio" validateEmpty="Ingrese un precio"'); ?>
                  </div>
                  <div class="col-xs-1 txC">
                    <span id="Cantidad1" class="Hidden ItemText1"></span>
                    <input type="text" id="cantidad_1" name="cantidad_1" class="ItemField1 form-control txC calcable QuantityItem inputMask" value="" data-inputmask="'mask': '9{+}'" placeholder="Cantidad" validateEmpty="Ingrese una cantidad">
                    <?php //echo Core::InsertElement('text','quantity_1','','ItemField1 form-control txC calcable QuantityItem inputMask','data-inputmask="\'mask\': \'9{+}\'" placeholder="Cantidad" validateEmpty="Ingrese una cantidad"'); ?>
                  </div>
                  <div class="col-xs-2 txC">
                    <span id="Fecha1" class="Hidden ItemText1 OrderDate"></span>
                    <input type="text" name="fecha_1" id="fecha_1" class="ItemField1 form-control txC delivery_date" value="" disabled="disabled" placeholder="Fecha de Entrega" validateEmpty="Ingrese una fecha">
                    <?php //echo Core::InsertElement('text','date_1','','ItemField1 form-control txC delivery_date','disabled="disabled" placeholder="Fecha de Entrega" validateEmpty="Ingrese una fecha"'); ?>
                  </div>
                  <div class="col-xs-1 txC">
                    <span id="Dia1" class="Hidden ItemText1 OrderDay"></span>
                    <input type="text" name="dia_1" id="dia_1" class="ItemField1 form-control txC DayPicker inputMask" value="0" placeholder="Días" data-inputmask="'mask': '9{+}'" validateEmpty="Ingrese una cantidad de d&iacute;as">
                    <?php //echo str_replace("00","0",Core::InsertElement('text','day_1',"00",'ItemField1 form-control txC DayPicker inputMask','placeholder="D&iacute;as" data-inputmask="\'mask\': \'9{+}\'" validateEmpty="Ingrese una cantidad de d&iacute;as"')); ?>
                  </div>
                  <div id="item_number_1" class="col-xs-1 txC item_number" total="0" item="1">$ 0.00</div>
                  <div class="col-xs-2 txC">
									  <button type="button" id="SaveItem1" class="btn btnGreen SaveItem" style="margin:0px;" item="1"><i class="fa fa-check"></i></button>
									  <button type="button" id="EditItem1" class="btn btnBlue EditItem Hidden" style="margin:0px;" item="1"><i class="fa fa-pencil"></i></button>
									  <button type="button" id="HistoryItem1" class="btn btn-github HistoryItem hint--bottom hint--bounce Hidden" aria-label="Trazabilidad" style="margin:0px;" item="1"><i class="fa fa-book"></i></button>
									  <!--<button type="button" id="DeleteItem1" class="btn btnRed DeleteItem" style="margin:0px;" item="1"><i class="fa fa-trash"></i></button>-->
  								</div>
  							</form>
              </div>
              <!--- NEW ITEM --->
            </div>
            <!--- TOTALS --->
            <hr style="margin-top:0px!important;">
            <div class="row form-group inline-form-custom bg-brown">
              <div class="col-xs-4 txC">
                Art&iacute;culos Totales: <strong id="TotalItems" >1</strong>
              </div>
              <div class="col-xs-3 txC">
                Cantidad Total: <strong id="TotalQuantity" >0</strong>
              </div>
              <div class="col-xs-3 txC">
                Costo Total: <strong  id="TotalPrice">$ 0.00</strong> <span class="text-danger">(Sin IVA)</span>
                <input type="hidden" name="total_price" id="total_price" value="0">
              </div>
            </div>
            <!--- TOTALS --->
          </div>
          <div class="row">
            <div class="col-sm-6 col-xs-12 txC">
              <button type="button" id="add_quotation_item" class="btn btn-warning"><i class="fa fa-plus"></i> <strong>Agregar Art&iacute;culo</strong></button>
              <button type="button" id="BtnCreateProduct" class="btn btn-info"><i class="fa fa-cube"></i> <strong>Crear Art&iacute;culo</strong></button>
            </div>
            <div class="col-sm-6 col-xs-12 txC">
              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" id="ChangeDays" class="btn bg-teal" style="margin:0px;"><i class="fa fa-flash"></i></button>
                </div>
                <!-- /btn-group -->
                <input type="text" name="change_day" id="change_day" class="form-control" placeholder="Modificar los d&iacute;as de todos los art&iacute;culos" value="">
                <?php //echo Core::InsertElement('text','change_day','','form-control',' placeholder="Modificar los d&iacute;as de todos los art&iacute;culos"'); ?>
              </div>
            </div>
          </div>
          <h4 class="subTitleB"><i class="fa fa-info-circle"></i> Informaci&oacute;n Extra para el Cliente</h4><div class="row form-group inline-form-custom">
          <div class="col-xs-12">
            <textarea name="extra" id="extra" class="form-control" placeholder="Datos adicionales" rows="8" cols="80"></textarea>
            <?php //echo Core::InsertElement('textarea','extra','','form-control',' placeholder="Datos adicionales"'); ?>
          </div>
        </div>
        <hr>
        <div class="row txC">
          <button type="button" class="btn btn-success btnGreen" id="BtnCreate"><i class="fa fa-plus"></i> Crear Cotizaci&oacute;n</button>
          <!--<button type="button" class="btn btn-success btnBlue" id="BtnCreateNext"><i class="fa fa-plus"></i> Crear y Agregar Otra</button>-->
          <!-- <button type="button" class="btn btn-success btnBlue" id="BtnCreateAndEmail"><i class="fa fa-envelope"></i> Crear y Enviar por Email</button> -->
          <button type="button" class="btn btn-error btnRed" id="BtnCancel"><i class="fa fa-times"></i> Cancelar</button>
        </div>
      </form>
    </div>
  </div><!-- box header -->
</div><!-- box -->
