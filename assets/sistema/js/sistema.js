/*--------------------------------------------------------------------------*\
|*                                                                          *|
|*                      Funciones generales del sistema                     *|
|*                                                                          *|
\*--------------------------------------------------------------------------*/


/*
|--------------------------------------------------------------------------
| Inicialización
|--------------------------------------------------------------------------
| En esta función se declaran todas las funciones que deben ser
| inicializadas al cargar la página
|
*/
var process_url = "../../../core/resources/processes/proc.core.php";

$( document ).ready( function()
{

    setDatePicker();

    inputMask();

  	chosenSelect();

  	SetAutoComplete();

  	closeWindow();

    SidebarMenu();

    validateOnSubmit();

  	if( $( 'input[type="file"]' ).length > 0 )
  	{

  	  CustomizedFilefield();

  	}

    //SetDropzones();

});

/*
|--------------------------------------------------------------------------
| DatePicker
|--------------------------------------------------------------------------
| DatePicker es un vendor de js que sirve para transformar inputs de texto
| en inputs de fecha con un calendario desplegable.
|
| Consta de dos funciones:
|
| datePicker - Recibe un elemento del DOM y lo transforma en datePicker.
|
| setDatePicker - Establece los parámetros del calendario y busca todos
| los inputs que tengan la clase "datePicker" y los pasa como argumento de
| la función datePicker.
|
| Ejemplo de uso:
| <input type="text" class="datePicker">
|
*/
function datePicker(element)
{
  $(element).datepicker({
    autoclose:true,
    todayHighlight: true,
    language: 'es'
  });
}

function setDatePicker()
{
  if($(".datePicker").length>0)
  {
    $.fn.datepicker.dates['es'] = {
      days: ["Domingo", "Lunes", "Martes", "Miércoles", "Juves", "Viernes", "Sábado"],
      daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      today: "Hoy",
      clear: "Borrar",
      format: "dd/mm/yyyy",
      titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
      weekStart: 1
    };

    $(".datePicker").each(function(){
      datePicker(this);
    });
  }

}
/*
|--------------------------------------------------------------------------
| AutoComplete
|--------------------------------------------------------------------------
| AutoComplete es un vendor de js que sirve para transformar inputs de texto
| en inputs de busqueda con opciones desplegables, que pueden ser requeridas
| mediante un ajax.
|
| Consta de dos funciones:
|
| SetAutoComplete - Recibe 2 parámetros: "selector" que es la clase con la que
| buscará los inputs y "mode" que determina el modo en el que se visualizarán
| los resultados de la búsqueda.
| Esta función busca cada input que contenga la clase especificada
| ("TextAutoComplete" por defecto) e indicará la configuración inicial
| de acuerdo a los atributos del input. Luego invocará a la función
| "AutoCompleteInput", pasando como parámetro la configuración del input.
|
| AutoCompleteInput - Recibe un ID y otros parámetros de configuración y
| transforma el input en un AutoComplete.
| Cuenta con la opción de modificar su comportamiento, declarando funciones
| que reemplacen a las propias, o se ejecuten en otra instancia:
|
| "autocompleteResponseFunction":
| En esta función, si se declara, se puede agregar comportamiento luego del
| retorno de la llamada de AJAX.
|
| "autocompleteOnSelectBeforeFunction":
| Obtiene un evento, el término de búsqueda y la opción selecionada como
| parámetros. Si se declara, se puede manipular los parametros y agregar
| funcionalidad previa a la perparación de los datos que se enviarán por AJAX.
|
| "autocompleteOnSelectReplaceFunction":
| Obtiene un evento, el término de búsqueda y la opción selecionada como
| parámetros. Si se declara, se puede manipular los parametros y agregar
| funcionalidad reemplazando a la perparación de los datos que se enviarán por
| AJAX.
|
| "autocompleteOnSelectAfterFunction":
| Obtiene un evento, el término de búsqueda y la opción selecionada como
| parámetros. Si se declara, se puede manipular los parametros y agregar
| funcionalidad luego de la perparación de los datos que se enviarán por AJAX.
|
| Ejemplo de uso:
| <input type="text" id="TextAutoCompleteempresa" name="TextAutoCompleteempresa" placeholderauto="Proveedor inexistente" class="TextAutoComplete" objectauto="Empresas" actionauto="gets_empresas_ajax" varsauto="proveedor:=Y" iconauto="ship">
| <input type="hidden" id="empresa" name="empresa">
|
| Atributos:
| placeholderauto: Texto por defecto que se mostrará cuando no se encuentre un resultado.
| objectauto: Controldor donde se ejecutará el AJAX que recarga los resultados.
| actionauto: Método del controlador que procesará el AJAX y devolverá los resultados.
| varsauto: Variables y valores que se pasan adicionalmente al AJAX, se separan por '///'.
| iconauto: Icono que aparecera cuando se muestren las variables.
|
*/
function SetAutoComplete(selector,mode)
{
  if(typeof selector==="undefined")
  {
    selector = ".TextAutoComplete";
  }
  if(typeof mode==="undefined")
  {
    mode = "notags";
  }
	if($(selector).length>0)
	{
		$(selector).each(function(){
		  try {
		     $(this).destroy();
		  } catch (e) {}
			var id = $(this).attr('id').split("TextAutoComplete");

			if($(this).attr("cacheauto"))
			  var cache = ($(this).attr("cacheauto")=='true');
			if($(this).attr("iconauto")) var icon = $(this).attr("iconauto");
			else var icon = '';
			if($(this).attr("charsauto")) var minChars = parseInt($(this).attr("charsauto"));
			else var minChars = 1;
			if($(this).attr("placeholderauto")) var defaultSearchText = $(this).attr("placeholderauto");
			else var defaultSearchText = 'Sin resultados';
			AutoCompleteInput(id[1],cache,icon,minChars,defaultSearchText,mode)
		});
	}
}

