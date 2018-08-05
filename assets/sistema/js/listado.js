///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////// LIST & GRID ////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function selectAllRows()
{
	$('#SelectAll').click(function(){
		$('.listRow').each(function(){
			if(!$(this).hasClass('SelectedRow'))
			{
				$(this).click();
			}
		});
	$('#SelectAll').addClass('Hidden');
    $('#UnselectAll').removeClass('Hidden');
	});
}
selectAllRows();

function unselectAllRows()
{
	$('#UnselectAll').click(function(){
		$('.listRow').each(function(){
			if($(this).hasClass('SelectedRow'))
			{
				$(this).click();
			}
		});
		$('#SelectAll').removeClass('Hidden');
	    $('#UnselectAll').addClass('Hidden');
	});
}
unselectAllRows();

// Row element selected
function rowElementSelected()
{
    $('.listRow').click(function(){
        toggleRow($(this));
    });
}
rowElementSelected();

function toggleRow(element)
{
	var id = element.attr("id").split("_");
	if(element.hasClass('SelectedRow'))
	{
		unselectRow(id[1]);
		element.removeClass('SelectedRow');
		element.removeClass('listRowSelected');
	}else{
		selectRow(id[1]);
		element.addClass('SelectedRow');
		element.addClass('listRowSelected');
	}

    var actions = element.children('.listActions');
    actions.toggleClass('Hidden');

		showActivateButton();
		showDeleteButton();
		showExpandButton();
		showContractButton();
		showSelectAllButton();
}

function toggleRowDetailedInformation()
{
	$('.ExpandButton,ContractButton').on('click',function(event){
		event.stopPropagation();
		toggleExpandRow($(this));
		showExpandButton();
		showContractButton();
	});
}
toggleRowDetailedInformation();

function toggleExpandRow(element)
{
	var ElementID = element.attr("id");
	var ID = ElementID.split('_');
	var RowID = ID[1];
	var InfoDetail = $("#row_"+RowID).children(".DetailedInformation");
	element.toggleClass('ContractButton');
	element.toggleClass('ExpandButton');
	element.children('i').toggleClass('fa-plus');
	element.children('i').toggleClass('fa-minus');
	InfoDetail.toggleClass('Hidden');
}

function showDeleteButton()
{
    if($('.SelectedRow').length>1 && checkDeleteRestrictions())
    {
        $('.DeleteSelectedElements').removeClass('Hidden');
    }else{
        $('.DeleteSelectedElements').addClass('Hidden');
    }
}

function showActivateButton()
{
    if($('.SelectedRow').length>1 && checkActiveRestrictions())
    {
        $('.ActivateSelectedElements').removeClass('Hidden');
    }else{
        $('.ActivateSelectedElements').addClass('Hidden');
    }
}

function showExpandButton()
{
    if($('.SelectedRow').length > 1 && $('.SelectedRow').children('.listActions').children('div').children('.roundItemActionsGroup').children('a').children('.ExpandButton').length > 0)
    {
        $('.ExpandSelectedElements').removeClass('Hidden');
    }else{
        $('.ExpandSelectedElements').addClass('Hidden');
    }
}

function showContractButton()
{
    if($('.SelectedRow').length > 1  && $('.SelectedRow').children('.listActions').children('div').children('.roundItemActionsGroup').children('a').children('.ContractButton').length > 0)
    {
        $('.ContractSelectedElements').removeClass('Hidden');
    }else{
        $('.ContractSelectedElements').addClass('Hidden');
    }
}

function checkDeleteRestrictions()
{
    var x=true;
    $('.SelectedRow').each(function(){
        var id = $(this).attr('id').split('_');
        if($("#delete_"+id[1]).length<1)
        {
        	x=false;
        }

    });
    return x;
}

function checkActiveRestrictions()
{
    var x=true;
    $('.SelectedRow').each(function(){
        var id = $(this).attr('id').split('_');
        if($("#activate_"+id[1]).length<1)
        {
        	x=false;
        }

    });
    return x;
}

function ShowList()
{
    $(".ShowList").click(function(){
         $(".ListElement").toggleClass("Hidden");
    });
}
ShowList();

