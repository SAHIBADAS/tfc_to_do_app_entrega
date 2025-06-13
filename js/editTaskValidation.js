import { DomElements } from "./domElements.js";
import { confirmationModal } from "./serverRequest.js";
document.addEventListener("DOMContentLoaded", () => {

    //Validación título tarea
    function titleValidation() {
        if (DomElements.titleEdit.value.length > 0 && DomElements.titleEdit.value.length < 40) {
            DomElements.titleEdit.classList.remove("error_input");
            DomElements.errorTitleEdit.textContent = "";
            return true;
        } else {
            DomElements.titleEdit.classList.add("error_input");
            DomElements.errorTitleEdit.textContent = "Introduce un título válido";
            return false;
        }
    }

    //Validación estimación tarea
    function estimationValidation() {
        const date = new Date(DomElements.estimationEdit.value);
        if (isNaN(date.getTime())) {
            DomElements.estimationEdit.classList.add("error_input");
            DomElements.errorEstimationEdit.textContent = "Fecha no válida";
            return false;
        } else {
            DomElements.estimationEdit.classList.remove("error_input");
            DomElements.errorEstimationEdit.textContent = "";
            return true;
        }
    }

    //Validación estado tarea
    function stateValidation() {
        const validStates = ["0", "1", "2", "3", "4"];
        if (validStates.includes(DomElements.stateEdit.value)) {
            DomElements.stateEdit.classList.remove("error_input");
            DomElements.errorStateEdit.textContent = "";
            return true;
        } else {
            DomElements.errorStateEdit.textContent = "Estado inválido";
            DomElements.stateEdit.classList.add("error_input");
            return false;
        }
    }

    //Validación prioridad tarea
    function priorityValidation() {
        const validPriorities = ["0", "1", "2", "3", "4"];
        if (validPriorities.includes(DomElements.priorityEdit.value)) {
            DomElements.priorityEdit.classList.remove("error_input");
            return true;
        } else {
            DomElements.priorityEdit.classList.add("error_input");
            return false;
        }
    }

    //Validacion descripción tarea
    function descValidation() {
        if (DomElements.descEdit.value.length > 0 && DomElements.descEdit.value.length < 500) {
            DomElements.descEdit.classList.remove("error_input");
            DomElements.errorDescEdit.textContent = "";
            return true;
        } else {
            DomElements.descEdit.classList.add("error_input");
            DomElements.errorDescEdit.textContent = "Descripción inválida";
            return false;
        }
    }

    //Validación formulario
    function validationAll(e) {
        e.preventDefault();

        const isValid = titleValidation() &&
            estimationValidation() &&
            stateValidation() &&
            priorityValidation() &&
            descValidation();

        if (isValid) {
            DomElements.editTaskForm.action = "../api/taskedit.php";
            DomElements.editTaskForm.submit();
        }
    }


    //Submit Formulario
    DomElements.editTaskForm.addEventListener("submit", (e) => {
        e.preventDefault();

        if (e.submitter === DomElements.deleteTask) {
            confirmationModal("¿Seguro que quieres eliminar la tarea?", () => {
                DomElements.editTaskForm.action = "../api/taskdelete.php";
                DomElements.editTaskForm.submit();
            });
        } else {
            validationAll(e);
        }
    });

    //Eventos validación
    DomElements.titleEdit.addEventListener("blur", titleValidation);
    DomElements.estimationEdit.addEventListener("blur", estimationValidation);
    DomElements.stateEdit.addEventListener("blur", stateValidation);
    DomElements.priorityEdit.addEventListener("blur", priorityValidation);
    DomElements.descEdit.addEventListener("blur", descValidation);

});
