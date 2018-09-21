
$( document ).ready( function()
{

		CambiaEmpresa();

		ComprobarBotonSeleccionarContacto();

		FuncionesDeVentanaAgente()

});

function CambiaEmpresa()
{

		$( '#empresa' ).change( function ()
		{

				VaciarAgentes();

				ResetearBotonSeleccionarContacto();

				ComprobarBotonSeleccionarContacto();

		});

}

function ComprobarBotonSeleccionarContacto()
{

		if( $( '#empresa' ).val() )
		{

				$( '#MostrarAgenteBtn' ).attr( 'disabled', false );

		}else{

				$( '#MostrarAgenteBtn' ).attr( 'disabled', true );

		}

}

function ResetearBotonSeleccionarContacto()
{

		$( '#MostrarAgenteBtn' ).html( '<i class="fa fa-times"></i> Seleccionar Contacto' );

		$( '#MostrarAgenteBtn' ).addClass( 'btn-warning' );

		$( '#MostrarAgenteBtn' ).removeClass( 'btn-success' );

		$( '#agente' ).val( '' );

}

function FuncionesDeVentanaAgente()
{

		AgenteAbrirVentana();

		AgenteCerrarVentana();

		DejarSinContacto();

}

function DejarSinContacto()
{

		$( '#Deseleccionar' ).click( function()
		{

				ResetearBotonSeleccionarContacto();

				$( '#AgenteCerrarVentana' ).click();

		});

}

function AgenteAbrirVentana()
{

		$( '#MostrarAgenteBtn' ).click( function()
		{

				AgenteCambiarNombreVentana();

				AgenteLlenarSucursales();

				$( '#VentanaAgente' ).removeClass( 'Hidden' );

		});

}

function AgenteCerrarVentana()
{

		$( '.AgenteCerrarVentana' ).click( function()
		{

				$( '#VentanaAgente' ).addClass( 'Hidden' );

		});

}

function AgenteCambiarNombreVentana()
{

		$( '#AgenteEmpresa' ).html( $( '#TextAutoCompleteempresa' ).val() );

}

function AgenteLlenarSucursales()
{

		var empresa = $( '#empresa' ).val();

		if( empresa )
		{

				datos = { 'idempresa': empresa };

		    $.ajax(
				{
		        type: 'POST',

		        url: '/sucursales/gets_sucursales_ajax/',

		        data: datos,

		        success: function( data )
						{

								$( '#ContenedorSucursales' ).html( data );

								if( $( '#sucursales_agente' ).val() > 0 )
								{

										AgenteLlenarAgentes();

										CambiaSucursal();

								}

		        },

						error: function( error )
						{

								console.log( error );

						}

		    });

		}else{

				VaciarAgentes();

		}

}

function VaciarAgentes()
{

		$( '#ContenedorAgente' ).html( '' );

}

function CambiaSucursal()
{

		$( '#sucursales_agente' ).change( function()
		{

				AgenteLlenarAgentes();

		});

}

function AgenteLlenarAgentes()
{

		var empresa 	= $( '#empresa' ).val();

		var sucursal 	= $( '#sucursales_agente' ).val();

		if( sucursal )
		{

				datos =
				{
		        'idempresa': empresa,

						'idsucursal': sucursal,

						'estado': 'A'

		    };

		    $.ajax(
				{
		        type: 'POST',

		        url: '/agentes/gets_agentes_tarjetas_ajax/',

		        data: datos,

		        success: function( data )
						{

			        	$( '#ContenedorAgente' ).removeClass( 'Hidden' );

			          $( '#ContenedorAgente' ).html( data );

			          BorrarAgente();

			          MostrarFormularioAgenteNuevo();

			          OcultarFormularioAgenteNuevo();

			          CrearAgenteNuevo();

			          SeleccionarAgente();

		        }

		    });

		}

		return false;

}

function SeleccionarAgente()
{

		$( ".SeleccionarAgenteBoton" ).click( function( e )
		{

				e.stopPropagation();

				var sucursal = $( this ).attr( 'sucursal' );

				var agente = $( this ).attr( 'agente' );

				$( '#agente' ).val( $( '#agente_id_' + agente + '_' + sucursal ).val() );

				$( '.AgenteCerrarVentana' ).click();

				$( '#MostrarAgenteBtn' ).html( '<i class="fa fa-male"></i> ' + $( '#agente_nombre_' + agente + '_' + sucursal ).val() );

				$( '#MostrarAgenteBtn' ).removeClass( 'btn-warning' );

				$( '#MostrarAgenteBtn' ).addClass( 'btn-success' );

				return false;

		});

}

////////// BORRADO DE AGENTES

function BorrarAgente()
{

		$( '.BorrarAgente' ).click( function( e )
		{

				e.preventDefault();

				e.stopPropagation();

				var sucursal	= $( '#sucursales_agente' ).val();

				var agente	= $( this ).attr( 'agente' );

				var nombre	= $( '#agente_nombre_' + agente + '_' + sucursal ).val();

				var id		= $( '#agente_id_' + agente + '_' + sucursal ).val();

				alertify.confirm( utf8_decode( '¿Desea eliminar el contacto <strong>' + nombre + '</strong>?' ), function( e )
				{

						if( e )
						{

								EliminarFichaAgente( id, agente );

								return false;

						}

				});

				return false;

		});

}

function EliminarFichaAgente( id, agente )
{

		datos =
		{

				'idagente': id

		};

	  $.ajax(
		{

	        type: 'POST',

	        url: '/agentes/borrar_ajax/',

	        data: datos,

	        cache: false,

	        success: function( respuesta )
					{

	            if( respuesta )
	            {

	                console.log( respuesta );

	                return false;

	            }else{

		            	$( '#ficha_agente_' + agente ).remove();

		            	if( $( '#agente' ).val() && $( '#agente' ).val() == id )
	                {

	                		ResetearBotonSeleccionarContacto();

	                }

									return false;

	            }

	        },

					error: function( respuesta )
					{

							notifyError( 'Ha ocurrido un error al intentar borrar el contacto.' );

							console.log( respuesta );

					}

	    });

	    return false;

}