var xhr;
function AutoCompleteInput(inputID,cache,icon,minChars,defaultSearchText,mode)
{
  if(typeof minChars==="undefined") {
    minChars = 1;
  }
  if(typeof cache==="undefined") {
    cache = false;
  }
  if(typeof defaultSearchText==="undefined") {
    defaultSearchText = 'Sin resultados';
  }
  if(typeof icon!=="undefined") {
    icon = '<i class="fa fa-'+icon+'"></i> ';
  }else{
  	icon = '';
  }

  $("#TextAutoComplete"+inputID).on('focusin', function(e){ if (!e.minChars) { $("#TextAutoComplete"+inputID).last_val = '\n'; $("#TextAutoCompleteasoc").trigger('keyup.autocomplete'); } });


	$("#TextAutoComplete"+inputID).autoComplete({
    minChars: minChars,
    delay: 600,
    cache: cache,
    // hideResults: false,
    source: function(term, response)
    {
      var object = $("#TextAutoComplete"+inputID).attr("objectauto");
			var action = $("#TextAutoComplete"+inputID).attr("actionauto");
      var target = "/"+object+"/"+action;
      var tableid = inputID;
      if($("#TextAutoComplete"+inputID).attr("tableidauto"))
        tableid = $("#TextAutoComplete"+inputID).attr("tableidauto");

      var variables		= tableid+"="+term;
  	  var field;
      if($("#TextAutoComplete"+inputID).attr("varsauto")!=undefined)
  	  {
    		var properties	= $("#TextAutoComplete"+inputID).attr("varsauto").split('///');
    		for(var i=0;i<properties.length;i++)
    		{
    			field = properties[i].split(":=");
    			if(field[1])
    				variables	= variables + "&" + field[0] + "=" + field[1];
    			else
    				variables	= variables + "&" + properties[i] + "=" + $("#"+properties[i]).val();
    		}
  	  }

      $("#"+inputID).val('');
      $("#"+inputID).change();
      try { xhr.abort(); } catch(e){}
      xhr = $.post(target,variables, function(data){
        if(!data[0])
        {
          data = [{key:"",text:"no-result"}];
        }
        response(data);
        if (typeof autocompleteResponseFunction === "function") {
            autocompleteResponseFunction();
        }
        $(".autocomplete-suggestion").click(function(){
          // console.log("entra");
        })
      },'json');
    },
    renderItem: function (item, search)
    {
      var key = item.text;
      var text = icon+item.text;
      var id = item.id;
      if(key=="no-result")
      {
        key='';
        text='<i>'+defaultSearchText+'</i>'
      }
      return '<div class="autocomplete-suggestion" data-key="'+key+'" data-id="'+id+'" data-val="'+search+'">'+text+'</div>';
    },
    onSelect: function(e, term, item)
    {
      if (typeof autocompleteOnSelectBeforeFunction === "function") {
          autocompleteOnSelectBeforeFunction(e,term,item);
      }
      if (typeof autocompleteOnSelectReplaceFunction === "function") {
          autocompleteOnSelectReplaceFunction(e,term,item);
      }else{
        var textval = item.data('key');
        if(mode=="notags")
          textval = textval.replace(/(<([^>]+)>)/ig,"");
        $("#TextAutoComplete"+inputID).val(textval);
        if( $("#TextAutoComplete"+inputID).val() )
        {

            $("#"+inputID).val(item.data('id'));

        }else{

            $("#"+inputID).val('');

        }
        $("#"+inputID).change();
      }
      if (typeof autocompleteOnSelectAfterFunction === "function") {
          autocompleteOnSelectAfterFunction(e,term,item);
      }
    }
  });
	$("#TextAutoComplete"+inputID).focusout(function(){

	 // console.log( 'ID:' + $("#"+inputID).val() );
   // console.log( 'Input:' + $( this ).val() );

    if( !$( this ).val() || $( this ).val() == '' || $( this ).val() == undefined )

        $( "#TextAutoComplete" + inputID ).val( '' );

	});

  $( '#TextAutoComplete' + inputID ).change( function()
  {

      if( !$( this ).val() || $( this ).val() == undefined )
      {

          $( '#' + inputID ).val( '' );

          $( '#' + inputID ).change();

      }

  });

	return false;
}

/*
|--------------------------------------------------------------------------
| Chosen Select
|--------------------------------------------------------------------------
| Chosen Select es un plugin de js que convierte un select ordinario en uno
| que va mostrando las alternativas posibles a medida que se va escribiendo.
|
| Ejemplo de uso:
| <select class="chosenSelect">
|   <option value="1">Primera opción</option>
|   <option value="2">Segunda opción</option>
| </select>
|
*/
function chosenSelect()
{
  if($('.chosenSelect').length>0)
  {
	  $('.chosenSelect').chosen({disable_search_threshold: 10,search_contains: true,max_shown_results:50});
	  $('select.chosenSelect').children("option[value=' ']").val('');
  }
}

