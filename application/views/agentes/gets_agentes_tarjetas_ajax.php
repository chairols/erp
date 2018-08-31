





<div class="row" id="fila_agentes">

    <div class="col-xs-12">

        <h4 class="subTitleB"><i class="fa fa-male"></i> Contactos</h4>

    </div>

    <?php

        if( !$agentes )
        {

    ?>

    <div class="col-xs-12 txC">

        <span class="text-center">Sin Contactos</span>

    </div>

    <?php

        }else{

            $A=0;

            foreach( $agentes as $agente )
            {

                $A++;

                $cargo = $agente[ 'cargo' ]? '<br><span><i class="fa fa-briefcase"></i> ' . $agente[ 'cargo' ] . '</span>' : '';

                $email = $agente[ 'email' ]? '<br><span><i class="fa fa-envelope"></i> ' . $agente[ 'email' ] . '</span>' : '';

                $telefono = $agente[ 'telefono' ]? '<br><span><i class="fa fa-phone"></i> ' . $agente[ 'telefono' ] . '</span>' : '';

                $extra = $agente[ 'extra' ]? '<br><span><i class="fa fa-info-circle"></i> ' . $agente[ 'extra' ] . '</span>' : '';

    ?>

    <div class="col-md-4 col-sm-4 col-xs-12 AgentCard" id="ficha_agente_<?= $A ?>">

        <div class="info-card-item">

            <input type="hidden" id="agente_id_<?= $A ?>_<?= $idsucursal ?>" value="<?= $agente[ 'idagente' ] ?>" />

            <input type="hidden" id="agente_nombre_<?= $A ?>_<?= $idsucursal ?>" value="<?= $agente[ 'agente' ] ?>" />

            <input type="hidden" id="agente_cargo_<?= $A ?>_<?= $idsucursal ?>" value="<?= $agente[ 'cargo' ] ?>" />

            <input type="hidden" id="agente_email_<?= $A ?>_<?= $idsucursal ?>" value="<?= $agente[ 'email' ] ?>" />

            <input type="hidden" id="agente_telefono_<?= $A ?>_<?= $idsucursal ?>" value="<?= $agente[ 'telefono' ] ?>" />

            <input type="hidden" id="agente_extra_<?= $A ?>_<?= $idsucursal ?>" value="<?= $agente[ 'extra' ] ?>" />

            <div class="close-btn BorrarAgente" agente="<?= $A ?>"><i class="fa fa-times"></i></div>

            <span><i class="fa fa-user"></i> <b><?= $agente[ 'agente' ] ?></b></span>

            <?= $cargo . $telefono . $email . $extra ?>

            <div class="text-center">

                <button type="button" class="btn btn-sm btn-success SeleccionarAgenteBoton" id="agente_<?= $A ?>" sucursal="<?= $idsucursal ?>" empresa="<?= $idempresa ?>" agente="<?= $A ?>" ><i class="fa fa-check"></i> Seleccionar</button>

            </div>

        </div>

    </div>

    <?php

            }

        }

    ?>

</div>

<div class="row txC">

    <button id="agente_nuevo_<?= $idsucursal ?>" sucursal="<?= $idsucursal ?>" empresa="<?= $idempresa ?>" type="button" class="btn btn-info Info-Card-Form-Btn agente_nuevo"><i class="fa fa-plus"></i> Agregar un contacto</button>

</div>

<input type="hidden" name="total_agentes_sucursal_<?= $idsucursal ?>" id="total_agentes_sucursal_<?= $idsucursal ?>" value="<?= count( $agentes ) ?>" sucursal="<?= $idsucursal ?>" empresa="<?= $idempresa ?>">

<div id="ficha_formulario_agente_<?= $idsucursal ?>" class="Info-Card-Form Hidden">

    <form id="formulario_agente_<?= $idsucursal ?>" name="formulario_agente_<?= $idsucursal ?>">

        <div class="info-card-arrow">

            <div class="arrow-up"></div>

        </div>

        <div class="info-card-form animated fadeIn">

            <div class="row form-group inline-form-custom">

                <div class="col-xs-12 col-sm-6">

                    <span class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" name="agentenombre_<?= $idsucursal ?>" id="agentenombre_<?= $idsucursal ?>" class="form-control" placeholder="Nombre y Apellido" validateEmpty="Ingrese un Nombre" />

                    </span>

                </div>

                <div class="col-xs-12 col-sm-6 margin-top1em">

                    <span class="input-group">

                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>

                        <input type="text" name="agentecargo_<?= $idsucursal ?>" id="agentecargo_<?= $idsucursal ?>" class="form-control" placeholder="Cargo" />

                    </span>

                </div>

            </div>

            <div class="row form-group inline-form-custom">

                <div class="col-xs-12 col-sm-6">

                    <span class="input-group">

                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                        <input type="text" name="agenteemail_<?= $idsucursal ?>" id="agenteemail_<?= $idsucursal ?>" class="form-control" placeholder="Email" validateEmail="Ingrese un email v&aacute;lido" />

                    </span>

                </div>

                <div class="col-xs-12 col-sm-6 margin-top1em">

                    <span class="input-group">

                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                        <input type="text" name="agentetelefono_<?= $idsucursal ?>" id="agentetelefono_<?= $idsucursal ?>" class="form-control" placeholder="Tel&eacute;fono" />

                    </span>

                </div>

            </div>

            <div class="row form-group inline-form-custom">

                <div class="col-xs-12 col-sm-12">

                    <span class="input-group">

                        <span class="input-group-addon"><i class="fa fa-info-circle"></i></span>

                        <textarea rows="1" name="agenteextra_<?= $idsucursal ?>" id="agenteextra_<?= $idsucursal ?>" class="form-control" placeholder="Informaci&oacute;n Extra"></textarea>

                    </span>

                </div>

            </div>

            <div class="row txC">

                <button id="agente_agregar_<?= $idsucursal ?>" sucursal="<?= $idsucursal ?>" empresa="<?= $idempresa ?>" type="button" class="Info-Card-Form-Done btn btnGreen agente_agregar"><i class="fa fa-check"></i> Agregar</button>

                <button id="agente_cancelar_<?= $idsucursal ?>" sucursal="<?= $idsucursal ?>" empresa="<?= $idempresa ?>" type="button" class="Info-Card-Form-Done btn btnRed agente_cancelar"><i class="fa fa-times"></i> Cancelar</button>

            </div>

        </div>

    </form>

</div>
