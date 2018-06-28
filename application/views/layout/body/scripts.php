<!-- jQuery 2.2.3 -->
<script src="/assets/vendors/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->
<script src="/assets/vendors/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="/assets/template/js/bootstrap.min.js"></script>
<!-- datepicker -->
<script src="/assets/vendors/datepicker/bootstrap-datepicker.js"></script>
<!-- Slimscroll -->
<script src="/assets/vendors/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/vendors/fastclick/fastclick.js"></script>
<!-- Alertify -->
<script src="/assets/vendors/alertify/alertify.js"></script>
<!-- Notify -->
<script src="/assets/vendors/bootstrap-notify/notify.js"></script>
<!-- Chosen JS -->
<script src="/assets/vendors/chosen-js/chosen.jquery.js"></script>
<!-- Autocomplete -->
<script src="/assets/vendors/autocomplete/jquery.auto-complete.min.js"></script>
<!-- Input Mask -->
<script src="/assets/vendors/jquery-mask/src/jquery.mask.js"></script>
<script src="/assets/vendors/inputmask3/jquery.inputmask.bundle.min.js"></script>
<!-- Dropzone -->
<script src="/assets/vendors/dropzone/dropzone.min.js"></script>

<!-- Treemultiselect -->
<script src="/assets/vendors/treemultiselect/logger.min.js"></script>
<script src="/assets/vendors/treemultiselect/treeview.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/template/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/template/js/demo.js"></script>
<!-- Scripts del sistema -->
<script src="/assets/sistema/js/validador.js"></script>
<script src="/assets/sistema/js/sistema.js"></script>
<?php
if (isset($javascript) && count($javascript) > 0) { ?>
<!-- Carga de Scripts de la vista -->
<?php    foreach ($javascript as $j) { ?>
<script type="text/javascript" src="<?=$j?>"></script>
<?php
    }
}
?>