/*
|--------------------------------------------------------------------------
| Input Mask
|--------------------------------------------------------------------------
| Input Mask es un vendor de js que convierte un input del tipo "text" o
| "textarea" en un input con una máscara para ingresar datos formateados.
|
| Definiciones de la máscara:
| 9 : numérico
| a : alfabético
| * : alfanumérico
| []: valor opcional
| {}: repetición de un valor
|
| Ejemplos de uso:
| <input type="text" class="inputMask" data-inputmask="'mask': '**-9999999-aaa'">
| <input type="text" class="inputMask" data-inputmask="'mask': '**-9{7}[-aaa]'">
| Ambos ejemplos generan la misma máscara con la excepción que en el segundo, las
| tres letras que están encerradas entre corchetes son opcionales.
|
| Documentación: https://github.com/RobinHerbots/Inputmask
|
*/
function inputMask()
{
	if($(".inputMask").length>0)
	{
	  $(".inputMask").each(function(){
	    if(!$(this).inputmask("hasMaskedValue"))
	    {
	      $(this).inputmask();  //static mask
	    }
	  })
	}
}

/*
|--------------------------------------------------------------------------
| Notify Error
|--------------------------------------------------------------------------
| Mensaje de error que se muestra de forma temporal.
|
| Ejemplos de uso:
| notifyError('Hubo un error al ejecutar la función',5000);
| notifyError('Hubo un error al ejecutar la función');
|
*/
function notifyError(msgNotify,delay)
{
    if(typeof delay === "undefined") {
        delay = 30000;
    }
    $.notify({
        // options
        message: '<div class="txC"><i class="fa fa-exclamation-circle"></i> '+msgNotify+'</div>'
    },{
        // settings
        type: 'danger',
        allow_dismiss: true,
        delay: delay,
        placement: {
            from: "top",
            align: "center"
        }
    });
}

/*
|--------------------------------------------------------------------------
| Notify Success
|--------------------------------------------------------------------------
| Mensaje satisfactorio que se muestra de forma temporal.
|
| Ejemplos de uso:
| notifySuccess('La función se ha ejecutado correctamente',5000);
| notifySuccess('La función se ha ejecutado correctamente');
|
*/
function notifySuccess(msgNotify,delay)
{
    if(typeof delay === "undefined") {
        delay = 15000;
    }
    $.notify({
        // options
        message: '<div class="txC"><i class="fa fa-check-circle"></i><br>'+msgNotify+'</div>'
    },{
        // settings
        type: 'success',
        allow_dismiss: true,
        delay: delay,
        placement: {
            from: "bottom",
            align: "left"
        }
    });
}

/*
|--------------------------------------------------------------------------
| Notify Info
|--------------------------------------------------------------------------
| Mensaje informativo que se muestra de forma temporal.
|
| Ejemplos de uso:
| notifyInfo('La función puede ser ejecutada en cuando lo desee',5000);
| notifyInfo('La función puede ser ejecutada en cuando lo desee');
|
*/
function notifyInfo(msgNotify,delay)
{
    if(typeof delay === "undefined") {
        delay = 15000;
    }
    $.notify({
        // options
        message: '<div class="txC"><i class="fa fa-info-circle"></i><br>'+msgNotify+'</div>'
    },{
        // settings
        type: 'info',
        allow_dismiss: true,
        delay: delay,
        placement: {
            from: "bottom",
            align: "left"
        }
    });
}

/*
|--------------------------------------------------------------------------
| Notify Warning
|--------------------------------------------------------------------------
| Mensaje preventivo que se muestra de forma temporal.
|
| Ejemplos de uso:
| notifyWarning('Si ejecuta la función ahora no podrá ver los resultados',5000);
| notifyWarning('Si ejecuta la función ahora no podrá ver los resultados');
|
*/
function notifyWarning(msgNotify,delay)
{
    if(typeof delay === "undefined") {
        delay = 30000;
    }
    $.notify({
        // options
        message: '<div class="txC"><i class="fa fa-warning"></i><br>'+msgNotify+'</div>'
    },{
        // settings
        type: 'warning',
        allow_dismiss: true,
        delay: delay,
        placement: {
            from: "bottom",
            align: "left"
        }
    });
}

function notifyMsg(typeMsg,msgNotify)
{
    $.notify({
        // options
        message: msgNotify
    },{
        // settings
        type: typeMsg
    });
}

/*
|--------------------------------------------------------------------------
| Sidebar Menu
|--------------------------------------------------------------------------
| Función que sirve para setear un cookie que determinará si el sidebar
| estará contraido o no.
|
| Se ejecuta al hacer click en el ícono que contrae la barra del menú.
|
*/
function SidebarMenu()
{
  $('#SidebarToggle').click(function(){
    if($('body').hasClass('sidebar-collapse'))
    {
      setCookie("sidebarmenu",'', 365);
    }else{
      setCookie("sidebarmenu",'sidebar-collapse', 365);
    }
  });
}
/////////////////////////////////////////////////// iCheckbox /////////////////////////////////////////////
$( function()
{

    iCheck();

});

function iCheck()
{

    $( '.iCheckbox' ).iCheck(
    {

        inheritID: true,

        cursor: true,

        checkboxClass: 'iCheckbox_changeable icheckbox_square-purple',

        radioClass: 'iRadio_changeable iradio_square-purple'

        //increaseArea: '10%' // optional

    });

}

function iCheckSkin()
{

  switch(localStorage.getItem('skin'))
  {
    case "skin-green":
    case "skin-green-light":
      return "square-green";
    break;

    case "skin-red":
    case "skin-red-light":
      return "square-red";
    break;

    case "skin-purple":
    case "skin-purple-light":
      return "square-purple";
    break;

    case "skin-yellow":
    case "skin-yellow-light":
      return "square-orange";
    break;

    case "skin-blue":
    case "skin-blue-light":
      return "square-blue";
    break;

    case "skin-black":
    case "skin-black-light":
      return "square";
    break;

    default:
      return "square-grey";
    break;
  }
}