function deleteElement(element)
{
	var elementID	= element.attr('id').split("_");
	var id			= elementID[1];
	var row			= $("#row_"+id);
	var url 		= element.attr('url');
	var campo 	= element.attr('campo');
	var datos   = element.attr('campo')+'='+id;
	// var datos   = {:id};
	var result;
	// console.log(datos);
    $.ajax({
        type: "POST",
        url: url,
        data: datos,
        cache: false,
        async: false,
        success: function(data){
	    		row.remove();
        	result = true;
      	},
				error: function(data){
					result = false;
					console.log(data);
				}
    });
    return result;
}

function activateElement(element)
{
	var elementID	= element.attr('id').split("_");
	var id				= elementID[1];
	var row				= $("#row_"+id);
	var url 			= element.attr('url');
	var campo 		= element.attr('campo');
	var datos   	= element.attr('campo')+'='+id;
	var result;

    $.ajax({
        type: "POST",
        url: url,
        data: datos,
        cache: false,
        async: false,
        success: function(data){
            row.remove();
	        	result = true;
        },
				error: function(data){
					result = false;
					console.log(data);
				}
    });
    //console.log(result);
    return result;
}


function deleteListElement()
{
	$(".deleteElement").click(function(){

		var element     = $(this);
		var elementID	= $(this).attr("id").split("_");
		var id			= elementID[1];
		var row			= $("#row_"+id);
		var question	= $(this).attr('msjpregunta');
		var text_ok		= $(this).attr('msjok');
		var text_error	= $(this).attr('msjerror');

		if($("#delete_question_"+id).length>0)
			question = $("#delete_question_"+id).val();
		else
			if(!question || question=="" || question=="undefined" )
				question = 'Está a punto de eliminar un registro ¿Desea continuar?';

		if($("#delete_text_ok_"+id).length>0)
			text_ok = $("#delete_text_ok_"+id).val();
		else
			if(!text_ok || text_ok=="" || text_ok=="undefined" )
				text_ok = "El registro ha sido eliminado.";

		if($("#delete_text_error_"+id).length>0)
			text_error = $("#delete_text_error_"+id).val();
		else
			if(!text_error || text_error=="" || text_error=="undefined" )
				text_error = "Hubo un problema. El registro no pudo ser eliminado.";

		alertify.confirm(question, function(e){
			if(e)
			{
				unselectRow(id);
				var result;
				result = deleteElement(element);

				if(result)
				{
					notifySuccess(text_ok);
					submitSearch();
				}else{
					notifyError(text_error);
				}
			}

		});
		return false;
	});
}
deleteListElement();

function activateListElement()
{
	$(".activateElement").click(function(){
		var element     = $(this);
		var elementID	= $(this).attr("id").split("_");
		var id			= elementID[1];
		var row			= $("#row_"+id);
		var question	= $(this).attr('msjpregunta');
		var text_ok		= $(this).attr('msjok');
		var text_error	= $(this).attr('msjerror');

		if($("#activate_question_"+id).length>0)
			question = $("#activate_question_"+id).val();
		else
			if(!question || question=="" || question=="undefined" )
				question = utf8_decode('Está a punto de activar un registro ¿Desea continuar?');

		if($("#activate_text_ok_"+id).length>0)
			text_ok = $("#activate_text_ok_"+id).val();
		else
			if(!text_ok || text_ok=="" || text_ok=="undefined" )
				text_ok = "El registro ha sido activado.";

		if($("#activate_text_error_"+id).length>0)
			text_error = $("#activate_text_error_"+id).val();
		else
			if(!text_error || text_error=="" || text_error=="undefined" )
			text_error = "Hubo un problema. El registro no pudo ser activado.";

		alertify.confirm(question, function(e){
			if(e)
			{
				unselectRow(id);
				var result;
				result = activateElement(element);

				if(result)
				{
					notifySuccess(text_ok);
					submitSearch();
				}else{
					notifyError(text_error);
				}
			}

		});
		return false;
	});
}
activateListElement();


