<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Rassini</title>

  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/icheck-bootstrap/icheck-bootstrap.min.css') ?>">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_DIST . '/css/adminlte.min.css') ?>">

  <style>
.card-primary.card-outline {
    border-top: 10px solid #F28A00 !important;
}
</style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">

<!-- Imagen de rassini form     -->
<div class="text-center mb-2">
    <img src="<?= base_url(RECURSO_PANEL_DIST . '/img/Rassini.jpg') ?>" 
         alt="Rassini Logo"
         style="width:180px; max-width:80%; height:auto;">
</div>


    </div>
    <div class="card-body">
      <p class="login-box-msg">Inicia sesión para comenzar</p>



<form action="<?= site_url('login/auth') ?>" method="post">
  <?= csrf_field() ?>
  <div class="input-group mb-3">
    <input type="text" name="username" class="form-control"
       placeholder="Usuario o Correo"
       value="<?= esc($username ?? '') ?>"
       required>

    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user"></span>
        </div>
    </div>
  </div>

  <!-- seccion for icon candado -->

  
  <!-- <div class="input-group mb-3">
    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-lock"></span>
      </div>
    </div>
  </div> -->

  <div class="input-group mb-3">
  <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
  <div class="input-group-append">
    <div class="input-group-text" style="cursor: pointer;">
      <!-- Icono para ver/ocultar contraseña -->
      <span id="togglePassword" class="fas fa-eye"></span>
    </div>
  </div>
</div>


  <div class="row">
    <div class="col-8">
      <div class="icheck-primary">
        <input type="checkbox" id="remember" name="remember" value="1"
          <?= !empty($remember) ? 'checked' : '' ?>>
        <label for="remember">
          Recuérdame
        </label>

      </div>
    </div>
    <div class="col-4">
      <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </div>
  </div>
</form>

      <!-- /.social-auth-links -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(RECURSO_PANEL_DIST . '/js/adminlte.min.js') ?>"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Acceso restringido',
        text: '<?= esc(session()->getFlashdata('error')) ?>',
        confirmButtonText: 'Aceptar'
    });
</script>
<?php endif; ?>

<!-- scrip for view password of the users -->
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const passwordInput  = document.querySelector('#password');

  if (togglePassword && passwordInput) {
    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Cambiar icono (ojo / ojo tachado)
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  }
</script>

</body>
</html>
