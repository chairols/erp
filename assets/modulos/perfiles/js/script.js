///////////////// TREECHECKBOXES ///////////////////
if ($('#treeview-checkbox').length)
{
    $('#treeview-checkbox').treeview();
    fillCheckboxTree();

    $(".tw-control").click(function() {
        modificarInputMenues();
    });
}

function fillCheckboxTree()
{
    var menues = $("#menues").val().split(',');
    $(".tw-control").each(function (menu) {
        if (inArray($(this).parent().attr("data-value"), menues))
        {
            $(this).click();
        }
    });
}
function modificarInputMenues()
{
  var selected = '';
  $("#treeview-checkbox").children('ul').each(function () {
    $(this).children('li').each(function(){
      var valores = evaluarLista($(this));
      if(valores && valores!=',')
      {
        if(selected!='')
          valores = ',' + valores
        selected = selected + valores;
      }
    })
  });
  $("#menues").val(selected);
}

function evaluarLista(li)
{
  var selected = '';
  input = li.children('.tw-control');
  if (input.is(":checked"))
  {
    selected = li.attr("data-value");
    li.children('ul').each(function(){
      $(this).children('li').each(function(){
        var valores = evaluarLista($(this));
        if(valores && valores!=',')
        {
          if(selected!='')
            valores = ',' + valores
          selected = selected + valores;
        }
      })
    })
  }
  return selected;
}
