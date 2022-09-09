<?php
// Control de sesión en distintas cuentas. Se incluye únicamente en el login_validation.
    session_start();
    if (isset($_SESSION['id'])) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Ya hay una sesión iniciada!',
                text: 'Asegúrate de haber cerrado correctamente las sesiones anteriores',
            }).then(function() {
                history.back();
            });
            </script>
        <?php
        exit;
    }
?>