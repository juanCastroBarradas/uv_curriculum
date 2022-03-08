<?php
session_start();
if(!isset($_SESSION["profesor"])){
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Curriculum uv</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Curriculum uv </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" id="informacion_personal">
                <a class="nav-link" href="#" onclick="setHtmlContent('informacion_personal')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Datos personales</span></a>
            </li>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="formacion_academica">
                <a class="nav-link" href="#" onclick="setHtmlContent('formacion_academica')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Formación academica</span></a>
            </li>
            

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('actualizacion_docente')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Actualización docente</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('gestion_academica')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Gestión académica</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('productos_academicos')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Prodcuto académico</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('experiencia_profesional')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Experiencia profesional</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('experiencia_diseno_ingenieril')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Experiencia en diseño</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('logos_profesionales')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Logros profesionales</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('participaciones')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Participaciones</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setHtmlContent('reconocimientos')">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Reconocimientos</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600"><strong><?php echo $_SESSION["profesor"]["nombre"] ?></strong></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesion
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" id="nav-home">
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Deseas cerrar tu sesion?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Todos los cambios que no guardaste se perderan, revisa que hallas guardado toda tu información antes de salir.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="#" onclick="cerrarSesion()">Cerrar Sesion</a>
                </div>
            </div>
        </div>
    </div>


    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.min.js"></script>

    <script type="text/javascript">
        $(function(){
            $("#nav-home").load("informacion_personal.html");                
        });

        function setHtmlContent(page){
            $('li').removeClass('active');
            $('li#'+page).addClass('active');
            var htmlPage = page+".html";
            $("#nav-home").load(htmlPage);
        }

        function cerrarSesion(){
            $.ajax({
                method: "GET",
                url: "controller/login/cerrarSesion.php"
            })
            .done(function( result ) {
                window.location.href = 'index.php';
            })
            .fail(function(jqXHR, textStatus){
                alert( "Peticion fallida failed: " + textStatus );
            });
        }

    </script>


    <script src="js/objectProfecional.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>

</html>