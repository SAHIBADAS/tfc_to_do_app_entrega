import { DomElements } from "./domElements.js";
import { enviarImagen } from "./avatar.js";
import {checkAndShowErrorModal, checkAndShowSuccess } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {

    //Validación Nombre
    function nameValidation() {
        let isOk = /^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50}$/.test(DomElements.nameReg.value.trim()) && DomElements.nameReg.value.trim() !== '';
        if (isOk) {
            DomElements.nameReg.classList.remove("error_input");
            DomElements.errornameReg.textContent = "";
        } else {
            DomElements.nameReg.classList.add("error_input");
            DomElements.errornameReg.textContent = "Nombre no válido o vacío";
        }
        return isOk;
    }

    //Validación Apellidos
    function lastnameValidation() {
        let isOk = /^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50}( [A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50})?$/.test(DomElements.lastnameReg.value.trim()) && DomElements.lastnameReg.value.trim() !== '';
        if (isOk) {
            DomElements.lastnameReg.classList.remove("error_input");
            DomElements.errorlastnameReg.textContent = "";
        } else {
            DomElements.lastnameReg.classList.add("error_input");
            DomElements.errorlastnameReg.textContent = "Apellidos no válidos o vacíos";
        }
        return isOk;
    }

    //Validación email
    function emailValidation() {
        let isOk = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(DomElements.emailReg.value.trim());
        if (isOk) {
            DomElements.emailReg.classList.remove("error_input");
            DomElements.erroremailReg.textContent = "";
        } else {
            DomElements.emailReg.classList.add("error_input");
            DomElements.erroremailReg.textContent = "Por favor, introduce un email válido";
        }
        return isOk;
    }

    //Validación contraseña
    function passwordValidation() {
        if(
            DomElements.passwordReg.value.trim().length>8 &&
            /[A-Z]/.test(DomElements.passwordReg.value.trim()) &&
            /[a-z]/.test(DomElements.passwordReg.value.trim()) &&
            /[0-9]/.test(DomElements.passwordReg.value.trim()) &&
            /[$%&·#@|]/.test(DomElements.passwordReg.value.trim())
        ){
            DomElements.passwordReg.classList.remove("error_input");
            DomElements.errorpassReg.textContent="";
            console.log("okpass1");
            return true;
        }else{
            DomElements.passwordReg.classList.add("error_input");
            DomElements.errorpassReg.textContent="La contraseña no es segura ❌";
            return false;
        }
    }

    //Confirmación contraseña
    function confirm_passwordValidation() {
        if (DomElements.passwordReg.value.trim() == DomElements.confirmPasswordReg.value.trim()) {
            DomElements.confirmPasswordReg.classList.remove("error_input");
            DomElements.passwordReg.classList.remove("error_input");
            DomElements.errorpass2Reg.textContent = "";
            return true;
        } else {
            DomElements.confirmPasswordReg.classList.add("error_input");
            DomElements.passwordReg.classList.add("error_input");
            DomElements.errorpass2Reg.textContent = "Las contraseñas no coinciden";
            return false;
        }
    }

    //Validación Formulario
    function validationAll(e) {
        nameValidation();
        lastnameValidation();
        emailValidation();
        passwordValidation();
        confirm_passwordValidation();

        if (
            !nameValidation() ||
            !lastnameValidation() ||
            !emailValidation() ||
            !passwordValidation() ||
            !confirm_passwordValidation()
        ) {
            e.preventDefault();
        } else {
            
            enviarImagen(DomElements.nameReg.value, DomElements.emailReg.value);
        }
    }

    //Eventos validación
    DomElements.nameReg.addEventListener("blur", nameValidation);
    DomElements.lastnameReg.addEventListener("blur", lastnameValidation);
    DomElements.emailReg.addEventListener("blur", emailValidation);
    DomElements.passwordReg.addEventListener("blur", passwordValidation);
    DomElements.confirmPasswordReg.addEventListener("blur", confirm_passwordValidation);

    DomElements.redir2.addEventListener("click",()=>{
        window.location.href = "../views/login.php";
    })

    //Submit Formulario
    const myForm = document.forms[0];
    myForm.addEventListener("submit", validationAll);

    checkAndShowErrorModal();
    checkAndShowSuccess();

});