function massiveRowExpand()
{
	$('.ExpandSelectedElements').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$(".SelectedRow").children('.listActions').children('div').children('.roundItemActionsGroup').children('a').children('.ExpandButton').each(function(){
			toggleExpandRow($(this));
		});
		$(this).addClass('Hidden');
		$('.ContractSelectedElements').removeClass('Hidden');
		unselectAll();
	})
}
massiveRowExpand();

function massiveRowContract()
{
	$('.ContractSelectedElements').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$(".SelectedRow").children('.listActions').children('div').children('.roundItemActionsGroup').children('a').children('.ContractButton').each(function(){
			toggleExpandRow($(this));
		});
		$(this).addClass('Hidden');
		$('.ExpandSelectedElements').removeClass('Hidden');
		unselectAll();
	})
}
massiveRowContract();

function massiveElementDelete()
{
	$(".DeleteSelectedElements").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var delBtn		= $(this);
		// var elements	= "";
		// var id;

		var msjok 			= $(this).attr('msjok');
		var msjerror 		= $(this).attr('msjerror');
		var msjpregunta = $(this).attr('msjpregunta');

		if(!msjok || msjok=="" || msjok=="undefined")
			msjok = 'Los registros seleccionados han sido eliminados.';

		if(!msjerror || msjerror=="" || msjerror=="undefined")
			msjerror = 'Hubo un problema al intentar eliminar los registros.';

		if(!msjpregunta || msjpregunta=="" || msjpregunta=="undefined")
			msjpregunta = '¿Desea eliminar los registros seleccionados?';

		alertify.confirm(msjpregunta, function(e){
      if(e)
			{

      	var result;
      	$(".SelectedRow").children('.listActions').children('div').children('.roundItemActionsGroup').children('.deleteElement').each(function(){
      		result	= deleteElement($(this));
      		// id		= $(this).attr("id").split("_")
      		// if(elements!="")
      		// {
      		// 	elements = elements + "," + id[1];
      		// }else{
      		// 	elements = id[1];
      		// }
      	});
				unselectAll();
      	if(result)
      	{
      		delBtn.addClass('Hidden');
      		notifySuccess(msjok);
      		submitSearch();
      		var selectedIDS = $("#selected_ids").val().split(",");
      	}else{
      		notifyError(msjerror);
      	}
      }
    });
	  return false;
	});
}
massiveElementDelete();

function massiveElementActivate()
{
	$(".ActivateSelectedElements").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var msjok 			= $(this).attr('msjok');
		var msjerror 		= $(this).attr('msjerror');
		var msjpregunta = $(this).attr('msjpregunta');

		if(!msjok || msjok=="" || msjok=="undefined")
			msjok = 'Los registros seleccionados han sido activados.';

		if(!msjerror || msjerror=="" || msjerror=="undefined")
			msjerror = 'Hubo un problema al intentar activar los registros.';

		if(!msjpregunta || msjpregunta=="" || msjpregunta=="undefined")
			msjpregunta = '¿Desea activar los registros seleccionados?';

		var delBtn = $(this)
		alertify.confirm(msjpregunta, function(e){
      if(e)
			{
      	var result;
      	$(".SelectedRow").children('.listActions').children('div').children('.roundItemActionsGroup').children('.activateElement').each(function(){
      		result = activateElement($(this));
      	});
				unselectAll();
      	if(result)
      	{
      		delBtn.addClass('Hidden');
      		notifySuccess(msjok);
      		submitSearch();
      	}else{
      		notifyError(msjerror);
      	}
      }
    });
	  return false;
	});
}
massiveElementActivate();

function unselectRow(id)
{
	var selected	= $("#selected_ids").val();
	selected		= selected.replace(id+",","");
	$("#selected_ids").val(selected);
	$("#selected_ids").change();
}

function selectRow(id)
{
	var selected = $("#selected_ids").val();
	if(selected.indexOf(id)==-1){

		if(selected)
			$("#selected_ids").val(selected+id+",");
		else
			$("#selected_ids").val(id+",");
	}
	$("#selected_ids").change();
}

function unselectAll()
{
	$("#selected_ids").val("");
	$("#selected_ids").change();
}

