<div class="window Hidden" id="window_traceability">
  <div class="window-border">
    <h4>
      <div class="pull-left"><i class="fa fa-book"></i> Historial de Cotizaciones y Trazabilidad <span id="ProductName" class="font-weight-bold"></span></div>
      <div class="pull-right">
        <div id="WindowClose" class="BtnWindowClose text-red"><i class="fa fa-times"></i></div>
      </div>
    </h4>
  </div>
  <div class="window-body">
    <input type="hidden" id="product" name="product" value="0">
    <input type="hidden" id="item" name="item" value="0">
    <?php //if($Customer=="Y"){ ?>
    <div id="NewQuotationBox" class="box box-success txC">
      <div class="box-header">
        <h3 class="box-title QuotationBoxTitle cursor-pointer">Nueva Cotización de Proveedor</h3>
        <div class="box-tools">
          <button id="CollapseNewForm" type="button" class="btn btn-box-tool NewQuotationBoxToggle" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <input type="hidden" id="new_quotation_dir" name="new_quotation_dir" value="">
        <input type="hidden" id="filecount" name="filecount" value="0">
        <form id="tform">
          <div class="row">
            <div class="col-sm-6 col-xs-12">
              <input type="text" name="TextAutoCompletetprovider" id="TextAutoCompletetprovider" validateEmpty="Ingrese un Proveedor" placeholder="Seleccione un Proveedor" placeholderauto="Proveedor no encontrado" item="1" iconauto="shopping-cart" objectauto="Empresas" actionauto="gets_empresas_ajax" varsauto="proveedor:=Y" class="txC form-control" value="">
              <input type="hidden" id="tprovider" name="tprovider" value="">
            </div>
            <div class="col-sm-6 col-xs-12">
              <select class="form-control chosenSelect" id="tcuerrency" name="tcurrency" validateEmpty="Seleccione una Moneda" data-placeholder="Seleccione una Moneda">
                <?php foreach ($monedas as $moneda){ ?>
                  <option value="<?=$moneda['idmoneda']?>"><?=$moneda['moneda']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-6 col-xs-12">
              <input type="text" id="tprice" name="tprice" value="" class="form-control txC inputMask" data-inputmask="'mask': '9{+}[.99]'" placeholder="Precio" validateEmpty="Ingrese un precio">
                <?php //echo Core::InsertElement('text','tprice','','form-control txC inputMask','data-inputmask="\'mask\': \'9{+}[.99]\'" placeholder="Precio" validateEmpty="Ingrese un precio"'); ?>
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="text" id="tquantity" name="tquantity" value="" class="form-control txC inputMask" data-inputmask="'mask': '9{+}'" placeholder="Cantidad" validateEmpty="Ingrese una cantidad">
              <?php //echo Core::InsertElement('text','tquantity','',' form-control txC inputMask','data-inputmask="\'mask\': \'9{+}\'" placeholder="Cantidad" validateEmpty="Ingrese una cantidad"'); ?>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-6 col-xs-12">
              <input type="text" id="tdate" name="tdate" value="" class="form-control txC delivery_date" placeholder="Fecha" validateEmpty="Ingrese una fecha">
              <?php //echo Core::InsertElement('text','tdate','','form-control txC delivery_date','placeholder="Fecha" validateEmpty="Ingrese una fecha"'); ?>
            </div>
            <div class="col-sm-6 col-xs-12">
              <input type="text" id="tday" name="tday" value="" class="form-control txC inputMask" placeholder="D&iacute;as Entrega" data-inputmask="'mask': '9{+}'" validateEmpty="Ingrese una cantidad de d&iacute;as">
              <?php //echo Core::InsertElement('text','tday',"",'form-control txC inputMask','placeholder="D&iacute;as Entrega" data-inputmask="\'mask\': \'9{+}\'" validateEmpty="Ingrese una cantidad de d&iacute;as"'); ?>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-xs-12">
              <div id="DropzoneContainer" class="dropzone">
                <?php //echo Core::InsertElement('file','dropzonefile','','Hidden form-control','placeholder="Cargar Archivo"'); ?>
              </div>
            </div>
          </div>
          <div class="row txC" id="FileWrapper"></div>
          <br>
          <div class="row">
            <div class="col-xs-12">
              <textarea name="textra" id="textra" class="form-control" placeholder="Datos adicionales"></textarea>
              <?php //echo Core::InsertElement('textarea','textra','','form-control',' placeholder="Datos adicionales"'); ?>
            </div>
          </div>
        </form>
      </div>
      <div class="box-footer clearfix">
        <div class="input-group input-group-sm txC">
          <div class="input-group-btn">
            <button type="button" class="btn btn-success btnGreen BtnSaveQuotation" id="BtnSaveQuotation"><i class="fa fa-check"></i> Guardar Cotizaci&oacute;n</button>
          </div>
        </div>
      </div>
    </div>
    <?php // } ?>
    <div id="ProvidersBox" class="box box-warning txC">
      <div class="box-header">
        <h3 class="box-title QuotationBoxTitle cursor-pointer">Cotizaciones de Proveedores</h3>
          <div class="box-tools pull-right">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input name="table_search" class="form-control pull-right" placeholder="Buscar" type="text">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                <button type="button" id="CollapseQuotations" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <table id="QuotationWrapper" class="table table-hover">
            <tbody><tr id="QuotationWrapperTh" name="QuotationWrapperTh">
              <th class="txC">Fecha</th>
              <th class="txC">Proveedor</th>
              <th class="txC">C&oacute;digo</th>
              <th class="txC">Marca</th>
              <th class="txC">Precio</th>
              <th class="txC">Cantidad</th>
              <th class="txC">Total</th>
              <th class="txC">Entrega</th>
              <th class="txC">Datos Adicionales</th>
              <th class="txC">Archivos</th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php //if($Customer=="Y"){ ?>
    <div id="QuotationsBox" class="box box-primary">
      <div class="box-header with-border txC">
        <h3 class="box-title QuotationBoxTitle cursor-pointer">&Uacute;ltimas cotizaciones al cliente</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive txC">
          <table id="CustomerQuotationWrapper" class="table no-margin">
            <thead>
              <tr>
                <th class="txC">Fecha</th>
                <th class="txC">Precio</th>
                <th class="txC">Cantidad</th>
                <th class="txC">Total</th>
                <th class="txC">Entrega</th>
                <th class="txC">Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
    <?php // } ?>
  </div>
  <div class="window-border txC">
    <button type="button" class="btn btn-primary btnBlue BtnWindowClose"><i class="fa fa-check"></i> OK</button>
    <!--<button type="button" class="btn btn-success btnBlue"><i class="fa fa-dollar"></i> Save & Pay</button>-->
    <!--<button type="button" class="btn btn-error btnRed"><i class="fa fa-times"></i> Cancel</button>-->
  </div>
</div>
