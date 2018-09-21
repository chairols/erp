<?php $this->view('/cotizaciones/ventanas/agente'); ?>

<div class="innerContainer main_form">

    <form id="Crear" enctype="multipart/form-data" method="POST" confirmacion="¿Desea crear una nueva cotización?" error="Verifique que el proveedor haya sido seleccionado.">

        <input type="hidden" name="creation_date" id="creation_date" value="<?=date("Y-m-d")?>">

        <div class="row form-group inline-form-custom">

            <!-- Empresa -->
            <div class="col-xs-12 col-sm-8">

                <h4 class="subTitleB"><i class="fa fa-ship"></i> Proveedor</h4>

                <input type="text" id="TextAutoCompleteempresa" name="TextAutoCompleteempresa" placeholder="Proveedor" placeholderauto="Proveedor inexistente" class="form-control TextAutoComplete" value="" validateEmpty="Seleccione un proveedor." objectauto="Empresas" actionauto="gets_empresas_ajax" varsauto="proveedor:=Y" iconauto="ship">

                <input type="hidden" id="empresa" name="empresa" value="">

            </div>
            <!-- /Empresa -->

            <!-- Contacto -->
            <div class="col-xs-12 col-sm-4">

                <h4 class="subTitleB"><i class="fa fa-male"></i> Contacto</h4>

                <div id="agent-wrapper txC" class="mar0 pad0">

                    <input type="hidden" name="agente" id="agente" value="">

                    <strong><button type="button" class="btn btn-lg btn-warning mar0" id="MostrarAgenteBtn"><i class="fa fa-times"></i> Seleccionar Contacto</button></strong>

                </div>

            </div>
            <!-- /Contacto -->

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

                <input type="text" name="fechareal" id="fechareal" value="<?= date( 'd/m/Y' ) ?>" class="form-control delivery_date" validateEmpty="Seleccione una Fecha" placeholder="Seleccione una fecha">

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

        <h4 class="subTitleB"><i class="fa fa-file"></i> Archivos Adjuntos</h4>

        <div id="DropzoneCotizacion" class="dropzone txC" subir="/cotizaciones/subir_archivo/" eliminar="/cotizaciones/eliminar_archivo/">

        </div>

        <hr>

        <div class="row txC">

            <button type="submit" class="btn btn-success btnGreen" id="BotonCrear"><i class="fa fa-plus"></i> Crear Cotizaci&oacute;n</button>

            <button type="button" class="btn btn-error btnRed" id="BtnCancel"><i class="fa fa-times"></i> Cancelar</button>

        </div>

    </form>

</div>
