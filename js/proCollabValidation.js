import { DomElements } from "./domElements.js";
document.addEventListener("DOMContentLoaded",()=>{
    function validateName(){
        const input = DomElements.newProName;
        const span = DomElements.newProError; 
        if(input.value.trim().length < 1 || input.value.trim().length > 20){
            input.classList.add("error_input");
            span.textContent="Título no válido o vacío";
            return false;
        }else{
            input.classList.remove("error_input");
            span.textContent="Título no válido o vacío";
            return true;
        }
    }

    function validateEmail() {
        let isOk = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(DomElements.newCollabEmail.value.trim());
        if (isOk) {
            DomElements.newCollabEmail.classList.remove("error_input");
            DomElements.newCollabEmailError.textContent = "";
        } else {
            DomElements.newCollabEmail.classList.add("error_input");
            DomElements.newCollabEmailError.textContent = "Por favor, introduce un email válido";
        }
        return isOk;
    }

    DomElements.newProForm.addEventListener("submit",(e)=>{
        validateName();
        if(!validateName()){
            e.preventDefault();
        }
    })

    DomElements.newCollabForm.addEventListener("submit",(e)=>{
        validateEmail();
        if(!validateEmail()){
            e.preventDefault();
        }
    })

})