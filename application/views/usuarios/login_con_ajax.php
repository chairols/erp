<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="/assets/template/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/template/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/assets/vendors/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>ROLLER SERVICE S.A.</b>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">

                <div>
                    <div class="form-group has-feedback">
                        <input type="text" id="usuario" name="usuario" class="form-control" value="<?= (isset($_COOKIE['login_usuario'])) ? $_COOKIE['login_usuario'] : "" ?>" placeholder="Usuario" autofocus required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="password" name="password" class="form-control" value="<?= (isset($_COOKIE['login_password'])) ? $_COOKIE['login_password'] : "" ?>" placeholder="Contraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember" id="remember"<?= (isset($_COOKIE['login_usuario']) && isset($_COOKIE['login_password'])) ? " checked" : "" ?>> Recordarme
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="button" id="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
                            <button type="button" id="login_loading" class="btn btn-primary btn-block btn-flat" style="display: none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>


            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <pre>
            <?php print_r($_COOKIE); ?>
        </pre>
        <!-- jQuery 2.2.3 -->
        <script src="/assets/vendors/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="/assets/template/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="/assets/vendors/iCheck/icheck.min.js"></script>
        <!-- Notify -->
        <script src="/assets/vendors/bootstrap-notify/notify.js"></script>
        <!-- Script -->
        <script src="/assets/modulos/usuarios/js/login.js"></script>

        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
