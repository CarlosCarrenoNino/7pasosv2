<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>LOGIN | BOT 7 PASOS</title>
        <link rel="icon" href="icono_vtr.ico" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark" background="vtr.png" class="sb-nav-fixed">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container" >
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5" style="right: -400px">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login | BOT 7 PASOS</h3></div>
                                    <div class="card-body" >
                                        <form class="form-auth-small" action="ValidaUsuarioCredencial.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input required class="form-control"  id="Usuario1" name="Usuario" type="text" placeholder="Ingrese Usuario" />
                                                <label for="inputText">Ingresar Usuario</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required class="form-control" id="Password1" name="Password" type="password" placeholder="Ingrese Contraseña" />
                                                <label for="inputPassword">Ingresar Contraseña</label>
                                            </div>
                                            <!-- <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Recordar Contraseña</label>
                                            </div> -->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-danger btn-lg btn-block">Iniciar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Necesita una Cuenta, Regitrese!</a></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <!-- <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4"> -->
                       <!--  <div class="d-flex align-items-center justify-content-between small">
                             <div class="text-muted">Copyright &copy; Carlos Niño DESARROLLADOR RPA 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div> -->
                    <!-- </div>
                </footer> -->
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