function toggleSelectedRows()
{
	var ids = $("#selected_ids").val();
	if(ids)
	{
		ids = ids.split(",");
		//console.log(ids);
		for (var i = 0; i < ids.length-1; i++) {
			if($("#row_"+ids[i]).length>0)
				toggleRow($("#row_"+ids[i]));
	}
	}
}

function showSelectAllButton()
{
	if($(".SelectedRow").length==$(".listRow").length)
	{
		$('#SelectAll').addClass('Hidden');
    	$('#UnselectAll').removeClass('Hidden');
	}else{
		$('#UnselectAll').addClass('Hidden');
    	$('#SelectAll').removeClass('Hidden');
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////// SEARCHER ///////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function(){
	$('.ShowFilters').click(function(){
		$('.SearchFilters').toggleClass('Hidden');
	});

	$(".searchButton").click(function(){
		multipleInputTransform();
		submitSearch();
		// unselectAll();
	});

	$("#regsperview").change(function(){
		$.ajax({
        type: "POST",
        url: '/parametros/usuario/',
        data: "id-1="+$("#regsperview").val(),
        async: false,
        success: function()
				{
	    		submitSearch();
      	},
				error: function(data){
					result = false;
					console.log(data);
				}
    });
	});

	$("#CoreSearcherForm input").keypress(function(e){
		if(e.which==13){
			$(".searchButton").click();
		}
	});

	$("#ClearSearchFields").click(function(){
		$("#SearchFieldsForm").children('.row').children('#CoreSearcherForm').children('.input-group').children('input,select,textarea').val('');
		$("#SearchFieldsForm").children('.row').children('#CoreSearcherForm').children('.input-group').children('.chosenSelect').chosen();
		// $("#SearchFieldsForm").children('.row').children('#CoreSearcherForm').children('.input-group').children('select').chosen();
	});
});

function multipleInputTransform()
{
	$(".chosenSelect[multiple='multiple']").each(function(){
		if(String($(this).val()).substr(0,1)==",")
			$(this).val(String($(this).val()).substr(1));
	});
}

function submitSearch()
{

	if(validador.validateFields('CoreSearcherForm'))
	{

		var loc = document.location.href;
  	var getString = loc.split('?');
		var target = getString[0];
		var data = GetDataFromForm('CoreSearcherForm');
		if(data)
			window.location = target + '?' + data;
		else
			window.location = target;

  	// var getVars = '';
  	// if(getString[1])
  	// 	getVars = '&'+getString[1];
		// var object		= $("#SearchResult").attr("object");
		// var process		= process_url+'?action=search&object='+object+getVars;
		// var haveData	= function(returningData)
		// {
		// 	$("input,select").blur();
		// 	$("#SearchResult").remove();
		// 	$("#CoreSearcherResults").append(returningData);
		// 	rowElementSelected();
		// 	showDeleteButton();
		// 	showExpandButton();
		// 	deleteListElement();
		// 	// massiveElementDelete();
		// 	activateListElement();
		// 	toggleRowDetailedInformation();
		// 	toggleSelectedRows();
		// 	selectAllRows();
		// 	unselectAllRows();
		// 	showSelectAllButton();
		// 	chosenSelect();
		// 	SetAutoComplete();
		// 	validateDivChange();
		// 	if (typeof AdditionalSearchFunctions == 'function') {
		// 	    AdditionalSearchFunctions();
		// 	}
		// 	$("#TotalRegs").html($("#totalregs").val());
		// 	var page = $("#view_page").val();
		// 	appendPager();
		// }
		// var noData		= function()
		// {
		// 	//Empty action
		// }
		// sumbitFields(process,haveData,noData);
		// return false;
	}
}

$(document).ready(function(){
	if (typeof AdditionalSearchFunctions == 'function') {
	    AdditionalSearchFunctions();
	}
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////// ORDERER ///////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function(){
	$(".order-arrows").click(function(){
		$(".sort-activated").removeClass("sort-activated");
		var mode = $(this).attr("mode");
		$(this).children("i").removeClass("fa-sort-alpha-"+mode);
		if(mode=="desc") mode = "asc";
		else mode = "desc";
		$("#view_order_field").val($(this).attr("order"));
		$("#view_order_mode").val(mode);
		$(this).attr("mode",mode);
		$(this).children("i").addClass("fa-sort-alpha-"+mode);
		$(this).addClass("sort-activated");
		$("#view_page").val("1");
		submitSearch();
	});
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////// PAGER //////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
	IrAPagina();
	IrAPaginaApretarEnter();
});

