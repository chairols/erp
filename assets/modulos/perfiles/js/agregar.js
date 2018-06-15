///////////////// TREECHECKBOXES ///////////////////
if ($('#treeview-checkbox').length)
{
    $('#treeview-checkbox').treeview();
    fillCheckboxTree();
}

$(function () {
    $(".tw-control").click(function () {
        var selected = [];
        $(".tw-control").each(function () {
            if ($(this).is(":checked"))
            {
                selected.push($(this).parent().attr("data-value"));
            }
        });
        $("#menues").val(selected.join());
    });
});
function fillCheckboxTree()
{
    var menues = $("#menues").val().split(',');
    $(".tw-control").each(function (menu) {
        if (inArray($(this).parent().attr("data-value"), menues))
        {
            //alert($(this).parent().attr("data-value"));
            $(this).click();
        }
    });
}
