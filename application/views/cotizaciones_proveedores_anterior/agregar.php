<div class="innerContainer main_form">

    <form id="Crear" enctype="multipart/form-data" method="POST">

        <div class="row form-group inline-form-custom">

            <!-- Proveedor -->
            <div class="col-xs-12 col-sm-12">

                <h4 class="subTitleB"><i class="fa fa-ship"></i> Proveedor</h4>

                <input type="text" id="TextAutoCompleteproveedor" name="TextAutoCompleteproveedor" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un proveedor." objectauto="Proveedores" actionauto="gets_proveedores_ajax" iconauto="ship">

                <input type="hidden" id="proveedor" name="proveedor" value="">

            </div>
            <!-- /Proveedor -->

        </div>

        <br>

        <div class="row form-group inline-form-custom">

            <!-- Moneda -->
            <div class="col-xs-12 col-sm-6">

                <h4 class="subTitleB"><i class="fa fa-money"></i> Moneda</h4>

                <select class="form-control chosenSelect" name="moneda" id="moneda" validateEmpty="Seleccione una Moneda" data-placeholder="Seleccione una Moneda">

                    <?php

                        foreach( $monedas as $moneda )
                        {

                    ?>

                    <option value="<?= $moneda[ 'idmoneda' ] ?>"><?= $moneda[ 'moneda' ] ?></option>

                    <?php

                        }

                    ?>
                </select>

            </div>
            <!-- /Moneda -->

            <!-- Fecha -->
            <div class="col-xs-12 col-sm-6">

                <h4 class="subTitleB"><i class="fa fa-calendar"></i> Fecha de Cotizaci&oacute;n</h4>

                <input type="text" name="fechareal" id="fechareal" value="<?= date( 'd/m/Y' ) ?>" class="form-control datePicker" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">

            </div>
            <!-- /Fecha -->

        </div>

        <br>

        <!-- Vencimiento -->
        <h4 class="subTitleB"><i class="fa fa-calendar-times-o"></i> Vencimiento</h4>

        <div class="row form-group inline-form-custom">

            <div class="col-xs-12 col-sm-3">

                <input type="text" id="diasvencimiento" name="diasvencimiento" value="10" class="form-control" validateEmpty="Ingrese cantidad de d&iacute;as" placeholder="Ingrese cantidad de d&iacute;as">

            </div>

            <div class="col-xs-12 col-sm-9">

                <input type="text" id="fechavencimiento" name="fechavencimiento" value="<?= date( 'd/m/Y', $fecha_vencimiento ) ?>" disabled="disabled" class="form-control" placeholder="Fecha Vencimiento">

            </div>

        </div>
        <!-- /Vencimiento -->

        <br>

        <!-- Notas -->
        <h4 class="subTitleB"><i class="fa fa-pencil-square"></i> Notas</h4>

        <div class="row form-group inline-form-custom">

            <div class="col-xs-12">

                <textarea name="notas" id="notas" placeholder="Notas para uso interno" class="form-control"></textarea>

            </div>

        </div>
        <!-- /Notas -->

        <br>

        <h4 class="subTitleB"><i class="fa fa-file"></i> Archivos Adjuntos</h4>

        <!-- <div id="DropzoneCotizacion" class="dropzone txC" subir="/cotizaciones_proveedores/subir_archivo/" eliminar="/cotizaciones_proveedores/eliminar_archivo/" llenar="/cotizaciones_proveedores/gets_archivos_ajax" variables="cotizaciones_proveedores_archivos-idcotizacion:=422" -->
        <div id="DropzoneCotizacion" class="dropzone txC" subir="/cotizaciones_proveedores/subir_archivo/" eliminar="/cotizaciones_proveedores/eliminar_archivo/">

        </div>

        <hr>

        <div class="row txC">

            <button type="button" class="btn btn-success btnGreen" id="BotonCrear"><i class="fa fa-plus"></i> Crear Cotizaci&oacute;n</button>

            <button type="button" class="btn btn-error btnRed" id="BtnCancel"><i class="fa fa-times"></i> Cancelar</button>

        </div>

    </form>

</div>
