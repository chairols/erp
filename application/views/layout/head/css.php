<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="/assets/template/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/assets/template/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="/assets/template/css/skin-blue.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="/assets/vendors/iCheck/all.css">
<!-- Date Picker -->
<link rel="stylesheet" href="/assets/vendors/datepicker/datepicker3.css">
<!-- Alertify -->
<!-- <link rel="stylesheet" href="/assets/vendors/alertifyjs/css/alertify.min.css"> -->
<!-- <link rel="stylesheet" href="/assets/vendors/alertifyjs/css/themes/bootstrap.min.css"> -->
<!-- jsTree -->
<link rel="stylesheet" href="/assets/vendors/jstree-3.3.5/dist/themes/default/style.min.css">
<!-- Chosen Js -->
<link rel="stylesheet" href="/assets/vendors/chosen-js/bootstrap-chosen.css">
<!-- Autocomplete -->
<link rel="stylesheet" href="/assets/vendors/autocomplete/jquery.auto-complete.css">
<!-- DatePicker -->
<link rel="stylesheet" href="/assets/vendors/datepicker/datepicker3.css">
<!-- Dropzone -->
<link rel="stylesheet" href="/assets/vendors/dropzone/dropzone.min.css">
<!-- Sistema -->
<link rel="stylesheet" href="/assets/sistema/css/sistema.css">
<?php
if (isset($css) && count($css) > 0) { ?>
<!-- Carga de Css de la vista -->
<?php    foreach ($css as $css) { ?>
  <link rel="stylesheet" href="<?=$css?>"></link>
<?php
    }
}
?>
