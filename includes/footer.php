<footer>
    <div class="logo-2">TaskHive</div>
    <hr class="line4">
    <nav class="footer-links">
        <?php
        if (!isset($_SESSION["idUsuario"])) {
            echo "
                    <a href='registro.php'>Registro</a>
                    <a href='login.php'>Login</a>
                ";
        }
        ?>
        <a href="index.php#contact">Contacto</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <div class="rrss-title">Encuéntranos en</div>
    <nav class="rrss-links">
        <a href="https://www.instagram.com/" target="_blank"><img src="../assets/svg/instagram.svg" alt="Icono de Instagram"></a>
        <a href="https://www.youtube.com/" target="_blank"><img src="../assets/svg/youtube.svg" alt="Icono de Youtube"></a>
        <a href="https://www.linkedin.com/login/es?fromSignIn=true&trk=guest_homepage-basic_nav-header-signin" target="_blank"><img src="../assets/svg/linkedin.svg" alt="Icono de Linkedin"></a>
    </nav>
    <hr class="line5">
    <div class="footer-foot">© TaskHive Todos los derechos reservados</div>
</footer>