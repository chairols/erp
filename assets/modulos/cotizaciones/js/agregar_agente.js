$(document).ready(function(){
	AgenteCerrarVentana();
	DeseleccionarAgenteBtn();
	CambioValorEmpresa();
	Deseleccionar();
	$("#MostrarAgenteBtn").click(function(){
		MostrarVentanaAgente();
	});
	if($("#empresa").val())
		LlenarSucursales();
});

function MostrarVentanaAgente()
{
	$("#VentanaAgente").removeClass('Hidden');
	$("#AgenteEmpresa").html($('#TextAutoCompleteempresa').val());
}

function DeseleccionarAgenteBtn()
{
	if($("#empresa").val())
	{
		$("#MostrarAgenteBtn").prop("disabled",false);
	}else{
		$("#MostrarAgenteBtn").prop("disabled",true);
	}
}

function CambioValorEmpresa()
{
	$("#empresa").change(function(){
		DeseleccionarAgenteBtn();
		OcultarContenedorAgentes();
		DeseleccionarAgente();
		LlenarSucursales();
	});
}

function AgenteCerrarVentana()
{
	$(".AgenteCerrarVentana").click(function(){
		$("#VentanaAgente").addClass('Hidden');
		$(".cancelar_agente").click();
	});
}

//////////////// BRANCHES ///////////////////
function LlenarSucursales()
{
	var empresa = $('#empresa').val();
	if(empresa)
	{
		datos = {
        'idempresa': empresa
    };

    $.ajax({
        type: "POST",
        url: '/sucursales/gets_sucusales_ajax/',
        data: datos,
        success: function(data){
					var obj = JSON.parse(data)
					console.log(obj); /// CONTINUAR DESDE ACA
            if(data && data != "[]")
            {
                $('#ContenedorSucursales').html(data);
								console.log(data);
            }else{
								console.log('vacio');
                $('#ContenedorSucursales').html('<select id="sucursales_agente" class="form-control chosenSelect" disabled="disabled" ><option value="0">Sin Sucursales</option</select>');
            }
            chosenSelect();
            MostrarContenedorAgente();
            BorrarAgente();
        }
    });
	}
}

function MostrarContenedorAgente()
{
	$("#sucursales_agente").change(function(){
		if($(this).val())
		{
			LLenarAgentes();
		}
	})
}

function OcultarContenedorAgentes()
{
	$('#ContenedorAgentes').addClass('Hidden');
}

/////////////// AGENTS ////////////////////////
function LLenarAgentes()
{
	var sucursal = $('#sucursales_agente').val();
	if(sucursal)
	{
		var process = process_url;
		var string      = 'id='+ sucursal +'&action=fillagents&object=CompanyAgent';
	    var data;
	    $.ajax({
	        type: "POST",
	        url: process,
	        data: string,
	        cache: false,
	        success: function(data){
	            if(data)
	            {
	            	$('#ContenedorAgentes').removeClass('Hidden');
	                $('#ContenedorAgentes').html(data);
	                BorrarAgente();
	                MostrarFormularioAgenteNuevo();
	                OcultarFormularioAgenteNuevo();
	                CrearAgenteNuevo();
	                SeleccionarAgente();
	            }else{
	                $('#ContenedorAgentes').html('<span class="text-center">Sin Contacto</span>');

	            }
	        }
	    });
	}
	return false;
}


////////// DELETE

function BorrarAgente()
{
	$(".BorrarAgente").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var sucursal	= $("#sucursales_agente").val();
		var card	= $(this).attr("agent");
		var name	= $("#agent_name_"+card+"_"+sucursal).val();
		var id		= $("#agent_id_"+card+"_"+sucursal).val();
		alertify.confirm(utf8_decode('¿Desea eliminar el contacto <strong>'+name+'</strong>?'), function(e){
			if(e)
			{
				RemoveAgent(id,card);
				return false;
			}
		});
		return false;
	});
}

function RemoveAgent(id,card)
{
	var process = process_url;
	var string      = 'id='+ id +'&action=removeagent&object=CompanyAgent';
    var data;
    $.ajax({
        type: "POST",
        url: process,
        data: string,
        cache: false,
        success: function(data){
            if(data)
            {
                console.log(data);
                return false;
            }else{
            	$("#ficha_agente_"+card).remove();
            	if($("#agent").val() && $("#agent").val()==id)
                {
                	DeseleccionarAgente();
                }
                return false;
            }
        }
    });
    return false;
}

/////////// CREATE

function MostrarFormularioAgenteNuevo()
{
	$(".agent_new").click(function(e){
		e.stopPropagation();
		var sucursal = $(this).attr('sucursal');
		$("#formulario_agente_"+sucursal).removeClass('Hidden');
		return false;
	});
}

function OcultarFormularioAgenteNuevo()
{
	$(".cancelar_agente").click(function(e){
		e.stopPropagation();
		var sucursal = $(this).attr('sucursal');
		$("#formulario_agente_"+sucursal).addClass('Hidden');
	});
}