/////////// CREATE
function MostrarFormularioAgenteNuevo()
{

		$( '.agente_nuevo' ).click( function( e )
		{

				e.stopPropagation();

				var sucursal = $( this ).attr( 'sucursal' );

				$( '#ficha_formulario_agente_' + sucursal ).removeClass( 'Hidden' );

				return false;

		});

}

function OcultarFormularioAgenteNuevo()
{

		$( '.agente_cancelar' ).click( function( e )
		{

				e.stopPropagation();

				var sucursal = $( this ).attr( 'sucursal' );

				$( '#ficha_formulario_agente_' + sucursal ).addClass( 'Hidden' );

		});

}

function CrearAgenteNuevo()
{

		$( '.agente_agregar' ).click( function( e )
		{

				e.preventDefault();

				e.stopPropagation();

				var sucursal = $( this ).attr( 'sucursal' );

				if( validador.validateFields( 'formulario_agente_' + sucursal ) )
				{

						var empresa 	= $( '#empresa' ).val();

						var nombre 		= $( '#agentenombre_' + sucursal ).val();

						var cargo 		= $( '#agentecargo_' + sucursal ).val();

						var email 		= $( '#agenteemail_' + sucursal ).val();

						var telefono	= $( '#agentetelefono_' + sucursal ).val();

						var extra 		= $( '#agenteextra_' + sucursal ).val();

						var datos 		=
						{

								'idsucursal' : sucursal,

								'idempresa' : empresa,

								'agente' : nombre,

								'cargo' : cargo,

								'email' : email,

								'telefono' : telefono,

								'extra' : extra

						}

				    $.ajax(
						{

				        type: 'POST',

				        url: '/agentes/crear_ajax/',

				        data: datos,

				        cache: false,

				        success: function( respuesta )
								{

				            if( respuesta )
				            {

												if( isNaN( respuesta ) )
												{

														notifyError( 'Ha ocurrido un error al intentar crear el contacto.');

														console.log( respuesta );

														return false;

												}else{

														var ID = sucursal;

														var A = parseInt( $( '#total_agentes_sucursal_' + ID ).val() ) + 1;

														var cargoHTML ='';

														var emailHTML ='';

														var telefonoHTML ='';

														var extraHTML ='';

														if( cargo && cargo != undefined )
														{

																cargoHTML = '<br><span><i class="fa fa-briefcase"></i> ' + cargo + '</span>';

														}

														if( email && email != undefined )
														{

																emailHTML = '<br><span><i class="fa fa-envelope"></i> ' + email + '</span>';

														}

														if( telefono && telefono != undefined )
														{

																telefonoHTML = '<br><span><i class="fa fa-phone"></i> ' + telefono + '</span>';

														}

														if( extra && extra != undefined )
														{

																extraHTML = '<br><span><i class="fa fa-info-circle"></i> ' + extra + '</span>';

														}

														var HTML = 	'<div class="col-md-4 col-sm-4 col-xs-12 AgentCard" id="ficha_agente_' + A + '">' +

		                                				'<div class="info-card-item">'+

		                                    				'<input type="hidden" id="agente_id_' + A + '_' + ID + '" value="' + respuesta + '" />' +

		                                    				'<input type="hidden" id="agente_nombre_' + A + '_' + ID + '" value="' + nombre + '" />' +

		                                    				'<input type="hidden" id="agente_cargo_' + A + '_' + ID + '" value="' + cargo + '" />' +

		                                    				'<input type="hidden" id="agente_email_' + A + '_' + ID + '" value="' + email + '" />' +

		                                    				'<input type="hidden" id="agente_telefono_' + A + '_' + ID + '" value="' + telefono + '" />' +

		                                    				'<input type="hidden" id="agente_extra_' + A + '_' + ID + '" value="' + extra + '" />' +

		                                    				'<div class="close-btn BorrarAgente" agente="' + A + '" sucursal="' + ID + '"><i class="fa fa-times"></i></div>' +

		                                    						'<span><i class="fa fa-user"></i> <b>' + nombre + '</b></span>' +

		                                    						cargoHTML + telefonoHTML + emailHTML + extraHTML +

		                                    						'<div class="text-center">' +

		                                        				'<button type="button" class="btn btn-sm btn-success SeleccionarAgenteBoton" id="agente_' + A + '" sucursal="' + ID + '" agente="' + A + '" ><i class="fa fa-check"></i> Seleccionar</button>' +

		                                    				'</div>' +

		                                				'</div>' +

		                            				'</div>';

		                        $( '#total_agentes_sucursal_' + ID ).val( A );

		                        $( '#fila_agentes' ).append( HTML );

		                        BorrarAgente();

		                        SeleccionarAgente();

		                        $( '.agente_cancelar' ).click();

		                        $( '#agentenombre_' + sucursal ).val( '' );

														$( '#agentecargo_' + sucursal ).val( '' );

														$( '#agenteemail_' + sucursal ).val( '' );

														$( '#agentetelefono_' + sucursal ).val( '' );

														$( '#agenteextra_' + sucursal ).val( '' );

												}

										}else{

												notifyError( 'Ha ocurrido un error al intentar crear el contacto.' );

												console.log( 'No devolvió un id.' );

												return false;

				            }

				        },

								error: function( respuesta )
								{

										notifyError( 'Ha ocurrido un error al intentar crear el contacto.' );

										console.log( respuesta );

								}

				    });

				}

				return false;

		});

}
