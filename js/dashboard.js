import { DomElements } from "./domElements.js"
import { updateTaskState, checkAndShowErrorModal, checkAndShowSuccess, iniciarDetectorInactividad } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {

    // Hacemos que un elemento sea dropeable
    function setupDragAndDrop(container) {
        container.addEventListener("dragover", (e) => {
            e.preventDefault();
        });

        container.addEventListener("dragenter", (e) => {
            e.preventDefault();
        });

        container.addEventListener("drop", async (e) => {
            e.preventDefault();
            const taskId = e.dataTransfer.getData("text/plain");
            const draggedElement = document.getElementById(taskId);

            const contId = getStateValue(container.id);

            if (draggedElement) {
                container.appendChild(draggedElement);
                await updateTaskState(taskId, contId);
                console.log(`Elemento soltado en ${container.id}`);
            }
        });
    }

    //Pasamos de los ids de los contenedores a variables numericas
    function getStateValue(state) {
        switch (state.toLowerCase()) {
            case "backlog":
                return 0;
            case "sprint":
                return 1;
            case "todo":
                return 2;
            case "doing":
                return 3;
            case "done":
                return 4;
            default:
                return -1; // Valor por defecto si no coincide con ningún caso
        }
    }

    // Event listeners
    DomElements.editUserButton.addEventListener("click", () => {
        const isEditing = DomElements.editUser.style.display === "flex";

        if (isEditing) {
            DomElements.editUser.style.display = "none";
            DomElements.proyectos.style.display = "flex";
            DomElements.colaboradores.style.display = "flex";
            DomElements.userButt.src = "../assets/svg/settings.svg";
        } else {
            DomElements.editUser.style.display = "flex";
            DomElements.proyectos.style.display = "none";
            DomElements.colaboradores.style.display = "none";
            DomElements.userButt.src = "../assets/svg/close_2.svg";
        }
    });


    DomElements.newbutton.addEventListener("click", () => {
        DomElements.newtask.style.display = "flex";
        DomElements.chat.style.display = "none";
        let editTask = document.getElementById("edit-task");
        editTask.style.display = "none";
    });

    DomElements.cancelnewtask.addEventListener("click", () => {
        DomElements.newtask.style.display = "none";
        DomElements.chat.style.display = "flex";
    });

    DomElements.newpro.addEventListener("click", () => {
        const isCreating = DomElements.pro2.style.display === "flex";

        if (isCreating) {
            DomElements.pro2.style.display = "none";
            DomElements.pro1.style.display = "flex";
            DomElements.newProImg.src = "../assets/svg/new.svg";
        } else {
            DomElements.pro1.style.display = "none";
            DomElements.pro2.style.display = "flex";
            DomElements.newProImg.src = "../assets/svg/close.svg";
        }
    });


    DomElements.addcollab.addEventListener("click", () => {
        const isAdding = DomElements.newcollab.style.display === "flex";

        if (isAdding) {
            DomElements.newcollab.style.display = "none";
            DomElements.pro3.style.display = "flex";
            DomElements.addCollabImg.src = "../assets/svg/addCollab.svg";
        } else {
            DomElements.pro3.style.display = "none";
            DomElements.newcollab.style.display = "flex";
            DomElements.addCollabImg.src = "../assets/svg/close.svg";
        }
    });


    DomElements.changePasswordModalBtn.addEventListener("click", () => {
        DomElements.modalPassword.showModal();
    });

    DomElements.deleteUserBtn.addEventListener("click", () => {
        DomElements.modalDeleteUser.showModal();
    });

    DomElements.cancelDeleteUser.addEventListener("click", () => {
        DomElements.modalDeleteUser.close();
    });

    //Hacemos los contenedores droppables
    setupDragAndDrop(DomElements.todo);
    setupDragAndDrop(DomElements.doing);
    setupDragAndDrop(DomElements.done);
    setupDragAndDrop(DomElements.backlog);
    setupDragAndDrop(DomElements.sprint);

    checkAndShowErrorModal();
    checkAndShowSuccess();
});
