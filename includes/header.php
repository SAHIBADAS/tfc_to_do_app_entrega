<header>
    <nav>
        <a href="index.php" class="logo">TaskHive</a>
        <?php
            if(!isset($_SESSION["idUsuario"])){
                echo "
                    <a href='registro.php'>Registro</a>
                    <a href='login.php'>Login</a>
                ";
            }        
        ?>
        <a href="index.php#contact">Contacto</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <div class="success" id="successDiv"></div>
    <section>
        <?php
            if(isset($_SESSION["idUsuario"])){
                echo "<div class='nomuser'><strong>". $_SESSION["nombreUsuario"]. "</strong></div><button id='closeSession'>Cerrar sesión</button>";
            }        
        ?>
    </section>
</header>