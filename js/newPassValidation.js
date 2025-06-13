import { DomElements } from "./domElements.js";

document.addEventListener("DOMContentLoaded", () => {

    //Validación contraseña
    function newpasswordValidation() {
        if (
            DomElements.newpass.value.trim().length > 8 &&
            /[A-Z]/.test(DomElements.newpass.value.trim()) &&
            /[a-z]/.test(DomElements.newpass.value.trim()) &&
            /[0-9]/.test(DomElements.newpass.value.trim()) &&
            /[$%&·#@|]/.test(DomElements.newpass.value.trim()) &&
            /[A-Z]/.test(DomElements.newpass.value.trim())
        ) {
            DomElements.newpass.classList.remove("error_input");
            DomElements.newpassError.textContent = "";
            return true;
        } else {
            DomElements.newpass.classList.add("error_input");
            DomElements.newpassError.textContent = "La contraseña no es segura ❌";
            return false;
        }
    }

    //Confirmación contraseña
    function confirm_newpasswordValidation() {
        if (DomElements.newpass.value.trim() == DomElements.newpass2.value.trim()) {
            DomElements.newpass2.classList.remove("error_input");
            DomElements.newpass.classList.remove("error_input");
            DomElements.newpassError2.textContent = "";
            return true;
        } else {
            DomElements.newpass2.classList.add("error_input");
            DomElements.newpass.classList.add("error_input");
            DomElements.newpassError2.textContent = "Las contraseñas no coinciden";
            return false;
        }
    }

    //Validación Formulario
    function newvalidationAll(e) {

        newpasswordValidation();
        confirm_newpasswordValidation();

        if (
            !newpasswordValidation() ||
            !confirm_newpasswordValidation()
        ) {
            e.preventDefault();
        }
    }

    DomElements.newpass.addEventListener("blur",newpasswordValidation);
    DomElements.newpass2.addEventListener("blur",confirm_newpasswordValidation);
    
    DomElements.cancelBtnModal.addEventListener("click",()=>{
        DomElements.passModal.close();
    });

    DomElements.newpassForm.addEventListener("submit",newvalidationAll);
});