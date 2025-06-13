import { DomElements } from "./domElements.js";
import { checkAndShowSuccess, checkAndShowErrorModal } from "../js/serverRequest.js"
document.addEventListener("DOMContentLoaded", () => {
    function validateName() {
        let isOk = /^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50}$/.test(DomElements.indexNombre.value.trim()) && DomElements.indexNombre.value.trim() !== '';
        if (isOk) {
            DomElements.indexNombre.classList.remove("error_input");
            DomElements.indexErrorNombre.textContent = "";
        } else {
            DomElements.indexNombre.classList.add("error_input");
            DomElements.indexErrorNombre.textContent = "Nombre no válido o vacío";
        }
        return isOk;
    }

    function validateEmail() {
        let isOk = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(DomElements.indexEmail.value.trim());
        if (isOk) {
            DomElements.indexEmail.classList.remove("error_input");
            DomElements.indexErrorEmail.textContent = "";
        } else {
            DomElements.indexEmail.classList.add("error_input");
            DomElements.indexErrorEmail.textContent = "Por favor, introduce un email válido";
        }
        return isOk;
    }

    function validateMessage() {
        if (DomElements.indexMensaje.value.length > 0 && DomElements.indexMensaje.value.length < 500) {
            DomElements.indexMensaje.classList.remove("error_input");
            DomElements.indexErrorMensaje.textContent = "";
            return true;
        } else {
            DomElements.indexMensaje.classList.add("error_input");
            DomElements.indexErrorMensaje.textContent = "Mensaje inválido o vacío.";
            return false;
        }
    }

    function validateAll(e) {
        validateName();
        validateEmail();
        validateMessage();

        if(
            !validateName() ||
            !validateEmail() ||
            !validateMessage()
        ){
            e.preventDefault();
        }
    }

    const form = document.forms[0];

    DomElements.indexNombre.addEventListener("blur",validateName);
    DomElements.indexEmail.addEventListener("blur",validateEmail);
    DomElements.indexMensaje.addEventListener("blur",validateMessage);
    
    DomElements.heroBtn.addEventListener("click",()=>{
        window.location.href='dashboard.php';
    });

    form.addEventListener("submit", validateAll);
    checkAndShowSuccess();
    checkAndShowErrorModal();
})