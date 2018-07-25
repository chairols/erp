<?php if(!$agentes){ ?>
<span class="text-center">Sin Contactos</span>
<?php }else{ ?>
  <div class="row" id="agents_row">
    <div class="col-xs-12">
      <h4 class="subTitleB"><i class="fa fa-male"></i> Contactos</h4>
    </div>
<?php $A=0;
  foreach($agentes as $agente)
  {
      $A++;
      $cargo = $agente['cargo']? '<br><span><i class="fa fa-briefcase"></i> '.$agente['cargo'].'</span>':'';
      $email = $agente['email']? '<br><span><i class="fa fa-envelope"></i> '.$agente['email'].'</span>':'';
      $telefono = $agente['telefono']? '<br><span><i class="fa fa-phone"></i> '.$agente['telefono'].'</span>':'';
      $extra = $agente['extra']? '<br><span><i class="fa fa-info-circle"></i> '.$agente['extra'].'</span>':'';
?>

      <div class="col-md-4 col-sm-4 col-xs-12 AgentCard" id="agent_card_<?=$A?>">
          <div class="info-card-item">
              <input type="hidden" id="agent_id_<?=$A?>_<?=$idsucursal?>" value="<?=$agente['idagente']?>" />
              <input type="hidden" id="agent_name_<?=$A?>_<?=$idsucursal?>" value="<?=$agente['agente']?>" />
              <input type="hidden" id="agent_charge_<?=$A?>_<?=$idsucursal?>" value="<?=$agente['cargo']?>" />
              <input type="hidden" id="agent_email_<?=$A?>_<?=$idsucursal?>" value="<?=$agente['email']?>" />
              <input type="hidden" id="agent_phone_<?=$A?>_<?=$idsucursal?>" value="<?=$agente['telefono']?>" />
              <input type="hidden" id="agent_extra_<?=$A?>_<?=$idsucursal?>" value="<?=$agente['extra']?>" />
              <div class="close-btn DeleteAgent" agente="<?=$A?>"><i class="fa fa-times"></i></div>
              <span><i class="fa fa-user"></i> <b><?=$agente['agente']?></b></span>
              <?php echo $cargo.$telefono.$email.$extra ?>
              <div class="text-center">
                  <button type="button" class="btn btn-sm btn-success SelectAgentBtn" id="select_<?=$A?>" sucursal="<?=$idsucursal?>" agente="<?=$A?>" ><i class="fa fa-check"></i> Seleccionar</button>
              </div>
          </div>
      </div>';
  }
  }
  </div>
<!-- <div class="row txC"> -->
          <!-- <button id="agent_new_'.$ID.'" branch="'.$ID.'" type="button" class="btn btn-info Info-Card-Form-Btn agent_new"><i class="fa fa-plus"></i> Agregar un contacto</button>
      </div>
      <input type="hidden" name="branch_total_agents_<?=$idsucursal?>" id="branch_total_agents_<?=$idsucursal?>" value="<?=count($agentes)?>" sucursal="<?=$idsucursal?>">
      <div id="agent_form_'.$ID.'" class="Info-Card-Form Hidden">
          <form id="new_agent_form_'.$ID.'">
              <div class="info-card-arrow">
                  <div class="arrow-up"></div>
              </div>
              <div class="info-card-form animated fadeIn">
                  <div class="row form-group inline-form-custom">
                      <div class="col-xs-12 col-sm-6">
                          <span class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              '.Core::InsertElement('text','agentname_'.$ID,'','form-control',' placeholder="Nombre y Apellido" validateEmpty="Ingrese un nombre"').'
                          </span>
                      </div>
                      <div class="col-xs-12 col-sm-6 margin-top1em">
                          <span class="input-group">
                              <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                              '.Core::InsertElement('text','agentcharge_'.$ID,'','form-control',' placeholder="Cargo"').'
                          </span>
                      </div>
                  </div>
                  <div class="row form-group inline-form-custom">
                      <div class="col-xs-12 col-sm-6">
                          <span class="input-group">
                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                              '.Core::InsertElement('text','agentemail_'.$ID,'','form-control',' placeholder="Email" validateEmail="Ingrese un email v&aacute;lido."').'
                          </span>
                      </div>
                      <div class="col-xs-12 col-sm-6 margin-top1em">
                          <span class="input-group">
                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                              '.Core::InsertElement('text','agentphone_'.$ID,'','form-control',' placeholder="Tel&eacute;fono"').'
                          </span>
                      </div>
                  </div>
                  <div class="row form-group inline-form-custom">
                      <div class="col-xs-12 col-sm-12">
                          <span class="input-group">
                              <span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
                              '.Core::InsertElement('textarea','agentextra_'.$ID,'','form-control','rows="1" placeholder="Informaci&oacute;n Extra"').'
                          </span>
                      </div>
                  </div>
                  <div class="row txC">
                      <button id="agent_add_'.$ID.'" branch="'.$ID.'" type="button" class="Info-Card-Form-Done btn btnGreen agent_add"><i class="fa fa-check"></i> Agregar</button>
                      <button id="agent_cancel_'.$ID.'" branch="'.$ID.'" type="button" class="Info-Card-Form-Done btn btnRed agent_cancel"><i class="fa fa-times"></i> Cancelar</button>
                  </div>
              </div>
          </form>
      </div> -->

<?php } ?>
