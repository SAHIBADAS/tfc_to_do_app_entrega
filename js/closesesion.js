import { closeSesion , iniciarDetectorInactividad} from "./serverRequest.js";
import { DomElements } from "./domElements.js";

document.addEventListener("DOMContentLoaded", () => {
    if (DomElements.closebutton) {
        DomElements.closebutton.addEventListener("click", closeSesion);
    }

    iniciarDetectorInactividad();
});

