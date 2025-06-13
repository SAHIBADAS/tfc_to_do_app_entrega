import { DomElements } from "./domElements.js";
import { confirmationModal } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {

    // Validación Nombre
    function nameValidation() {
        let isOk = /^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50}$/.test(DomElements.editUserName.value.trim()) && DomElements.editUserName.value.trim() !== '';
        if (isOk) {
            DomElements.editUserName.classList.remove("error_input");
            DomElements.errornameUser.textContent = "";
        } else {
            DomElements.editUserName.classList.add("error_input");
            DomElements.errornameUser.textContent = "Nombre no válido o vacío";
        }
        return isOk;
    }

    // Validación Apellidos
    function lastnameValidation() {
        let isOk = /^[A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50}( [A-Za-zÁÉÍÓÚÑáéíóúñ]{2,50})?$/.test(DomElements.editUserLastName.value.trim()) && DomElements.editUserLastName.value.trim() !== '';
        if (isOk) {
            DomElements.editUserLastName.classList.remove("error_input");
            DomElements.errorlastnameUser.textContent = "";
        } else {
            DomElements.editUserLastName.classList.add("error_input");
            DomElements.errorlastnameUser.textContent = "Apellidos no válidos o vacíos";
        }
        return isOk;
    }

    // Validación de la imagen de perfil (solo JPG o JPEG)
    function fotoValidation() {
        let isOk = true;
        const file = DomElements.editUserFoto.files[0];
        if (file) {
            const allowedExtensions = ['image/jpeg', 'image/jpg'];
            const fileType = file.type;
            if (!allowedExtensions.includes(fileType)) {
                isOk = false;
                DomElements.editUserFoto.classList.add("error_input");
                DomElements.errorfotoUser.textContent = "Formato inválido";
            } else {
                DomElements.editUserFoto.classList.remove("error_input");
                DomElements.errorfotoUser.textContent = "";
            }
        }
        return isOk;
    }

    // Validación del formulario
    function validationAll(e) {

        e.preventDefault();

        // Realizar validaciones
        nameValidation();
        lastnameValidation();
        fotoValidation();

        if (
            nameValidation() &&
            lastnameValidation()
        ){
            confirmationModal("¿Seguro que quieres guardar los cambios?", () => {
                DomElements.editUserForm.submit();
            });
        }
    }

    // Eventos de validación al perder foco (blur)
    DomElements.editUserName.addEventListener("blur", nameValidation);
    DomElements.editUserLastName.addEventListener("blur", lastnameValidation);
    DomElements.editUserFoto.addEventListener("blur", fotoValidation);

    // Subir el formulario
    DomElements.editUserForm.addEventListener("submit", validationAll);
    
});
