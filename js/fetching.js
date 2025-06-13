import { DomElements } from "./domElements.js";
import { setCurrentProyect, getCurrentProyect, fetchData, deleteCollab, fillInputs, deleteProyect, confirmationModal } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {

    //No mostrar una imagen al arrastrar un elemento draggable
    function dragItemNoImage(e) {
        const img = new Image();
        img.src = "";
        e.dataTransfer.setDragImage(img, 0, 0);
        e.dataTransfer.setData("text/plain", e.target.id);
    }

    //Limpiar Contenedores de tareas
    function cleanTaskContainers() {
        const containers = [todo, doing, done, sprint, backlog];
        containers.forEach(container => {
            Array.from(container.children).forEach(child => {
                if (!child.classList.contains("title") && !child.classList.contains("line2") && !child.tagName == "hr") {
                    child.remove();
                }
            });
        });
    }

    //Renderizar Colaboradores
    function renderCollabs(arrCollabs) {
        if (arrCollabs.length > 0) {
            DomElements.collabContainer.textContent = "";
            for (let colaborador of arrCollabs) {
                let newCollab = printCollab(colaborador);
                DomElements.collabContainer.appendChild(newCollab);
            }
        }
    }

    //Renderizar Proyectos
    function renderProyects(arrProyects) {
        if (arrProyects.length > 0) {
            DomElements.proyectContainer.textContent = "";
            for (let proyecto of arrProyects) {
                let newProyect = printProyect(proyecto);
                DomElements.proyectContainer.appendChild(newProyect);
            }
        }
    }

    //Renderizar tareas
    function renderTask(arrtasks) {
        cleanTaskContainers();
        for (let i = 0; i < arrtasks.length; i++) {
            const task = arrtasks[i];
            if (task.estado === 0) {
                DomElements.backlog.appendChild(printTask(task));
            } else if (task.estado === 1) {
                DomElements.sprint.appendChild(printTask(task));
            } else if (task.estado === 2) {
                DomElements.todo.appendChild(printTask(task));
            } else if (task.estado === 3) {
                DomElements.doing.appendChild(printTask(task));
            } else if (task.estado === 4) {
                DomElements.done.appendChild(printTask(task));
            }
        }
    }

    //Options de Asignaciones
    function renderSelects(arrCollabs) {
        if (arrCollabs.length > 0) {
            DomElements.asigSelect.textContent = "";
            DomElements.asigEdit.textContent = "";
            for (let colaborador of arrCollabs) {
                let newOption = document.createElement("option");
                let newOption2 = document.createElement("option");
                newOption.setAttribute("value", colaborador.id);
                newOption.textContent = `${colaborador.nombre} ${colaborador.apellidos} `;
                newOption2.setAttribute("value", colaborador.id);
                newOption2.textContent = `${colaborador.nombre} ${colaborador.apellidos} `;
                DomElements.asigSelect.appendChild(newOption2);
                DomElements.asigEdit.appendChild(newOption);
            }
        }
    }

    //Proyecto no seleccionado
    function renderEmptyDashboard() {
        let newDiv = document.createElement("div");
        let newP = document.createElement("p");
        let img = document.createElement("img");
        newDiv.classList.add("empty-proyect");
        newP.textContent = "Vaya, parece que aún no has iniciado ningun proyecto";
        img.src = "../assets/svg/home_icon.svg";
        img.alt = "Icono tablero vacío";
        newDiv.appendChild(img);
        newDiv.appendChild(newP);

        return newDiv;
    }

    //Crear proyecto
    function printProyect(proyecto) {
        const newDiv = document.createElement("div");
        const newDiv2 = document.createElement("div");
        const button1 = document.createElement("button");
        const button3 = document.createElement("button");

        button1.classList.add("select");
        button3.classList.add("deleteCollabBtn");
        newDiv.classList.add("procard");
        newDiv2.classList.add("procarddiv");
        newDiv.textContent = proyecto.nombre;
        newDiv2.appendChild(button3);
        newDiv2.appendChild(button1);
        newDiv.appendChild(newDiv2)

        button1.setAttribute("aria-label","Icono iniciar proyecto");
        button3.setAttribute("aria-label","Icono Borrar proyecto");

        button1.addEventListener("click", () => {
            setCurrentProyect(proyecto.idProyecto, proyecto.nombre);
            window.location.href = "../views/dashboard.php";
        });

        button3.addEventListener("click", () => {
            confirmationModal("¿Estas seguro de borrar este proyecto?", () => {
                deleteProyect(proyecto.idProyecto);
            });
        });

        return newDiv;
    }

    //Crear Tarea
    function printTask(task) {
        let newitemloaded = document.createElement("div");

        let divTitle = document.createElement("div");
        let editButton = document.createElement("button");
        let expandButton = document.createElement("button");
        let title = document.createElement("div");
        let imgButton = document.createElement("img");
        let imgButton2 = document.createElement("img");
        let buttons = document.createElement("div");

        let line = document.createElement("hr");
        let index1 = document.createElement("div");
        let index2 = document.createElement("div");
        let index3 = document.createElement("div");
        let index4 = document.createElement("div");
        let content1 = document.createElement("div");
        let content2 = document.createElement("div");
        let content3 = document.createElement("div");
        let content4 = document.createElement("div");

        title.textContent = task.titulo || "Sin título";
        index1.textContent = "Estimación:";
        index2.textContent = "Prioridad:";
        index4.textContent = "Asignación:";
        index3.textContent = "Descripción:";
        content1.textContent = task.estimacion;
        content2.textContent = convertirPrioridad(task.prioridad);
        content3.textContent = task.descripcion || "Sin descripción";
        content4.textContent = `${task.nombreAsignado} ${task.apellidosAsignado}`;
        newitemloaded.style.background = task.color_agenciado;

        imgButton.src = "../assets/svg/edit.svg";
        imgButton.alt = "Icono editar tarea";
        editButton.appendChild(imgButton);

        imgButton2.src = "../assets/svg/arrow_down.svg";
        imgButton2.alt = "Icono expandir tarea";
        expandButton.appendChild(imgButton2);

        newitemloaded.classList.add("movable-task");
        divTitle.classList.add("title-div");
        title.classList.add("tit-item");
        line.classList.add("line");
        index1.classList.add("content");
        index2.classList.add("content");
        index3.classList.add("content");
        index4.classList.add("content");
        content1.classList.add("content-2");
        content2.classList.add("content-2");
        content3.classList.add("content-2");
        content4.classList.add("content-2");
        buttons.classList.add("buttons");

        divTitle.appendChild(title);
        buttons.appendChild(editButton);
        buttons.appendChild(expandButton);
        divTitle.appendChild(buttons);

        newitemloaded.appendChild(divTitle);
        newitemloaded.appendChild(line);
        newitemloaded.appendChild(index1);
        newitemloaded.appendChild(content1);
        newitemloaded.appendChild(index2);
        newitemloaded.appendChild(content2);
        newitemloaded.appendChild(index4);
        newitemloaded.appendChild(content4);
        newitemloaded.appendChild(index3);
        newitemloaded.appendChild(content3);

        newitemloaded.draggable = true;
        newitemloaded.id = `task-${task.id}`;
        newitemloaded.classList.add("task-item");
        newitemloaded.className = "item-3 task-item";

        editButton.addEventListener("click", () => {
            const chat = document.getElementById("chat");
            const editTask = document.getElementById("edit-task");
            const newTask = document.getElementById("newtask");

            chat.style.display = "none";
            newTask.style.display = "none";
            editTask.style.display = "flex";

            // Obtener el contenedor padre dinámicamente
            const parent = newitemloaded.parentNode;

            // Mover editTask a la segunda posición, si hay al menos 2 hijos
            if (parent && parent.children.length > 1) {
                parent.insertBefore(newitemloaded, parent.children[1]);
            }

            parent.scrollTop = 0;

            fillInputs(task.id);
        });


        document.getElementById("canceledit").addEventListener("click", () => {
            let chat = document.getElementById("chat");
            let editTask = document.getElementById("edit-task");
            let newTask = document.getElementById("newtask");

            chat.style.display = "flex";
            newTask.style.display = "none";
            editTask.style.display = "none";
        });

        // Inicialmente ocultar todos los elementos de contenido (excepto el título)
        let contentElements = [index1, content1, index2, content2, index3, content3, index4, content4, line, editButton];

        contentElements.forEach(element => {
            element.style.display = "none"; // Ocultar todos los elementos de contenido al inicio
        });

        // Agregar funcionalidad para expandir y contraer
        expandButton.addEventListener("click", () => {
            let isVisible = contentElements[0].style.display === "flex"; // Verifica si los elementos están visibles
            if (isVisible) {
                contentElements.forEach(element => {
                    element.style.display = "none";
                    imgButton2.src = "../assets/svg/arrow_down.svg";
                    imgButton2.alt = "Icono expandir tarea"; 
                });
            } else {
                contentElements.forEach(element => {
                    element.style.display = "flex";
                    imgButton2.src = "../assets/svg/arrow_up.svg";
                    imgButton2.alt = "Icono minimizar tarea"; 
                });
            }
        });

        newitemloaded.addEventListener("dragstart", dragItemNoImage);

        return newitemloaded;
    }



    //Crear Colaborador
    function printCollab(colaborador) {
        const divMessage = document.createElement("div");
        const divIzq = document.createElement("div");
        const div1Message = document.createElement("div");
        const div2Message = document.createElement("div");
        const imgMessage = document.createElement("img");
        const sectionContent = document.createElement("section");
        const deleteBtn = document.createElement("button");

        imgMessage.src = colaborador.avatar;
        imgMessage.alt = "Miniatura de imagen de usuario para colaborador";

        if(colaborador.rol=='creador'){
            sectionContent.textContent = colaborador.nombre + " " + colaborador.apellidos + " (creador)";
        }else{
            sectionContent.textContent = colaborador.nombre + " " + colaborador.apellidos;
        }

        sectionContent.classList.add("message-card-section-content");
        divIzq.classList.add("collabIzq");
        divMessage.classList.add("message-card-article-4");
        div2Message.classList.add("message-card-main-3");
        div1Message.classList.add("message-card-aside");
        deleteBtn.classList.add("deleteCollabBtn");
        deleteBtn.setAttribute("aria-label", "Icono borrar colaborador");

        divIzq.appendChild(div1Message);
        divIzq.appendChild(div2Message);
        div1Message.appendChild(imgMessage);
        div2Message.appendChild(sectionContent);
        divMessage.appendChild(divIzq);
        divMessage.appendChild(deleteBtn);

        deleteBtn.addEventListener("click", () => {
            confirmationModal("¿Seguro que quieres eliminar este colaborador?", () => {
                deleteCollab(colaborador.id);
            });
        });

        return divMessage;
    }

    //Renderizar contenedores
    async function showAll() {
        const currentProyectId = await getCurrentProyect();
        if (currentProyectId !== "") {
            fetchData("../api/collabs.php", renderCollabs);
            fetchData("../api/tasks.php", renderTask);
            fetchData("../api/selects.php", renderSelects);
            DomElements.newbutton.disabled = false;
            DomElements.addcollab.disabled = false;
            DomElements.formchat.style.display = "flex";
            DomElements.chatdiv.style.display = "flex";
            DomElements.clearChat.style.visibility = "visible";
            DomElements.refreshBtn.style.display = "flex";
        } else {
            DomElements.newbutton.setAttribute("disabled", true);
            DomElements.addcollab.setAttribute("disabled", true);
            let unselected = renderEmptyDashboard();
            DomElements.dashboard.textContent = "";
            DomElements.dashboard.appendChild(unselected);
            DomElements.formchat.style.display = "none";
            DomElements.chatdiv.style.display = "none";
            DomElements.clearChat.style.visibility = "hidden";
            DomElements.refreshBtn.style.display = "none";
        }
        fetchData("../api/proyects.php", renderProyects);
    }

    //Convertir Prioridad
    function convertirPrioridad(valor) {
        const prioridades = [
            "Baja",
            "Media-Baja",
            "Media",
            "Media-Alta",
            "Alta"
        ];

        if (valor >= 0 && valor <= 4) {
            return prioridades[valor];
        }
    }

    DomElements.refreshBtn.addEventListener("click", () => {
        window.location.reload();
    })

    showAll();

});