// function changeiCheckboxesSkin(iSkin)
// {
//   var newSkin = iCheckSkin(iSkin);
//
//   $(".iRadio_changeable").each(function(){
//     for(var i = 0; i < my_skins.length; i++)
//     {
//       $(this).removeClass("iradio_"+iCheckSkin(my_skins[i]));
//     }
//     $(this).addClass("iradio_"+newSkin);
//   });
//
//   $(".iCheckbox_changeable").each(function(){
//     for(var i = 0; i < my_skins.length; i++)
//     {
//       $(this).removeClass("icheckbox_"+iCheckSkin(my_skins[i]));
//     }
//     $(this).addClass("icheckbox_"+newSkin);
//   });
// }

/////////////////////////////////////// Change Skins ////////////////////////////////////////

var my_skins = [
  "skin-blue",
  "skin-black",
  "skin-red",
  "skin-yellow",
  "skin-purple",
  "skin-green",
  "skin-blue-light",
  "skin-black-light",
  "skin-red-light",
  "skin-yellow-light",
  "skin-purple-light",
  "skin-green-light"
];

setup();

/* Replace Skin */

function change_skin(cls) {
  $.each(my_skins, function (i) {
    $("body").removeClass(my_skins[i]);
  });

  $("body").addClass(cls);
  storeLocal('skin', cls);
  setCookie('renovatio-skin', cls, 365);
  return false;
}

/* Default Skin Configuration */

function setup() {
  var tmp = getLocal('skin');
  if (tmp && $.inArray(tmp, my_skins))
  {
    change_skin(tmp);
    //changeiCheckboxesSkin(tmp);
  }

  $("[data-skin]").on('click', function (e) {
    if($(this).hasClass('knob'))
      return;
    e.preventDefault();
    change_skin($(this).data('skin'));
    //changeiCheckboxesSkin($(this).data('skin'));
  });
}

/*
|--------------------------------------------------------------------------
| GetDataFromForm
|--------------------------------------------------------------------------
| Función que sirve para obtener los valores de los campos de un formulario.
| Devuelve una cadena con los campos del formulario y sus valores, pero solo
| de los campos que tengan un valor. Si el campo está vació, lo omite.
|
*/
function GetDataFromForm(formid)
{
    var data = "";
    $("form#"+formid+" input, form#"+formid+" select").each(function(){
      if($(this).attr("type")=="checkbox")
      {
          notifyWarning("Función de javascript GetDataFromForm() no está preparada para procesar campos del tipo checkbox. Hay que desarrollarlo.");
          return false;
      }else{
        var input = $(this).attr("id");
        if(input==undefined)
          input = $(this).attr("name");

        var value = $(this).val();

        if(value)
        {
          if(data=="") data = input + "=" + value;
          else  data = data + "&" + input + "=" + value;
        }
      }
    });
    return data;
}

//////////////////////////////////////////////////// Submit Data //////////////////////////////////////////////////////
function validateOnSubmit()
{
  $("form").on("submit",function(evento){
    evento.preventDefault();
    var formulario = $(this);
    var textoError = formulario.attr("error");
    if(!textoError) textoError = "Compruebe que los datos ingresados sean correctos.";
    var delay = 10000;
    if(validador.validateFields(formulario))
    {
      askOnSubmit(formulario,evento)
    }else{
      notifyError(textoError,delay);
    }
  });
}

function askOnSubmit(formulario)
{
  var textoConfirmacion = formulario.attr("confirmacion");
  if(textoConfirmacion)
  {
    alertify.confirm(textoConfirmacion, function(e){
      if(e)
      {
        formulario.unbind('submit').submit();
      }
    });
  }else{
    formulario.unbind('submit').submit();
  }
}


function submitData()
{
    var formFiles;
    var checkValue;
    var checkID;
    var elementID;
    var checkbox    = [];
    var checkboxID  = [];
    var variables   = [];
    var data        = new FormData();
    var i           = 0;
    var element;
    var id;
    //tinyMCE.triggerSave(); // Save trigger for TinyMCE editor
    $('textarea,select,input[type!="checkbox"]').each(function()
    {
        elementID   = $(this).attr("id");
        if($(this).attr("type")=="file")
        {
          if($(this).attr("id"))
          {
            formFiles       = document.getElementById(elementID).files;
            element = {id:elementID,value:formFiles[0]}
            variables[variables.length] = element;
          }
        }else{
            element = {id:elementID,value:$(this).val()};
            variables[variables.length] = element;
        }

    });

    $('input[type="checkbox"]:checked').each(function()
    {
        checkID = $(this).attr("id");
        if(checkboxID.indexOf(checkID)==-1)
        {
            checkboxID[checkboxID.length] = checkID;
            checkValue="";
            $('input[type="checkbox"][name="'+checkID+'"]:checked').each(function()
            {
                if(checkValue!="")
                {
                    checkValue = checkValue + "," + $(this).val();
                }else{
                    checkValue = $(this).val();
                }
            });
            //notifyError(checkValue);
            variables[variables.length] = {id:checkID,value:checkValue};
        }
    });

    while(element= variables[i++])
    {
      data.append(element.id,element.value);
    }
    return data;
}

function sumbitFields(process,haveData,noData){
    var data    = submitData();
    $.ajax({
        url: process,
        type:'POST',
        contentType:false,
        data:data,
        processData:false,
        cache:false,
        async:true,
        success: function(rs){
            if(rs)
            {
                haveData(rs);
            }else{
                noData();
            }
        }
    });
}

