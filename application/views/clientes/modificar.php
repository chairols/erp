<input type="hidden" id="idcliente" value="<?= $cliente['idcliente'] ?>">

<!-- Custom Tabs (Pulled to the right) -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_data" data-toggle="tab" aria-expanded="true"><i class="fa fa-id-card"></i> Datos Principales</a></li>
        <li class=""><a href="#tab_accounting" data-toggle="tab" aria-expanded="false"><i class="fa fa-dollar"></i> Datos Impositivos</a></li>
        <li class=""><a href="#tab_horarios" data-toggle="tab" aria-expanded="false"><i class="fa fa-clock-o"></i> Horarios</a></li>
        <li class=""><a href="#tab_branches" data-toggle="tab" aria-expanded="false"><i class="fa fa-globe"></i> Sucursales</a></li>
        <li class=""><a href="#tab_agentes" data-toggle="tab" aria-expanded="false"><i class="fa fa-black-tie"></i> Agentes</a></li>
        <li class="pull-right header"><i class="fa fa-user"></i> <?= $cliente['cliente'] ?></li>
    </ul>
    <div class="tab-content" style="padding:0px;">
        <div class="tab-pane active txR" id="tab_data" style="padding:10px;">
            <div class="row form-group">
                <label class="control-label col-md-3">Nombre</label>
                <div class="col-md-6">
                    <input type="text" id="cliente" class="form-control" value="<?= $cliente['cliente'] ?>" maxlength="255" autofocus>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">CUIT</label>
                <div class="col-md-6">
                    <input type="text" id="cuit" class="form-control inputMask" value="<?= $cliente['cuit'] ?>" data-inputmask="'mask': '99-99999999-9'">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Tipo de IVA</label>
                <div class="col-md-6 txL">
                    <select class="form-control chosenSelect" id="idtipo_responsable">
                        <?php foreach ($tipos_responsables as $tipo_responsable) { ?>
                            <option value="<?= $tipo_responsable['idtipo_responsable'] ?>"<?= ($tipo_responsable['idtipo_responsable'] == $cliente['idtipo_responsable']) ? " selected" : "" ?>><?= $tipo_responsable['tipo_responsable'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Tipo de Cliente</label>
                <div class="col-md-6 txL">
                    <select class="form-control chosenSelect" id="idempresa_tipo">
                        <?php foreach ($empresas_tipos as $tipo) { ?>
                            <option value="<?= $tipo['idempresa_tipo'] ?>"<?= ($tipo['idempresa_tipo'] == $cliente['idempresa_tipo']) ? " selected" : "" ?>><?= $tipo['empresa_tipo'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Moneda</label>
                <div class="col-md-6 txL">
                    <select class="form-control chosenSelect" id="idmoneda">
                        <?php foreach ($monedas as $moneda) { ?>
                            <option value="<?= $moneda['idmoneda'] ?>"<?= ($moneda['idmoneda'] == $cliente['idmoneda']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Condición de Venta</label>
                <div class="col-md-6 txL">
                    <select class="form-control chosenSelect" id="condicion">
                        <?php foreach ($condiciones as $condicion) { ?>
                            <option value="<?= $condicion['idcondicion_de_venta'] ?>"<?= ($cliente['idcondicion_de_venta'] == $condicion['idcondicion_de_venta']) ? " selected" : "" ?>><?= $condicion['condicion_de_venta'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Límite de Crédito</label>
                <div class="col-md-3 txL">
                    <select id="idmoneda_limite" class="form-control chosenSelect">
                        <?php foreach ($monedas as $moneda) { ?>
                            <option value="<?= $moneda['idmoneda'] ?>"<?= ($moneda['idmoneda'] == $cliente['idmoneda_limite']) ? " selected" : "" ?>><?= $moneda['moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="limite_credito" class="form-control inputMask" value="<?= $cliente['limite_credito'] ?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Sitio Web</label>
                <div class="col-md-6">
                    <input type="text" id="web" class="form-control" value="<?= $cliente['web'] ?>" maxlength="255">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6">
                    <textarea id="observaciones" class="form-control" rows="20"><?= $cliente['observaciones'] ?></textarea>
                </div>
            </div>
            <div class="row form-group txL">

                <label class="control-label col-md-3 txR">Estado</label>

                <div class="col-md-6">

                    <?php if ($cliente['estado'] == 'A') { ?>

                        <span class="label label-success">ACTIVO</span>

                    <?php } else { ?>

                        <span class="label label-danger">INACTIVO</span>

                    <?php } ?>

                </div>

            </div>

            <div class="row form-group txL">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="modificar" class="btn btn-primary">Modificar</button>
                    <button type="button" id="modificar_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>

        </div>

        <!-- /.tab-pane -->
        <div class="tab-pane txR" id="tab_accounting" style="padding:10px;">
            <div class="row form-group">
                <label class="control-label col-md-3">Ingresos Brutos</label>
                <div class="col-md-6">
                    <input type="text" id="iibb" class="form-control" value="<?= $cliente['iibb'] ?>" maxlength="255">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">VAT</label>
                <div class="col-md-6">
                    <input type="text" id="vat" class="form-control" value="<?= $cliente['vat'] ?>" maxlength="255">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Saldo Cuenta Corriente</label>
                <div class="col-md-6">
                    <input type="text" id="saldo_cuenta_corriente" class="form-control inputMask" value="<?= $cliente['saldo_cuenta_corriente'] ?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Saldo Inicial</label>
                <div class="col-md-6">
                    <input type="text" id="saldo_inicial" class="form-control inputMask" value="<?= $cliente['saldo_inicial'] ?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Saldo a Cuenta</label>
                <div class="col-md-6">
                    <input type="text" id="saldo_a_cuenta" class="form-control inputMask" value="<?= $cliente['saldo_a_cuenta'] ?>" data-inputmask="'mask': '9{1,17}.99'">
                </div>
            </div>
            <div class="row form-group txL">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="modificar_datos_impositivos" class="btn btn-primary">Modificar</button>
                    <button type="button" id="modificar_datos_impositivos_loading" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
        </div>
        
        
        <!-- /.tab-pane -->
        <div class="tab-pane txR" id="tab_horarios" style="padding:10px;">
            <div class="row form-group">
                <label class="control-label col-md-3">Día de la Semana</label>
                <div class="col-md-6 txL">
                    <select id="iddia" class="form-control chosenSelect">
                        <?php foreach ($dias as $dia) { ?>
                            <option value="<?= $dia['iddia'] ?>"><?= $dia['dia'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Horario Desde</label>
                <div class="col-md-6 txL bootstrap-timepicker">
                    <input type="text" id="horario_desde" class="form-control timepicker">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Horario Hasta</label>
                <div class="col-md-6 txL bootstrap-timepicker">
                    <input type="text" id="horario_hasta" class="form-control timepicker">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Tipo de Horario</label>
                <div class="col-md-6 txL">
                    <select id="idtipo_horario" class="form-control chosenSelect">
                        <?php foreach ($tipos_horarios as $tipo_horario) { ?>
                            <option value="<?= $tipo_horario['idtipo_horario'] ?>"><?= $tipo_horario['tipo_horario'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Observaciones</label>
                <div class="col-md-6 txL">
                    <textarea class="form-control" id="horario_observaciones"></textarea>
                </div>
            </div>
            <div class="row form-group txL">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar_horario" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_horario_loading" class="btn btn-primary" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
            <div class="row form-group txL" id="horarios">

            </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_branches" style="padding:-10px;">
            <div class="row">
                <div class="col-md-3 no-float txC" id="menu_sucursales" style="border-right:1px solid #eee;display: table-cell;float: none;padding-right:0px;">
                    <?php foreach ($sucursales as $key => $sucursal) { ?>
                        <?php if ($key == 0) { ?>
                            <div class="boton_sucursal_menu info-box-number" sucursal="<?= $sucursal['idcliente_sucursal'] ?>" id="boton_sucursal_menu_<?= $sucursal['idcliente_sucursal'] ?>" style="border-bottom:1px solid #eee;padding:10px 0px;cursor:pointer;">
                                <?= $sucursal['sucursal'] ?>
                            </div>
                        <?php } else { ?>
                            <div class="boton_sucursal_menu" sucursal="<?= $sucursal['idcliente_sucursal'] ?>" id="boton_sucursal_menu_<?= $sucursal['idcliente_sucursal'] ?>" style="border-bottom:1px solid #eee;padding:10px 0px;cursor:pointer;">
                                <?= $sucursal['sucursal'] ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="input-group margin" id="contenedor_nueva_sucursal">
                        <input type="text" class="form-control" id="nombre_nueva_sucursal">
                        <span class="input-group-btn">
                            <button type="button" id="agregar_sucursal" class="btn bg-purple btn-flat"><i class="fa fa-plus"></i></button>
                            <button type="button" id="agregar_sucursal_loading" class="btn bg-purple btn-flat" style="display: none;"><i class="fa fa-refresh fa-spin"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-md-9 no-float" id="sucursales" style="display: table-cell;float: none;">

                    <?php $this->view('clientes/sucursal'); ?>

                </div>

            </div>

        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane txR" id="tab_agentes" style="padding:10px;">
            <div class="row form-group">
                <label class="control-label col-md-3">Sucursal</label>
                <div class="col-md-6 txL">
                    <select id="agentes_sucursal" class="form-control chosenSelect">
                        <?php foreach($sucursales as $sucursal) { ?>
                        <option value="<?=$sucursal['idcliente_sucursal']?>"><?=$sucursal['sucursal']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Cargo</label>
                <div class="col-md-6 txL">
                    <select id="agentes_cargo" class="form-control chosenSelect">
                        <?php foreach ($cargos as $cargo) { ?>
                            <option value="<?= $cargo['idcargo'] ?>"><?= $cargo['cargo'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Nombre</label>
                <div class="col-md-6 txL">
                    <input type="text" id="agente_nombre" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-6 txL">
                    <input type="text" id="agente_email" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="row form-group">
                <label class="control-label col-md-3">Teléfono</label>
                <div class="col-md-6 txL">
                    <input type="text" id="agente_telefono" class="form-control" maxlength="50">
                </div>
            </div>


            <div class="row form-group txL">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" id="agregar_agente" class="btn btn-primary">Agregar</button>
                    <button type="button" id="agregar_agente_loading" class="btn btn-primary" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>
            <div class="row form-group txL" id="agentes">

            </div>
        </div>
        <!-- /.tab-pane -->

    </div>
    <!-- /.tab-content -->

</div>
<!-- nav-tabs-custom -->

