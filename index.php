<?php
session_start();
if(isset($_SESSION["profesor"])){
    header('Location: home.php');
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

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <img class="mb-4" src="assets/img/uv_logo.png" width="100%">
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">¡Iniciar sesion!</h1>
                                    </div>
                                    <form class="user" id="frmDataInfo">
                                        <div class="form-group">
                                            <input type="number" class="form-control form-control-user"
                                                id="idProfesor"  name="idProfesor" aria-describedby="emailHelp"
                                                placeholder="ID Profesor">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Contraseña">
                                        </div>
                                        <a href=#" class="btn btn-primary btn-user btn-block" onclick="doLogin()">
                                            iniciar sesion
                                        </a>
                                    </form>
<!--
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.min.js"></script>


    <script src="js/objectProfecional.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        function doLogin(){
            $.ajax({
                method: "POST",
                url: "controller/login/iniciaSesion.php",
                data: $("#frmDataInfo").serialize()
            })
            .done(function( result ) {
                if(result.status == "success"){
                    if (result.data['estatus']==1) {
                        window.location.href = "admin.php";
                    } else {
                        window.location.href = "home.php";
                    }
                    
                }else{ // si el No de trabajador ya se encuentra registrado
                    alert(result.msj)
                    console.log(result);
                }
            })
            .fail(function(jqXHR, textStatus){
                alert( "Peticion fallida failed: " + textStatus );
            });

            return false;
        }

    </script>

</body>

</html>