function CrearAgenteNuevo()
{
	$(".agent_add").click(function(e){
		e.stopPropagation();
		var sucursal = $(this).attr('sucursal');
		if(validate.validateFields("formulario_agente_"+sucursal))
		{
			var empresa = $("#empresa").val();
			var name = $('#agentname_'+sucursal).val();
			var charge = $('#agentcharge_'+sucursal).val();
			var email = $('#agentemail_'+sucursal).val();
			var phone = $('#agentphone_'+sucursal).val();
			var extra = $('#agentextra_'+sucursal).val();

			var process = process_url;
			var string  = 'sucursal='+ sucursal + '&empresa=' + empresa + '&name=' + name + '&charge=' + charge + '&email=' + email + '&phone=' + phone + '&extra=' + extra + '&action=addagent&object=CompanyAgent';
		    var data;
		    $.ajax({
		        type: "POST",
		        url: process,
		        data: string,
		        cache: false,
		        success: function(data){
		            if(data)
		            {
						if(isNaN(data))
						{
							notifyError("Ha ocurrido un error al intentar crear el contacto.");
							console.log(data);
							return false;
						}else{
							var ID = sucursal;
							var A = parseInt($("#sucursal_agentes_totales_"+ID).val())+1;
							var chargeHTML ='';
							var emailHTML ='';
							var phoneHTML ='';
							var extraHTML ='';
							if(charge && charge!=undefined)
								chargeHTML = '<br><span><i class="fa fa-briefcase"></i> '+charge+'</span>';
							if(email && email!=undefined)
								emailHTML = '<br><span><i class="fa fa-envelope"></i> '+email+'</span>';
							if(phone && phone!=undefined)
								phoneHTML = '<br><span><i class="fa fa-phone"></i> '+phone+'</span>';
							if(extra && extra!=undefined)
								extraHTML = '<br><span><i class="fa fa-info-circle"></i> '+extra+'</span>';
							var HTML = '<div class="col-md-6 col-sm-6 col-xs-12 AgentCard" id="ficha_agente_'+A+'">'+
                                '<div class="info-card-item">'+
                                    '<input type="hidden" id="agent_id_'+A+'_'+ID+'" value="'+data+'" />'+
                                    '<input type="hidden" id="agent_name_'+A+'_'+ID+'" value="'+name+'" />'+
                                    '<input type="hidden" id="agent_charge_'+A+'_'+ID+'" value="'+charge+'" />'+
                                    '<input type="hidden" id="agent_email_'+A+'_'+ID+'" value="'+email+'" />'+
                                    '<input type="hidden" id="agent_phone_'+A+'_'+ID+'" value="'+phone+'" />'+
                                    '<input type="hidden" id="agent_extra_'+A+'_'+ID+'" value="'+extra+'" />'+
                                    '<div class="close-btn BorrarAgente" agent="'+A+'"><i class="fa fa-times"></i></div>'+
                                    '<span><i class="fa fa-user"></i> <b>'+name+'</b></span>'+
                                    chargeHTML+phoneHTML+emailHTML+extraHTML+
                                    '<div class="text-center">'+
                                        '<button type="button" class="btn btn-sm btn-success SeleccionarAgenteBtn" id="select_'+A+'" sucursal="'+ID+'" agent="'+A+'" ><i class="fa fa-check"></i> Seleccionar</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                            $("#sucursal_agentes_totales_"+ID).val(A);
                            $("#agents_row").append(HTML);
                            BorrarAgente();
                            SeleccionarAgente();
                        	$(".cancelar_agente").click();
                            $('#agentname_'+sucursal).val('');
							$('#agentcharge_'+sucursal).val('');
							$('#agentemail_'+sucursal).val('');
							$('#agentphone_'+sucursal).val('');
							$('#agentextra_'+sucursal).val('');
						}
					}else{
						notifyError("Ha ocurrido un error al intentar crear el contacto.");
						console.log("No data returned.");
						return false;
		            }
		        }
		    });
		}
	});
}

function SeleccionarAgente()
{
	$(".SeleccionarAgenteBtn").click(function(e){
		e.stopPropagation();
		var sucursal = $(this).attr("sucursal");
		var agent = $(this).attr("agent");
		$("#agent").val($("#agent_id_"+agent+"_"+sucursal).val());
		$(".AgenteCerrarVentana").click();
		$("#ShowAgentBtn").html('<i class="fa fa-male"></i> '+$("#agent_name_"+agent+"_"+sucursal).val());
		$("#ShowAgentBtn").removeClass("btn-warning");
		$("#ShowAgentBtn").addClass("btn-success");
		return false;
	});
}

function DeseleccionarAgente()
{
	$("#agent").val('');
	$("#ShowAgentBtn").html('<i class="fa fa-times"></i> Sin Contacto');
	$("#ShowAgentBtn").removeClass("btn-success");
	$("#ShowAgentBtn").addClass("btn-warning");
}

function Deseleccionar()
{
	$("#Deseleccionar").click(function(e){
		e.stopPropagation();
		DeseleccionarAgente();
		$(".AgenteCerrarVentana").click();
	})
}
