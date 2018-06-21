<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    <?php $this->view('layout/body/header'); ?>
    <?php $this->view('layout/body/menu'); ?>
    <section class="content-wrapper">
      <?php $this->view('layout/body/breadcrumbs'); ?>
      <?php $this->view($view); ?>
    </section>
    <?php $this->view('layout/body/footer'); ?>
    <?php $this->view('layout/body/sidebar'); ?>
  </div>
  <?php $this->view('layout/body/scripts'); ?>
</body>