function askAndSubmit(target,qtext="¿Desea guardar la informaci&oacute;n?",etext="Ha ocurrido un error en el proceso de guardado.",form='*')
{
	if(validador.validateFields(form))
	{
		alertify.confirm(qtext, function(e){
			if(e)
			{
				var process		= process_url;
				var haveData	= function(returningData)
				{
					$("input,select").blur();
					notifyError(etext);
					console.log(returningData);
				}
				var noData		= function()
				{
					document.location = target;
				}
				sumbitFields(process,haveData,noData);
			}
		});
	}
}

///////////////////////////////////////////////////// Attach a Selector //////////////////////////////////////////////////
$(function(){
    $("select,input,textarea").change(function(){
        var attach = $(this).attr("attach");
        if(attach){
            var string = 'value=' + $(this).val();
            var data = attach.split("/");
            var target = $("#"+data[0]);
            var process = data[1];
            var noData = target.attr("default");
            if(target.prop("tagName")=="SELECT") noData = '<option value="' + target.attr("firstvalue") + '">' + target.attr("firsttext") + '</option>';
            $.ajax({
                url: process,
                type:'POST',
                contentType:false,
                data:string,
                processData:false,
                cache:false,
                success: function(rs){
                    if(rs)
                    {
                        target.html(rs);
                    }else{
                        target.html(noData);
                    }
                }
            });
        }

    });
});

//////////////////////////////////////////////////// Validation ///////////////////////////////////////////////////////////////
var validador    = new ValidateFields();

$( function()
{

    validateDivChange();

});

function validateDivChange()
{

    validador.createErrorDivs();

    $( validateElements ).change( function()
    {

        validador.validateOneField( this );

    });

}

/*
| -------------------------------------------------------------------
| DROPZONE
| -------------------------------------------------------------------
| Crea automáticamente los dropzones para los div que tengan la clase
| 'DropZone'.
|
| Si se quiere ejecutar una función al subir un archvio, dicha función
| se debe llamar 'dzsuccess' y debe aceptar 2 parámetros 'archivo' y
| 'datos'.
|
| Si se quiere ejecutar una función al eliminar un archvio, dicha función
| se debe llamar 'dzdrop' y debe aceptar 1 solo parámetro: 'archivo'.
|
| Ejemplo de implementación del div de Dropzone:
| <div  id="DropzoneCotizacion" class="dropzone txC"
|       subir="/cotizaciones_proveedores/subir_archivo/"
|       eliminar="/cotizaciones_proveedores/eliminar_archivo/"
|       llenar="/cotizaciones_proveedores/gets_archivos_ajax"
|       variables="idcotizacion:=2///estado:=A">
|
| * El atributo 'varbiales' es para pasar variables al ajax de 'llenar'
|
*/

function SetDropzones()
{

    Dropzone.options.myAwesomeDropzone = false;

    Dropzone.autoDiscover = false;

		$( '.dropzone' ).each( function()
		{

				SetDropzone( $( this ) );

		});

    LlenarDropzones();

}