function IrAPagina()
{
		$("#ir_a_pagina_button").on("click",function(){
			var pagina = $("#ir_a_pagina_input").val();
			var url = $(this).attr("url");
			if(!isNaN(pagina) && pagina>0)
			{
				// var url = $('a[data-ci-pagination-page="'+pagina+'"]').first().attr("href");
				window.location = url + ((pagina-1)*10);
				// window.location = url;
				// console.log($('a[data-ci-pagination-page="'+pagina+'"]'));
			}else{
				if(pagina && pagina!=undefined)
					notifyError('Ingrese un número de página.');
			}
		});
}

function IrAPaginaApretarEnter()
{
	$("#ir_a_pagina_input").keypress(function(evento)
	{
	  if (evento.which == 13)
		{
	     $("#ir_a_pagina_button").click();
  	}
	});
}

// function appendPager()
// {
// 	var page = parseInt($("#view_page").val());
// 	var totalpages = calculateTotalPages();
// 	if(totalpages>1)
// 	{
// 		if (totalpages < 7) {
// 		   $(".pagination").html(appendPagerUnder7(page));
// 		} else if (totalpages < 31) {
// 		    $(".pagination").html(appendPagerUnder30(page));
// 		} else{
// 		    $(".pagination").html(appendPagerUnlimited(page));
// 		}
// 	}else{
// 		$(".pagination").html('');
// 	}
// 	switchPage();
// }

// function appendPagerUnder7(page)
// {
// 	var html = '<li class="PrevPage"><a><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';
// 	var totalpages = calculateTotalPages();
// 	for (var i = 1; i <= totalpages; i++)
// 	{
// 		if(i==page)
// 			var pageClass = 'active';
// 		else
// 			var pageClass = '';
// 		html = html + '<li class="'+pageClass+' pageElement" page="'+i+'"><a class="">'+i+'</a></li>';
// 	}
// 	return html + '<li class="NextPage"><a><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
// }
//
// function appendPagerUnder30(page)
// {
// 	var html = '<li class="PrevPage"><a><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';
// 	var totalpages = calculateTotalPages();
// 	var separatorA = '';
// 	var separatorB = '';
//
// 	if((page-2)>2)
// 		separatorA = '...';
// 	if((page+3)<totalpages)
// 		separatorB = '...';
//
//
// 	if((page-2)>1)
// 		html = html + '<li class="pageElement" page="1"><a>1'+separatorA+'</a></li>';
// 	if(((page-2)>=1))
// 		html = html + '<li class="pageElement" page="'+(page-2)+'"><a>'+(page-2)+'</a></li>';
// 	if(((page-1)>=1))
// 		html = html + '<li class="pageElement" page="'+(page-1)+'"><a>'+(page-1)+'</a></li>';
// 	html = html + '<li class="active pageElement" page="'+page+'"><a>'+page+'</a></li>';
// 	if(((page+1)<=totalpages))
// 		html = html + '<li class="pageElement" page="'+(page+1)+'"><a>'+(page+1)+'</a></li>';
// 	if(((page+2)<=totalpages))
// 		html = html + '<li class="pageElement" page="'+(page+2)+'"><a>'+(page+2)+'</a></li>';
// 	if((page+2)<totalpages)
// 		html = html + '<li class="pageElement" page="'+totalpages+'"><a>'+separatorB+totalpages+'</a></li>';
//
// 	return html + '<li class="NextPage"><a><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
// }
//
// function appendPagerUnlimited(page)
// {
//
// 	var totalpages = calculateTotalPages();
// 	var separatorA = '';
// 	var separatorB = '';
// 	var html = '<li class="Prev10Page"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li><li class="PrevPage"><a><i class="fa fa-angle-left" aria-hidden="true"></i></i></a></li>';
//
// 	if((page-2)>2)
// 		separatorA = '...';
// 	if((page+3)<totalpages)
// 		separatorB = '...';
//
//
// 	if((page-2)>1)
// 		html = html + '<li class="pageElement" page="1"><a>1'+separatorA+'</a></li>';
//
// 	if((page-2)>3)
// 	{
// 		var interPageA = Math.ceil((page-3)/2);
// 		html = html + '<li class="pageElement" page="'+interPageA+'"><a>'+separatorA+interPageA+separatorA+'</a></li>';
// 	}
//
// 	if(((page-2)>=1))
// 		html = html + '<li class="pageElement" page="'+(page-2)+'"><a>'+(page-2)+'</a></li>';
// 	if(((page-1)>=1))
// 		html = html + '<li class="pageElement" page="'+(page-1)+'"><a>'+(page-1)+'</a></li>';
//
// 	html = html + '<li class="active pageElement" page="'+page+'"><a>'+page+'</a></li>';
//
// 	if(((page+1)<=totalpages))
// 		html = html + '<li class="pageElement" page="'+(page+1)+'"><a>'+(page+1)+'</a></li>';
// 	if(((page+2)<=totalpages))
// 		html = html + '<li class="pageElement" page="'+(page+2)+'"><a>'+(page+2)+'</a></li>';
//
// 	if(totalpages-(page+2)>3)
// 	{
// 		//var interPageB = Math.ceil(totalpages-(page+2)/2);
// 		var interPageB = Math.ceil( (totalpages/2) + (page/2));
// 		html = html + '<li class="pageElement" page="'+interPageB+'"><a>'+separatorB+interPageB+separatorB+'</a></li>';
// 	}
//
// 	if((page+2)<totalpages)
// 		html = html + '<li class="pageElement" page="'+totalpages+'"><a>'+separatorB+totalpages+'</a></li>';
//
// 	return html + '<li class="NextPage"><a><i class="fa fa-angle-right" aria-hidden="true"></i></a></li><li class="Next10Page"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
// }
//
// function switchPage()
// {
// 	$('.pageElement').click(function(event){
// 		event.stopPropagation();
// 		if(!$(this).hasClass('active'))
// 		{
// 			var page = $(this).attr('page');
// 			$("#view_page").val(page);
// 			submitSearch();
// 		}
// 		return false;
// 	});
//
// 	switchPrevNextPage();
// }
// switchPage();

