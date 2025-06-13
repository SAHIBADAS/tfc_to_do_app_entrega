import { DomElements } from "./domElements.js";
import { checkAndShowErrorModal, checkAndShowSuccess } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {
    const myForm = document.forms[0];

    async function verifyAll(e) {
        e.preventDefault(); // Prevenir el envío por defecto

        const isValid = await verifyLogEmail();

        if (isValid !== "1") {
            // Si NO es válido
            DomElements.emailLogin.classList.add("error_input");
            DomElements.passwordLogin.classList.add("error_input");
            DomElements.erroremailLog.textContent = "Error de autenticación ❌";
        } else {
            // Si es válido
            DomElements.emailLogin.classList.remove("error_input");
            DomElements.passwordLogin.classList.remove("error_input");
            DomElements.erroremailLog.textContent = "";

            myForm.submit(); // Envía el formulario manualmente si es válido
        }
    }

    async function verifyLogEmail() {
        const data = {
            email: DomElements.emailLogin.value.trim(),
            password: DomElements.passwordLogin.value.trim()
        };

        const options = {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(data),
        };

        try {
            const response = await fetch("../api/authverify.php", options);
            const text = await response.text(); // "0" o "1"
            return text.trim(); // Retorna "0" o "1"
        } catch (error) {
            console.error("Error en el fetch", error);
            return "0"; // Asume inválido si hay error
        }
    }

    myForm.addEventListener("submit", verifyAll);
    
    DomElements.redir1.addEventListener("click",()=>{
        window.location.href = "../views/registro.php";
    })

    checkAndShowErrorModal();
    checkAndShowSuccess();
});