function SetDropzone( div )
{
		var id 			= div.attr( 'id' );

		var subir 		= div.attr( 'subir' );

		if( !subir || subir == undefined ) var subir = '/archivos/subir_archivo/';

		var mensaje 	= div.attr( 'mensaje' );

		if( !mensaje || mensaje == undefined ) var mensaje = 'Para subir un archivo haga click o arrastrelo hasta aqu&iacute;.';

		var imagen	= true;

		if( div.attr( 'imagen' ) == 'false' ) imagen	= false;

		var ancho = div.attr( 'imagen-ancho' );

		if( !ancho || ancho == undefined ) var ancho = 120;

		var alto 	= div.attr( 'imagen-alto' );

		if( !alto || alto == undefined ) var alto = 107;

    div.after( '<input type="hidden" id="contador' + id + '" name="contador' + id + '" value="0">' );

		var DivDropzone = new Dropzone( '#' + id,
		{

				url: subir,

        paramName: 'archivo',

				dictDefaultMessage: mensaje,

				createImageThumbnails: imagen,

				thumbnailWidth: ancho,

				thumbnailHeight: alto,

				accept: function( archivo, hecho )
				{
						if( imagen )
						{

								var thumbnail = $( '#' + id + ' .dz-preview.dz-file-preview .dz-image:last' ).children( 'img' );

								switch( archivo.type )
								{

										case 'application/pdf':

												thumbnail.attr( 'src', GetFileIcon( 'pdf', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr( 'height', '100%' );

										break;

										case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':

												thumbnail.attr( 'src', GetFileIcon( 'doc', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr( 'height', '100%' );

										break;

										case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':

												thumbnail.attr( 'src', GetFileIcon( 'xls', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

										case 'application/vnd.ms-excel':

												thumbnail.attr( 'src', GetFileIcon( 'xls', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

										case 'application/zip, application/x-compressed-zip':

												thumbnail.attr( 'src', GetFileIcon( 'zip', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

										case 'application/vnd.ms-powerpointtd':

												thumbnail.attr( 'src', GetFileIcon( 'ppt', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

										case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':

												thumbnail.attr( 'src', GetFileIcon( 'ppt', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

										case 'application/octet-stream':

												thumbnail.attr( 'src', GetFileIcon( 'eml', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

										case 'image/jpeg':
										break;

										case 'image/png':
										break;

										default:

												thumbnail.attr( 'src', GetFileIcon( 'txt', 'big' ) );

												thumbnail.attr( 'width', '100%' );

												thumbnail.attr('height', '100%' );

										break;

								}

						}

						hecho();

				}

		});

		DivDropzone.on( 'sending', function( archivo, xhr, formData )
		{



    });

    DivDropzone.on( 'addedfile', function( archivo )
		{
        var id = archivo.previewElement.parentElement.id;

        var botonEliminar = Dropzone.createElement( '<button id="ultimoboton' + id + '" class="btn btn-danger d-inline" style="cursor: pointer;"><i class="fa fa-times"></i></button>' );

        var linkBoton 		= Dropzone.createElement( '<a id="ultimolink' + id + '" class="btn btn-primary d-inline" target="_blank" style="margin-left:5px;cursor: pointer;"><i class="fa fa-download"></i></a>' );

				var _this = this;

        botonEliminar.addEventListener( 'click', function( e )
        {

            e.preventDefault();

            e.stopPropagation();

            EliminarArchivoDeContenedor( $( this ) );

        });

        archivo.previewElement.appendChild( botonEliminar );

        archivo.previewElement.appendChild( linkBoton );

    });

    DivDropzone.on( 'success', function( archivo, datos )
		{

        try
        {

            datos = JSON.parse( datos );

            if( typeof dzsuccess === "function" )
            {

                dzsuccess( archivo, datos );

            }

        }

        catch( e )
        {

            notifyError( 'Ha ocurrido un error al intentar subir el archivo seleccionado.' );

            console.log( 'Error: ' + datos );

        }

        if( datos.id )
        {

						var id = archivo.previewElement.parentElement.id;

            var contador = parseInt( $( '#contador' + id ).val() ) + 1;

            var ArchivoNuevoHTML = '<input type="hidden" id="idarchivo_' + contador + '" value="' + datos.id + '" >';

            $( '#ContenedorArchivos' ).append( ArchivoNuevoHTML );

            $( '#contador' + id ).val( contador );

            var EliminarBotonHTML = $( '#ultimoboton' + id );

            EliminarBotonHTML.addClass( 'EliminarArchivoDeContenedor' + id );

            EliminarBotonHTML.attr( 'id', 'archivo_' + id + '_' + contador );

            EliminarBotonHTML.attr( 'idarchivo', datos.id );

            EliminarBotonHTML.attr( 'nombrearchivo', datos.raw_name );

            EliminarBotonHTML.attr( 'urlarchivo', datos.url );

            $('#ultimolink' + id ).attr( 'href', datos.url );

            $('#ultimolink' + id ).attr( 'id', 'link_' + id + '_' + contador );

        }
    });

    DivDropzone.on( 'drop', function( archivo )
		{

        $( '#' + archivo.previewElement.parentElement.id + ' .dz-default' ).hide();

        if( typeof dzdrop === "function" )
        {

            dzdrop( archivo );

        }

    });

    DivDropzone.on( 'complete', function( archivo )
		{

        if( $( '.EliminarArchivoDeContenedor' + archivo.previewElement.parentElement.id ).length == 0 )
        {

            $( '#' + archivo.previewElement.parentElement.id + ' .dz-default' ).show();

        }else{

            $( '#' + archivo.previewElement.parentElement.id + ' .dz-default' ).hide();

        }

    });

}

function LlenarDropzone( DivDropzone, datos )
{

    console.log( DivDropzone );

    id = DivDropzone.attr( 'id' );

		$.each( datos, function( indice, archivo )
		{

				if( archivo.url )
				{

						var mockFile =
						{

								name: archivo.nombre,

								size: 200

						};

						Dropzone.forElement( 'div#' + DivDropzone.attr( 'id' ) ).emit( 'addedfile', mockFile );

						Dropzone.forElement( 'div#' + DivDropzone.attr( 'id' ) ).emit( 'complete', mockFile );

						var contador = parseInt( $( '#contador' + id ).val() ) + 1;

						var ArchivoNuevoHTML = '<input type="hidden" id="idarchivo_' + contador + '" value="' + archivo.idarchivo + '" >';

						$( '#ContenedorArchivos' ).append( ArchivoNuevoHTML );

						$( '#contador' + id ).val( contador );

						var EliminarBotonHTML = $( '#ultimoboton' + id );

						EliminarBotonHTML.addClass( 'EliminarArchivoDeContenedor' + id );

						EliminarBotonHTML.attr( 'id', 'archivo_' + id + '_' + contador );

						EliminarBotonHTML.attr( 'idarchivo', archivo.idarchivo );

						EliminarBotonHTML.attr( 'nombrearchivo', archivo.nombre );

						EliminarBotonHTML.attr( 'urlarchivo', archivo.url );

						$( '#ultimolink' + id ).attr( 'href', archivo.url );

						$( '#ultimolink' + id ).attr( 'id', 'link_' + id + '_' + contador );

						var imagenurl = archivo.url;

						var thumbnail = $( '#' + id + ' .dz-preview.dz-file-preview .dz-image:last' ).children( 'img' );

						if( archivo.tipo != 'jpg' && archivo.tipo != 'png' && archivo.tipo != 'bmp' && archivo.tipo != 'jpeg' )
						{

								thumbnail.attr( 'src', GetFileIcon( archivo.tipo, 'big' ) );

						}else{

								thumbnail.attr('src',archivo.url);

						}

						thumbnail.attr( 'width', '100%' );

						thumbnail.attr( 'height', '100%' );

				}

		});

		$( '#' + id + ' .dz-default' ).hide();

}

function LlenarDropzones()
{

    $( ".dropzone" ).each( function()
    {

        var DivDropzone = $( this );

        if( DivDropzone.attr( 'llenar' ) )
        {

            var variables = DivDropzone.attr( 'variables' );

            var datos = {};

            if( variables )
            {

                variables = variables.split( '///' );

                for( $x=0; $x<variables.length; $x++ )
                {

                    var campo = variables[ $x ].split( ':=' );

                    if( campo[ 1 ] )
                    {

                        datos[ campo[ 0 ] ] = campo[ 1 ];

                    }else{

                        datos[ variables[ $x ] ] = $( '#' + variables[ $x ] ).val();

                    }

                }

            }

            $.ajax(
            {

                type: 'POST',

                url: DivDropzone.attr( 'llenar' ),

                data: datos,

                cache: false,

                success: function( respuesta )
                {

                    try
                    {
                        respuesta = JSON.parse( respuesta );
                    }

                    catch( e )
                    {

                        notifyError( 'Ha ocurrido un error al intentar subir el archivo seleccionado.' );

                        console.log( 'Error: ' + respuesta );

                        respuesta = false;

                    }

                    if( respuesta )
                    {

                        LlenarDropzone( DivDropzone, respuesta );

                    }

                }

            });



        }

    });

}

///////////////////////////////// Dropzone FilesFunctions /////////////////////////////////
function EliminarArchivoDeContenedor( boton )
{
    var contenedorarchivos = boton;

    var nombrearchvio = contenedorarchivos.attr( 'nombrearchivo' );

    alertify.confirm( '¿Desea eliminar el archivo <b>' + nombrearchvio + '</b>?', function( e )
		{

        if( e )
				{

            var eliminar      = contenedorarchivos.parent().parent().attr( 'eliminar' );

            if( !eliminar || eliminar == undefined ) var eliminar = '/archivos/eliminar_archivo/';

            var idcontenedor	= contenedorarchivos.attr( 'id' ).split( '_' );

            var idarchivo     = contenedorarchivos.attr( 'idarchivo' );

            var datos = {

                            idarchivo: idarchivo

                        }

            $.ajax(
						{

                type: 'POST',

                url: eliminar,

                data: datos,

                cache: false,

                success: function( respuesta )
                {



                    notifySuccess( 'El archivo <b>' + nombrearchvio + '</b> ha sido eliminado correctamente.' );

                    contenedorarchivos.parent().remove();

                    if( $( '.EliminarArchivoDeContenedor' + idcontenedor[ 1 ] ).length == 0 )
                    {

                        $( '.dz-default' ).show();

                    }



                },

                error: function( respuesta )
                {

                    notifyError( 'Ha ocurrido un error al intentar eliminar el archivo <b>' + nombrearchvio + '</b>' );

                    console.log( respuesta );

                }

            });

        }

    });

}

// EliminarArchivoDeContenedor( boton );

function ClickLinkArchivo( boton )
{

    console.log( boton );

    window.open( boton.attr( 'urlarchivo' ), '_blank' );

}


//////////////////////////////////////////////////// Logout ////////////////////////////////////////////////////
$(function(){
  $("#Logout").click(function(){
      alertify.labels.ok = "Si";
      alertify.labels.cancel = "No";
      alertify.confirm("¿Desea salir?", function(e){
          if(e){
            document.location = '/usuarios/logout/';
          }
      });
  });
});

//////////////////////////////////////////////////// Value In Array ////////////////////////////////////////////////////
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle || (Array.isArray(haystack[i]) && inArray(needle,haystack[i])))
            return true;
    }
    return false;
}


//////////////////////////////////////////////////// Element Visible ////////////////////////////////////////////////////////

function isVisible(object)
{
    return $(object).is (':visible') && $(object).parents (':hidden').length == 0;
}

//////////////////////////////////////////////////// Hide/Show Element by Class ////////////////////////////////////////////////////////

function showElement(element)
{
    $(element).removeClass('Hidden');
}

function hideElement(element)
{
    $(element).addClass('Hidden');
}

function toggleElement(element)
{
    if($(element).hasClass('Hidden'))
    {
        $(element).removeClass('Hidden');
    }else{
        $(element).addClass('Hidden');
    }
}


//////////////////////////////////////////////////// Get Vars From URL ////////////////////////////////////////////////////
function getVars(){
    var loc = document.location.href;
    var getString = loc.split('?');
    if(getString[1]){
        var GET = getString[1].split('&');
        var get = {};//This object will be filled with the key-value pairs and returned.

        for(var i = 0, l = GET.length; i < l; i++){
            var tmp = GET[i].split('=');
            get[tmp[0]] = unescape(decodeURI(tmp[1]));
        }
        return get;
    }else{
        return "";
    }
}
var get = getVars();


//////////////////////////////////////////////////// UTF8_ENCODE ////////////////////////////////////////////////////
function utf8_encode (argString) {

  if (argString === null || typeof argString === "undefined") {
    return "";
  }

  var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
         (c1 >> 6)        | 192,
        ( c1        & 63) | 128
      );
    } else if (c1 & 0xF800 != 0xD800) {
      enc = String.fromCharCode(
         (c1 >> 12)       | 224,
        ((c1 >> 6)  & 63) | 128,
        ( c1        & 63) | 128
      );
    } else { // surrogate pairs
      if (c1 & 0xFC00 != 0xD800) { throw new RangeError("Unmatched trail surrogate at " + n); }
      var c2 = string.charCodeAt(++n);
      if (c2 & 0xFC00 != 0xDC00) { throw new RangeError("Unmatched lead surrogate at " + (n-1)); }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
         (c1 >> 18)       | 240,
        ((c1 >> 12) & 63) | 128,
        ((c1 >> 6)  & 63) | 128,
        ( c1        & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}


//////////////////////////////////////////////////// UTF8_DECODE ////////////////////////////////////////////////////
function utf8_decode (str_data) {

  var tmp_arr = [],
    i = 0,
    ac = 0,
    c1 = 0,
    c2 = 0,
    c3 = 0,
    c4 = 0;

  str_data += '';

  while (i < str_data.length) {
    c1 = str_data.charCodeAt(i);
    if (c1 <= 191) {
      tmp_arr[ac++] = String.fromCharCode(c1);
      i++;
    } else if (c1 <= 223) {
      c2 = str_data.charCodeAt(i + 1);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
      i += 2;
    } else if (c1 <= 239) {
      // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    } else {
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      c4 = str_data.charCodeAt(i + 3);
      c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
      c1 -= 0x10000;
      tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1>>10) & 0x3FF));
      tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
      i += 4;
    }
  }

  return tmp_arr.join('');
}


///////////////////////////////////// COOKIES ////////////////////////////////////
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
//////////////////////////// COOKIE EXAMPLE //////////////////
// function checkCookie() {
//     var user = getCookie("username");
//     if (user != "") {
//         alert("Welcome again " + user);
//     } else {
//         user = prompt("Please enter your name:", "");
//         if (user != "" && user != null) {
//             setCookie("username", user, 365);
//         }
//     }
// }


/////////////////////////////////////////////// Local Storage ///////////////////////////////////////////

function storeLocal(name, val) {
  if (typeof (Storage) !== "undefined") {
    localStorage.setItem(name, val);
  } else {
    window.alert('Please use a modern browser to properly view this template!');
  }
}

function getLocal(name) {
  if (typeof (Storage) !== "undefined") {
    return localStorage.getItem(name);
  } else {
    window.alert('Please use a modern browser to properly view this template!');
  }
}

//////////////////////////////////////// LOADER ////////////////////////////////////////
$(document).ajaxStart(function(){
    $("#CloseAjaxLoader").addClass('Hidden');
    showLoader();
});

$( document ).ajaxComplete( function()
{

    validateDivChange();

    chosenSelect();

    inputMask();

    hideLoader();

});

function toggleLoader()
{
  if($(".loader").hasClass('Hidden'))
  {
    showLoader();
  }else{
    hideLoader();
  }
}

function showLoader()
{
  $('.loader').removeClass('Hidden');
  $("#CloseAjaxLoader").addClass('Hidden');
  setTimeout(function() {
    $("#CloseAjaxLoader").removeClass('Hidden');
  },10000);
  $('html').css({ 'overflow': 'hidden', 'height': '100%' });
}

function hideLoader()
{
  $('.loader').addClass('Hidden');
  $("#CloseAjaxLoader").addClass('Hidden');
  $('html').css({ 'overflow-Y': 'scroll', 'height': '100%' });
}


$(function(){
  $("#CloseAjaxLoader").click(function(){
    toggleLoader();
  })
})

//////////////////////////////// CANCEL BUTTON /////////////////////////////////
$(function(){
	$("#BtnCancel").click(function(){
		window.history.back();
	});
});

/////////////////////// MONEY FORMAT /////////////////
Number.prototype.formatMoney = function(c, d, t){
var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
 ///(123456789.12345).formatMoney(2);

 ////////////////////////////// ADD DAYS TO A DATE //////////////////////////////////////////////
function AddDaysToDate( days, adate )
{

    if( typeof( adate ) === "undefined" )
    {

      adate = new Date();

    }else{

      adate = new Date( adate );

    }

    var finaldate = adate.getTime() + parseInt( days ) * 24 * 60 * 60 * 1000;

    finaldate = new Date( finaldate );

    var day = finaldate.getUTCDate()

    if( day < 10 ) day = "0" + day;

    var month = finaldate.getUTCMonth() + 1;

    if( month < 10 ) month = "0" + month;

    return day + "/" + month + "/" + finaldate.getUTCFullYear();

}
/////////////////////////// WINDOWS /////////////////////////////
function closeWindow()
{
  $(".window .window-border .window-close").click(function(){
    $(this).parent().parent().parent().parent().addClass("Hidden");
  });
}

//////////////////////////////////////////////////// Customized File Field ////////////////////////////////////////////////////
function CustomizedFilefield()
{
	$("input:file").change(function(){
		$("#File"+$(this).attr("id")).focus();
		$("#File"+$(this).attr("id")).val($(this).val().replace("C:\\fakepath\\",""));
		$("#File"+$(this).attr("id")).blur();
	});
	$(".CustomizedFileField").click(function(){
		if($(this).attr("id").substring(0,4)=="File"){
			$(this).blur();
			$("#"+$(this).attr("id").substring(4)).click();
		}
	});
}

//////////////////////////////////////////////////// Get File Icon by file extension ////////////////////////////////////////////////////
function GetFileIcon(ext,size)
{
  if(typeof(size)==="undefined")
    size = "small";

  if(size=="big")
    var url = "../../../../skin/images/body/icons/big/";
  else
    var url = "../../../../skin/images/body/icons/";

  switch (ext) {
    case 'pdf':
      return url+"pdf.png";
    break;

    case 'avi':
    case 'mp4':
      return url+"avi.png";
    break;

    case 'wav':
    case 'mp3':
      return url+"mp3.png";
    break;

    case "doc":
		case "dot":
		case "docx":
		case "docm":
		case "dotx":
		case "dotm":
      return url+"doc.png";
    break;

    case "xls":
		case "xlsx":
		case "xlt":
		case "xltx":
		case "csv":
      return url+"xls.png";
    break;

    case 'rar':
    case 'zip':
      return url+"rar.png";
    break;

    case "ppt":
		case "pot":
		case "pps":
      return url+"ppt.png";
    break;

    case "eml":
      return url+"eml.png";
    break;

    case "bmp":
		case "jpeg":
		case "jpg":
		case "png":
		  return "self";
		break;

    default: return url+"txt.png";
  }
}
