<?php
// Verificamos si hay alguna sesión iniciada
session_start();
if (empty($_SESSION["idUsuario"])) {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Visualiza y gestiona tus proyectos en un solo lugar. Organiza tareas, colabora con tu equipo y haz seguimiento del progreso en tiempo real.">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style-copy.css">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <script type="module" src="../js/fetching.js"></script>
    <script type="module" src="../js/calendar.js"></script>
    <script type="module" src="../js/chat.js"></script>
    <script type="module" src="../js/newTaskValidation.js"></script>
    <script type="module" src="../js/editTaskValidation.js"></script>
    <script type="module" src="../js/dashboard.js"></script>
    <script type="module" src="../js/editUserValidation.js"></script>
    <script type="module" src="../js/newPassValidation.js"></script>
    <script type="module" src="../js/closesesion.js"></script>
    <script type="module" src="../js/proCollabValidation.js"></script>
</head>

<body class="dash">
    <div class="loader" id="loader"></div>
    <?php include "../includes/header.php" ?>
    <!-- Modal confirmacion -->
    <dialog id="confirmationModal" closedby="any" class="dialog-1">
        <h3 class="modalTitle">Aviso</h3>
        <p id="modalMessage" class="modalText"></p>
        <div class="butt2">
            <button id="acceptBtn" class="second">Aceptar</button>
            <button id="cancelBtn" class="cancel">Cancelar</button>
        </div>
    </dialog>

    <!-- Modal error -->
    <dialog id="errorModal" closedby="any" class="dialog-1">
        <h3 class="modalTitle">Aviso</h3>
        <p id="modalMessageError" class="modalText"></p>
        <div class="butt2">
            <button id="acceptBtn2" class="second">Aceptar</button>
        </div>
    </dialog>

    <!-- Modal password -->
    <dialog id="passModal" closedby="any" class="dialog-3">
        <h3 class="modalTitle">Cambiar Contraseña</h3>
        <p>Por seguridad, te pedimos que ingreses tu contraseña actual y luego elijas una nueva.
            Asegúrate de que la nueva contraseña sea segura y fácil de recordar.</p>
        <form action="../api/changepass.php" method="post" id="newpass-form">
            <label for="oldpass">Antigüa Contraseña:</label>
            <input type="password" name="oldpass" placeholder="Introduce tu contraseña actual" id="oldpass" aria-describedby="errorinfo-changepass">
            <span class="errorinfo" role="alert" id="errorinfo-changepass"></span>

            <label for="newpass">Nueva Contraseña:</label>
            <input type="password" name="newpass" id="newpass" placeholder="Ejemplo€jemplo123" aria-describedby="newpass-error">
            <span class="errorinfo" id="newpass-error" role="alert"></span>

            <label for="newpass-conf">Confirmar contraseña:</label>
            <input type="password" name="newpass-conf" id="newpass-conf" placeholder="Confirma la contraseña" aria-describedby="newpass-error-2">
            <span class="errorinfo" id="newpass-error-2" role="alert"></span>

            <div class="butt2">
                <button class="second" type="submit">Aceptar</button>
                <button class="cancel" type="button" id="cancel-pass-modal">Cancelar</button>
            </div>
        </form>
        <aside></aside>
    </dialog>

    <!-- Modal delete -->
    <dialog id="deleteModal" closedby="any" class="dialog-4">
        <h3 class="modalTitle">¿Estás seguro de eliminar este usuario?</h3>
        <p>Al confirmar esta acción, se eliminarán de forma permanente todos los datos asociados al usuario, incluyendo su perfil, configuraciones, historial de actividad, archivos y cualquier información vinculada. Esta acción no se puede deshacer.</p>
        <p><strong>Por favor, asegúrate de haber respaldado cualquier dato importante antes de continuar.</strong></p>
        <form action="../api/deleteuser.php" method="post">
            <label for="delete-pass">Introduce tu contraseña:</label>
            <input type="password" name="delete-pass" id="delete-pass">
            <div class="butt2">
                <button id="acceptBtn2" class="second">Borrar Usuario</button>
                <button class="cancel" type="button" id="cancel-delete-user">Cancelar</button>
            </div>
        </form>
        <aside></aside>
    </dialog>

    <div class="document-cont">
        <div class="container-3">
            <!-- MENU USUARIO -->
            <div class="usermenu">
                <img src=<?php echo $_SESSION["avatar"] ?> alt="Miniatura de imagen de Usuario" class="user-img">
                <button class="usermenu-button" id="usermenu-button"><img src="../assets/svg/settings.svg" alt="Icono editar usuario" id="usermenu-button-img"></button>
            </div>

            <div class="subcont">

                <!-- FORMULARIO PROYECTOS -->
                <div class="subcont2" id="proyectos">
                    <div class="headman">
                        <div class="title">Proyectos</div>
                        <button id="newpro"><img src="../assets/svg/new.svg" alt="Icono nuevo proyecto" id="newpro-img"></button>
                    </div>
                    <div class="proyects" id="pro1">
                        <div class="empty-collab">
                            <img src="../assets/svg/file_icon.svg" alt="Icono archivo">
                            <p>Aún no has creado ningún proyecto.</p>
                        </div>
                    </div>
                    <div class="proyects-2" id="pro2">
                        <form action="../api/newproyect.php" method="post" id="new-pro">
                            <label for="new-pro-name">Nombre del proyecto:</label>
                            <div class="butform">
                                <input type="text" name="proyectname" id="new-pro-name" aria-describedby="newpass-error-2">
                                <span class="errorinfo-2" id="new-pro-error" role="alert"></span>
                                <button type="submit">✔</button>
                            </div>
                            <span class="errorinfo-2"></span>
                        </form>
                    </div>
                </div>

                <!-- FORMULARIO EDITAR USUARIO -->
                <div class="subcont2" id="edit-user">
                    <div class="headman">
                        <div class="title">Editar Perfil</div>
                        <div class="headmanbutt">
                            <button form="form-edit-user" type="submit"><img src="../assets/svg/save.svg" alt="Icono guardar cambios"></button>
                        </div>
                    </div>
                    <div class="proyects-3">
                        <img src=<?php echo $_SESSION["avatar"] ?> alt="Miniatura imagen usuario" class="user-img-2">
                        <div class="user-tit"><?php echo $_SESSION["nombreUsuario"] ?></div>
                        <form action="../api/edituser.php" method="post" enctype="multipart/form-data" id="form-edit-user">
                            <label for="edit-user-name">Nombre:</label>
                            <input type="text" id="edit-user-name" name="user-edit-name" placeholder="Máximo 20 caractéres." value="<?php echo $_SESSION["nombreUsuario"] ?>" aria-describedby="edit-user-errorname">
                            <span id="edit-user-errorname" class="errorinfo" role="alert"></span>

                            <label for="edit-user-lastname">Apellidos:</label>
                            <input type="text" id="edit-user-lastname" name="user-edit-lastname" placeholder="Máximo 40 caractéres." value="<?php echo $_SESSION["apellidos"] ?>" aria-describedby="edit-user-errorlastname">
                            <span id="edit-user-errorlastname" class="errorinfo" role="alert"></span>

                            <label for="edit-user-foto">Foto perfil: (jpeg, jpg)</label>
                            <input type="file" id="edit-user-foto" name="foto" aria-describedby="edit-user-errorfoto">
                            <span id="edit-user-errorfoto" class="errorinfo" role="alert"></span>

                            <button id="delete-user" type="button" class="second">Borrar usuario</button>
                            <button class="second" type="button" id="changePasswordModalBtn">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>

                <!-- FORMULARIO COLABORADORES -->
                <div class="subcont2" id="colaboradores">
                    <div class="headman">
                        <div class="title">Colaboradores</div>
                        <button id="addcollab"><img src="../assets/svg/addCollab.svg" alt="Icono añador colaborador" id="addcollab-img"></button>
                    </div>
                    <div class="proyects" id="pro3">
                        <!-- EMPTY COLLAB -->
                        <div class="empty-collab">
                            <img src="../assets/svg/collab_icon.svg" alt="Icono colaboradores vacios">
                            <p>Aún no has añadido colaboradores a este proyecto.</p>
                        </div>
                    </div>
                    <div class="newcollab" id="newcollab">
                        <form action="../api/newcollab.php" method="post" id="new-collab-form">
                            <label for="new-collab-email">Añade un colaborador:</label>
                            <div class="butform">
                                <input type="email" name="emailcollab" id="new-collab-email" aria-describedby="new-collab-email-error">
                                <span id="new-collab-email-error" class="errorinfo-2" role="alert"></span>
                                <button type="submit">✔</button>
                            </div>
                            <span class="errorinfo-2"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLERO PRINCIPAL -->
        <div class="tble">

            <!-- CABECERA TABLERO -->
            <div class="container2">
                <h1><?php echo $_SESSION["nombreProyectoIniciado"] ?></h1>
                <div class="container2-sub">
                    <button id="refresh" class="refresh"><img src="../assets/svg/refresh.svg" alt="Icono de refrescar el tablero"></button>
                    <button id="new">Nueva Tarea</button>
                </div>
            </div>

            <!-- CUERPO TABLERO -->
            <div class="dashboard" id="dashboard">

                <!-- CONTENEDORES DRAG AND DROP -->
                <div class="container" id="sprint">
                    <div class="title-3">Sprint</div>
                </div>
                <div class="container" id="todo">
                    <div class="title-3">To-do</div>
                </div>
                <div class="container" id="doing">
                    <div class="title-3">Doing</div>
                </div>
                <div class="container" id="done">
                    <div class="title-3">Done</div>
                </div>
                <div class="container" id="backlog">
                    <div class="title-3">Backlog</div>
                </div>

                <!-- CALENDARIO -->
                <div class="container" id="other">
                    <custom-calendar>
                        <calendar-header>
                            <button id="prevMonth"><img src="../assets/svg/arrow_left.svg" alt="Icono flecha izquierda"></button>
                            <span id="monthYear"></span>
                            <button id="nextMonth"><img src="../assets/svg/arrow_rigth.svg" alt="Icono flecha derecha"></button>
                        </calendar-header>
                        <div class="calendar-weekdays">
                            <div>Lun</div>
                            <div>Mar</div>
                            <div>Mié</div>
                            <div>Jue</div>
                            <div>Vie</div>
                            <div>Sáb</div>
                            <div>Dom</div>
                        </div>
                        <calendar-grid id="calendarGrid"></calendar-grid>
                    </custom-calendar>
                </div>
            </div>
        </div>

        <!-- CHAT -->
        <div class="container-4" id="chat">

            <!-- CABECERA CHAT -->
            <div class="headman">
                <div class="title">Chat</div>
                <div class="headmanbutt">
                    <button id="clear-chat"><img src="../assets/svg/clear.svg" alt="Icono vaciar chat"></button>
                </div>
            </div>

            <!-- CONTENEDOR MENSAJES -->
            <div class="chat-div" id="chatdiv">
                <div class="empty-chat">
                    <img src="../assets/svg/chat_icon.svg" alt="Icono chat vacío">
                    <p>Envia un mensaje para comenzar a chatear.</p>
                </div>
            </div>

            <!-- ENVIAR MENSAJES -->
            <form class="send-messages" id="formchat">
                <input type="text" id="chatcontent" autocomplete="off" placeholder="Escribe aquí tu mensaje" aria-label="Campo de mensaje">
                <button class="send" type="submit" aria-label="Enviar mensaje">Enviar</button>
            </form>
        </div>

        <!-- FORMULARIO NUEVA TAREA -->
        <div class="container-4" id="newtask">
            <div class="headman">
                <div class="title">Nueva Tarea</div>
                <div class="headmanbutt">
                    <button form="new-task-form" type="submit"><img src="../assets/svg/save.svg" alt="Icono guardar cambios"></button>
                    <button id="cancelnewtask"><img src="../assets/svg/close.svg" alt="Icono cerrar pesaña"></button>
                </div>
            </div>
            <div class="proyects-3">
                <form action="../api/newtask.php" method="post" id="new-task-form">
                    <label for="title-new">Título:</label>
                    <input type="text" id="title-new" name="title" placeholder="Máximo 40 caracteres" aria-describedby="errortitle-new">
                    <span id="errortitle-new" class="errorinfo" role="alert"></span>
                    <label for="estimation-new">Estimación:</label>
                    <input type="date" id="estimation-new" name="estimation" aria-describedby="errorestimation-new">
                    <span id="errorestimation-new" class="errorinfo" role="alert"></span>
                    <label for="state-new">Estado:</label>
                    <select name="state" id="state-new" aria-describedby="errorstate-new">
                        <option value="0" selected>Backlog</option>
                        <option value="1">Sprint</option>
                        <option value="2">To Do</option>
                        <option value="3">Doing</option>
                        <option value="4">Done</option>
                    </select>
                    <span id="errorstate-new" class="errorinfo" role="alert"></span>
                    <label for="asig">Asignación:</label>
                    <select name="asig" id="asig" aria-describedby="errorasig-new">

                    </select>
                    <span id="errorasig-new" class="errorinfo" role="alert"></span>
                    <div class="subform">
                        <div class="color">
                            <label for="color-new">Color:</label>
                            <input type="color" value="#bebdbd" name="color" id="color-new" aria-describedby="color-new-error">
                            <span class="errorinfo" role="alert" id="color-new-error"></span>
                        </div>
                        <div class="priority">
                            <label for="priority-new">Prioridad:</label>
                            <select name="priority" id="priority-new" aria-describedby="errorpriority-new">
                                <option value="0" selected>Baja</option>
                                <option value="1">Media-Baja</option>
                                <option value="2">Media</option>
                                <option value="3">Media-Alta</option>
                                <option value="4">Alta</option>
                            </select>
                            <span id="errorpriority-new" class="errorinfo" role="alert"></span>
                        </div>
                    </div>
                    <label for="desc-new">Descripción:</label>
                    <textarea name="desc" id="desc-new" aria-describedby="errordesc-new"></textarea>
                    <span id="errordesc-new" class="errorinfo" role="alert"></span>
                </form>
            </div>
        </div>

        <!-- FORMULARIO EDITAR TAREA -->
        <div class="container-4" id="edit-task">
            <div class="headman">
                <div class="title">Editar tarea</div>
                <div class="headmanbutt">
                    <button form="edit-task-form" formaction="../api/taskdelete.php" type="submit" id="deletetask"><img src="../assets/svg/delete_2.svg" alt="Icono borrar tarea"></button>
                    <button form="edit-task-form" formaction="../api/taskedit.php" type="submit"><img src="../assets/svg/save.svg" alt="Icono guardar cambios"></button>
                    <button id="canceledit"><img src="../assets/svg/close.svg" alt="Icono cerrar pesaña"></button>
                </div>
            </div>
            <div class="proyects-3">
                <form method="post" class="newtaskform" id="edit-task-form">
                    <input type="hidden" id="id-edit" name="id-edit">
                    <label for="title-edit">Título:</label>
                    <input type="text" id="title-edit" name="title-edit" placeholder="Máximo 40 caracteres" aria-describedby="errortitle-edit">
                    <span class="errorinfo" id="errortitle-edit" role="alert"></span>
                    <label for="estimation-edit">Estimación:</label>
                    <input type="date" id="estimation-edit" name="estimation-edit" aria-describedby="errorestimation-edit">
                    <span class="errorinfo" id="errorestimation-edit" role="alert"></span>
                    <label for="state-edit">Estado:</label>
                    <select name="state-edit" id="state-edit" aria-describedby="errorstate-edit">
                        <option value="0" selected>Backlog</option>
                        <option value="1">Sprint</option>
                        <option value="2">To Do</option>
                        <option value="3">Doing</option>
                        <option value="4">Done</option>
                    </select>
                    <span class="errorinfo" id="errorstate-edit" role="alert"></span>
                    <label for="asig-edit">Asignación:</label>
                    <select name="asig-edit" id="asig-edit" aria-describedby="asig-error-edit">

                    </select>
                    <span class="errorinfo" role="alert" id="asig-error-edit"></span>
                    <div class="subform">
                        <div class="color">
                            <label for="coloredit">Color:</label>
                            <input type="color" name="color" id="coloredit" aria-describedby="color-error-edit">
                            <span class="errorinfo" role="alert" id="color-error-edit"></span>
                        </div>
                        <div class="priority">
                            <label for="priority-edit">Prioridad:</label>
                            <select name="priority-edit" id="priority-edit" aria-describedby="errorpriority-edit">
                                <option value="0" selected>Baja</option>
                                <option value="1">Media-Baja</option>
                                <option value="2">Media</option>
                                <option value="3">Media-Alta</option>
                                <option value="4">Alta</option>
                            </select>
                            <span class="errorinfo" id="errorpriority-edit" role="alert"></span>
                        </div>
                    </div>
                    <label for="desc-edit">Descripción:</label>
                    <textarea name="desc-edit" id="desc-edit" aria-describedby="errordesc-edit"></textarea>
                    <span class="errorinfo" id="errordesc-edit" role="alert"></span>
                </form>
            </div>
        </div>
    </div>
</body>

</html>