<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>">
  <title>Usuarios</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_PLUGINS . '/fontawesome-free/css/all.min.css') ?>">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(RECURSO_PANEL_DIST . '/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Inicio</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-flex align-items-center">
        <span class="nav-link">Hola, <?= session()->get('nombreCompleto') ?></span>
    </li>  
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('logout') ?>">Salir</a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?= base_url(RECURSO_PANEL_DIST . '/img/RassiniLogo.png') ?>" alt="Rassini Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Rassini Frenos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a><?= session()->get('nombreCompleto') ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="Search" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url('Panel/index') ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('empleado') ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>     
          <li class="nav-item">
            <a href="<?= base_url('equipos') ?>" class="nav-link">
              <i class="nav-icon fas fa-desktop  "></i>
              <p>
                Equipos de computo
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?= base_url('') ?>" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Usuarios y equipos
              </p>
            </a>
          </li>
                      <li class="nav-item">
            <a href="<?= base_url('') ?>" class="nav-link">
              <i class="nav-icon fas fa-ring"></i>
              <p>
                Mantenimientos
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Empleados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('Panel/index') ?>">Inicio</a></li>
              <li class="breadcrumb-item active">CRUD Empleados</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Alertas -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <?php if (isset($errors) && is_array($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $e): ?>
                <li><?= esc($e) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="row">
          <!-- Formulario -->
          <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <?= isset($empleadoEdit) && $empleadoEdit ? 'Editar empleado' : 'Nuevo empleado' ?>
                </h3>
              </div>
              <form 
                action="<?= isset($empleadoEdit) && $empleadoEdit ? site_url('empleado/update/'.$empleadoEdit['Id_Empleado']) : site_url('empleado/store') ?>" 
                method="post">
                <?= csrf_field() ?>
                <div class="card-body">                               
                  <div class="form-group">
                    <label for="Nombres">Nombres</label>
                    <input type="text" name="Nombres" id="Nombres" class="form-control"
                           value="<?= set_value('Nombres', $empleadoEdit['Nombres'] ?? '') ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="ApellidoP">Apellido paterno</label>
                    <input type="text" name="ApellidoP" id="ApellidoP" class="form-control"
                           value="<?= set_value('ApellidoP', $empleadoEdit['ApellidoP'] ?? '') ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="ApellidoM">Apellido materno</label>
                    <input type="text" name="ApellidoM" id="ApellidoM" class="form-control"
                           value="<?= set_value('ApellidoM', $empleadoEdit['ApellidoM'] ?? '') ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="UserName">Usuario</label>
                    <input type="text" name="UserName" id="UserName" class="form-control"
                           value="<?= set_value('UserName', $empleadoEdit['UserName'] ?? '') ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="Correo">Correo</label>
                    <input type="email" name="Correo" id="Correo" class="form-control"
                           value="<?= set_value('Correo', $empleadoEdit['Correo'] ?? '') ?>">
                  </div>

                  <div class="form-group">
                    <label for="Password">
                      <?= isset($empleadoEdit) && $empleadoEdit ? 'Nueva contraseña (opcional)' : 'Contraseña' ?>
                    </label>
                    <input type="password" name="Password" id="Password" class="form-control"
                           <?= isset($empleadoEdit) && $empleadoEdit ? '' : 'required' ?>>
                  </div>
                  <div class="form-group">
                    <label for="Password2">Confirmar contraseña</label>
                    <input type="password" name="Password2" id="Password2" class="form-control"
                           <?= isset($empleadoEdit) && $empleadoEdit ? '' : 'required' ?>>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                    <?= isset($empleadoEdit) && $empleadoEdit ? 'Actualizar' : 'Guardar' ?>
                  </button>
                  <?php if (isset($empleadoEdit) && $empleadoEdit): ?>
                    <a href="<?= site_url('empleado') ?>" class="btn btn-secondary">Cancelar</a>
                  <?php endif; ?>
                </div>
              </form>
            </div>
          </div>

          <!-- Tabla -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de empleados</h3>
              </div>
              <div class="card-body table-responsive p-0" style="max-height: 500px;">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre completo</th>
                      <th>UserName</th>
                      <th>Correo</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($empleados)): ?>
                      <?php foreach ($empleados as $emp): ?>
                        <tr>
                          <td><?= esc($emp['Id_Empleado']) ?></td>
                          <td><?= esc($emp['Nombres'].' '.$emp['ApellidoP'].' '.$emp['ApellidoM']) ?></td>
                          <td><?= esc($emp['UserName']) ?></td>
                          <td><?= esc($emp['Correo']) ?></td>
                          <td>
                            <a href="<?= site_url('empleado/edit/'.$emp['Id_Empleado']) ?>" class="btn btn-sm btn-warning">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= site_url('empleado/delete/'.$emp['Id_Empleado']) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Seguro que deseas eliminar este empleado?');">
                              <i class="fas fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5">No hay empleados registrados.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.1
    </div>
    <strong>Copyright &copy; 2025 <a href="https://www.rassini.com/frenos/">Rassini Frenos</a>.</strong> Todos los derechos reservados.
  </footer>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(RECURSO_PANEL_PLUGINS . '/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(RECURSO_PANEL_DIST . '/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(RECURSO_PANEL_DIST . '/js/demo.js') ?>"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Bienvenido!',
        text: '<?= esc(session()->getFlashdata('success')) ?>',
        confirmButtonText: 'Continuar'
    });
</script>
<?php endif; ?>

</body>
</html>
