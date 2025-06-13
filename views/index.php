<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bienvenido a nuestro sitio. Explora nuestros servicios, conoce nuestras novedades y accede fácilmente a tu cuenta.">
    <title>TaskHive Home</title>
    <link rel="stylesheet" href="../assets/css/style-copy.css">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <script type="module" src="../js/closesesion.js"></script>
    <script type="module" src="../js/conValidation.js"></script>
    <script src="../js/animation.js"></script>
</head>

<?php
session_start();
?>

<body class="index">
    <div class="loader" id="loader"></div>
    <?php include "../includes/header.php" ?>

    <!-- Modal error -->
    <dialog id="errorModal" closedby="any" class="dialog-1">
        <h3 class="modalTitle">Aviso</h3>
        <p id="modalMessageError" class="modalText"></p>
        <div class="butt2">
            <button id="acceptBtn2" class="second">Aceptar</button>
        </div>
    </dialog>

    <section class="form-index">
        <article id="art_swap2">
            <h2>Donde tus proyectos encuentran su ritmo.</h2>
            <p class="bigslogan2">
                Sincronía en cada paso
            </p>
            <div class="content-index">
                TaskHive es una plataforma integral de gestión de proyectos diseñada para ayudar a equipos de todos los tamaños a trabajar de forma más organizada, eficiente y colaborativa. Desde la planificación estratégica hasta la ejecución diaria de tareas, TaskHive centraliza todo el flujo de trabajo en un espacio claro, flexible y fácil de usar.

                Con herramientas visuales como tableros Kanban, líneas de tiempo, y calendarios compartidos, puedes priorizar lo importante, asignar responsabilidades y realizar seguimientos en tiempo real. Las notificaciones inteligentes y los paneles personalizables te mantienen al tanto del progreso sin necesidad de perder tiempo buscando información.

                Ya sea que estés coordinando proyectos de desarrollo, marketing, diseño o cualquier otro equipo, TaskHive facilita la colaboración remota, la transparencia y la entrega de resultados consistentes. Con integraciones clave, automatizaciones y una interfaz amigable, es la colmena digital donde tus proyectos prosperan.

                Impulsa tu productividad. Unifica tu equipo. Gestiona con confianza. TaskHive.
            </div>
            <div class="content-index-2">
                <button class="animated-button" id="hero-butt">
                    <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                    <span class="text">Empieza ahora</span>
                    <span class="circle"></span>
                    <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                </button>
                <div class="index-icons">
                    <img src="../assets/images/js.webp" alt="Icono JavaScript">
                    <img src="../assets/images/css-3.webp" alt="Icono CSS">
                    <img src="../assets/images/php.webp" alt="Icono PHP">
                    <img src="../assets/images/html-5.webp" alt="Icono HTML">
                </div>
            </div>
        </article>
        <div class="task-hive">TaskHive</div>
        <article id="img_index"></article>
    </section>
    <section class="index-sub">
        <img src="../assets/svg/double_arrow.svg" alt="Flecha indicadora de scroll" class="arrow-pulse" id="arrow-down">
        <div class="card-index">
            <img src="../assets/images/img_log.webp" alt="Imagen lugar de trabajo">
            <h5 class="card-title">
                Chat integrado
            </h5>
            <p class="card-content">
                Mantente conectado con tu equipo directamente desde la plataforma. Nuestro sistema de mensajería en tiempo real te permite discutir ideas, resolver dudas y seguir el ritmo del proyecto sin tener que cambiar de herramienta.</p>
        </div>
        <div class="card-index">
            <img src="../assets/images/img_reg.webp" alt="Imagen lugar de trabajo">
            <h5 class="card-title">
                Colaboración fácil
            </h5>
            <p class="card-content">
                Invita a miembros de tu equipo, asigna roles y trabaja en conjunto sin complicaciones. Ya sea un equipo pequeño o una organización más grande, nuestra app te permite gestionar permisos y responsabilidades de forma clara y sencilla. </p>
        </div>
        <div class="card-index">
            <img src="../assets/images/cab_3.webp" alt="Imagen lugar de trabajo">
            <h5 class="card-title">
                Uso intuitivo
            </h5>
            <p class="card-content">
                Desde el primer clic, sabrás cómo moverte. La interfaz está diseñada para ser clara, ordenada y accesible, incluso si nunca has usado una app de gestión de proyectos. Céntrate en avanzar, no en aprender a usar la herramienta. </p>
        </div>
        <div class="card-index">
            <img src="../assets/images/cab_1.webp" alt="Imagen lugar de trabajo">
            <h5 class="card-title">
                Sin coste
            </h5>
            <p class="card-content">
                Todas las funcionalidades esenciales están disponibles sin costo alguno. No hay versiones limitadas ni funciones bloqueadas: puedes crear, colaborar y gestionar tus proyectos sin preocuparte por suscripciones o tarifas ocultas. </p>
        </div>
    </section>
    <section class="form-cont" id="contact">
        <div class="form-info">
            <h1>Contacto</h1>
            <h2>¿Tienes preguntas o sugerencias?</h2>
            <p class="content-cont">Nos encantaría saber de ti. Ya sea que estés probando la app por primera vez, que tengas una idea para mejorar alguna funcionalidad o necesites ayuda con tu cuenta, estamos aquí para escucharte.</p>
            <p class="content-cont">Completa el formulario y te responderemos lo antes posible. Cada mensaje que recibimos nos ayuda a mejorar y crecer, así que no dudes en escribirnos. Tu experiencia como usuario es lo más importante para nosotros.</p>
        </div>
        <article id="form-cont">
            <form action="../api/contacto.php" method="post">
                <label for="index-nombre">Nombre:</label>
                <input id="index-nombre" type="text" name="nombre" placeholder="Introduce tu nombre." aria-describedby="error-index-nombre">
                <span class="errorinfo" id="error-index-nombre" role="alert"></span>

                <label for="index-email">Email:</label>
                <input type="email" id="index-email" name="email" placeholder="Introduce tu correo electrónico." aria-describedby="error-index-email">
                <span class="errorinfo" id="error-index-email" role="alert"></span>

                <label for="index-mensaje">Mensaje:</label>
                <textarea id="index-mensaje" name="mensaje" rows="5" aria-describedby="error-index-mensaje"></textarea>
                <span class="errorinfo" id="error-index-mensaje" role="alert"></span>

                <button type="submit">Enviar mensaje</button>
            </form>
        </article>
        <article id="img_con"></article>
    </section>
    <?php include "../includes/footer.php"; ?>
</body>

</html>