// function switchPrevNextPage()
// {
// 	$('.NextPage').click(function(){
// 		var page = parseInt($("#view_page").val())+1;
// 		if(page<=calculateTotalPages())
// 			$(".pageElement[page='"+page+"']").click();
// 	});
//
// 	$('.PrevPage').click(function(){
// 		var page = parseInt($("#view_page").val())-1;
// 		if(page>0)
// 			$(".pageElement[page='"+page+"']").click();
// 	});
//
// 	$('.Next10Page').click(function(e){
// 		e.stopPropagation();
// 		var page = parseInt($("#view_page").val())+10;
// 		if(page<calculateTotalPages())
// 		{
// 			if($(".pageElement[page='"+page+"']").length>0)
// 			{
// 				$(".pageElement[page='"+page+"']").click();
// 			}else{
// 				$("#view_page").val(page);
// 				submitSearch();
// 			}
// 		}else{
// 			$(".pageElement[page='"+calculateTotalPages()+"']").click();
// 		}
// 	});
//
// 	$('.Prev10Page').click(function(e){
// 		e.stopPropagation();
// 		var page = parseInt($("#view_page").val())-10;
// 		console.log(page);
// 		if(page>0)
// 		{
// 			if($(".pageElement[page='"+page+"']").length>0)
// 			{
// 				$(".pageElement[page='"+page+"']").click();
// 			}else{
// 				$("#view_page").val(page);
// 				submitSearch();
// 			}
// 		}else{
// 			$(".pageElement[page='1']").click();
// 		}
// 	});
// }

// function calculateTotalPages()
// {
// 	var totalregs	= $("#totalregs").val();
// 	var regsperview = $("#regsperview").val();
// 	return Math.ceil(totalregs/regsperview);
// }
