import { DomElements } from "./domElements.js";
document.addEventListener("DOMContentLoaded", () => {

    //Validación título
    function titleValidation() {
        if (DomElements.titleNew.value.length > 0 && DomElements.titleNew.value.length < 40) {
            DomElements.titleNew.classList.remove("error_input");
            DomElements.errorTitleNew.textContent = "";
            return true;
        } else {
            DomElements.titleNew.classList.add("error_input");
            DomElements.errorTitleNew.textContent = "Introduce un título válido";
            return false;
        }
    }

    //Validación estimación
    function estimationValidation() {
        const date = new Date(DomElements.estimationNew.value);
        if (isNaN(date.getTime())) {
            DomElements.estimationNew.classList.add("error_input");
            DomElements.errorEstimationNew.textContent = "Fecha no válida";
            return false;
        } else {
            DomElements.estimationNew.classList.remove("error_input");
            DomElements.errorEstimationNew.textContent = "";
            return true;
        }
    }

    //Validación Estado
    function stateValidation() {
        const validStates = ["0", "1", "2", "3", "4"];
        if (validStates.includes(DomElements.stateNew.value)) {
            DomElements.stateNew.classList.remove("error_input");
            DomElements.errorStateNew = "";
            return true;
        } else {
            DomElements.errorStateNew = "Campo no válido";
            DomElements.stateNew.classList.add("error_input");
            return false;
        }
    }

    //Validación Prioridad
    function priorityValidation() {
        const validPriorities = ["0", "1", "2", "3", "4"];
        if (validPriorities.includes(DomElements.priorityNew.value)) {
            DomElements.priorityNew.classList.remove("error_input");
            return true;
        } else {
            DomElements.priorityNew.classList.add("error_input");
            return false;
        }
    }

    //Validación descripción
    function descValidation() {
        if (DomElements.descNew.value.length > 0 && DomElements.descNew.value.length < 500) {
            DomElements.descNew.classList.remove("error_input");
            DomElements.errorDescNew.textContent = "";
            return true;
        } else {
            DomElements.descNew.classList.add("error_input");
            DomElements.errorDescNew.textContent = "Descripción inválida";
            return false;
        }
    }

    //Validación Formulario
    function validationAll(e) {

        titleValidation();
        estimationValidation();
        stateValidation();
        priorityValidation();
        descValidation();

        if (
            !titleValidation() ||
            !estimationValidation() ||
            !stateValidation() ||
            !priorityValidation() ||
            !descValidation()
        ) {
            e.preventDefault();
        }
    }

    //Submit Formulario
    DomElements.newTaskForm.addEventListener("submit", (e) => {
        validationAll(e);
    });

    //Eventos validación
    DomElements.titleNew.addEventListener("blur", titleValidation);
    DomElements.estimationNew.addEventListener("blur", estimationValidation);
    DomElements.stateNew.addEventListener("blur", stateValidation);
    DomElements.priorityNew.addEventListener("blur", priorityValidation);
    DomElements.descNew.addEventListener("blur", descValidation);
});