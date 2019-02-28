<div class="box box-primary">

    <div class="box-header with-border">

        <h3 class="box-title">

            Agregar Cliente

        </h3>

    </div>

    <div class="box-body">

        <div class="form-horizontal">

          <div class="row form-group">

              <label class="control-label col-md-3">Nombre</label>

              <div class="col-md-6">

                  <input type="text" id="cliente" class="form-control" value="" maxlength="255" validateEmpty="Ingrese un nombre de cliente" autofocus>

              </div>

          </div>

          <div class="row form-group">

              <label class="control-label col-md-3">CUIT</label>

              <div class="col-md-6">

                  <input type="text" id="cuit" class="form-control inputMask" value="" data-inputmask="'mask': '99-99999999-9'" validateFromFile="/Clientes/validar_cuit_ajax///El CUIT ya existe">

              </div>

          </div>

        </div>

        <div class="row form-group txC">

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                <button type="button" id="agregar" class="btn btn-primary">Agregar</button>

                <button type="button" id="agregar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>

            </div>

        </div>

    </div>

</div>
