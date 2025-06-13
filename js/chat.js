import { DomElements } from "./domElements.js";
import { getCurrentUser, fetchData, confirmationModal } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {

    let lastFechedMessageId = null;

    DomElements.formchat.addEventListener("submit", (e) => {
        e.preventDefault();
        sendMessage();
    });

    //Enviar mensajes
    function sendMessage() {
        const data = { contenido: chatcontent.value };
        const options = {
            method: "post",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        }
        fetch("../api/newmessage.php", options).then(response => {
            return response.text();
        }).then(data => {
            console.log(data);
            getCurrentUser().then(currentUserId => {
                if (currentUserId !== null) {
                    updateChat(currentUserId);
                }
            });
        }).catch(error => {
            console.error("Fallo en el fetch", error);
        })

        DomElements.chatcontent.value = "";
    }

    //Renderizar Mensajes
    function printMessage(mensaje, currentUserId) {

        const divMessage = document.createElement("div");
        const div1Message = document.createElement("div");
        const div2Message = document.createElement("div");
        const imgMessage = document.createElement("img");
        const sectionContent = document.createElement("section");

        imgMessage.src = mensaje.avatar;
        imgMessage.alt = "Miniatura imagen de usuario para mensaje de chat";
        sectionContent.textContent = mensaje.contenido;

        sectionContent.classList.add("message-card-section-content");

        if (mensaje.idUsuario == currentUserId) {
            divMessage.classList.add("message-card-article");
            div2Message.classList.add("message-card-main");
        } else {
            divMessage.classList.add("message-card-article-2");
            div2Message.classList.add("message-card-main-2");
        }

        div1Message.classList.add("message-card-aside");
        div1Message.appendChild(imgMessage);
        div2Message.appendChild(sectionContent);
        divMessage.appendChild(div1Message);
        divMessage.appendChild(div2Message);

        return divMessage;
    }

    //Renderizar Chat
    function renderChat(arrMesagges, currentUserId) {
        DomElements.chatdiv.textContent = "";
        if (arrMesagges.length > 0 && DomElements.chatdiv) {
            for (let mensaje of arrMesagges) {
                let newMessage = printMessage(mensaje, currentUserId);
                DomElements.chatdiv.appendChild(newMessage);
            }

            requestAnimationFrame(() => {
                DomElements.chatdiv.scrollTop = DomElements.chatdiv.scrollHeight;
            });
        }
    }

    // Función para obtener los mensajes
    async function fetchMessages() {
        return fetch("../api/messages.php")
            .then(async response => {
                const text = await response.text();
                if (!text) return []; // Si no hay contenido, retorna array vacío
                try {
                    return JSON.parse(text); // Intenta parsear como JSON
                } catch (e) {
                    console.error("Respuesta no es JSON válido:", text);
                    return [];
                }
            })
            .catch(error => {
                console.error("Error al obtener los mensajes", error);
                return [];
            });
    }


    // Función para actualizar el chat
    function updateChat(currentUserId) {
        fetchMessages()
            .then(arrMessages => {
                if (arrMessages.length > 0) {
                    const lastMessage = arrMessages[arrMessages.length - 1];
                    if (lastMessage.id !== lastFechedMessageId) {
                        renderChat(arrMessages, currentUserId);
                    }
                    lastFechedMessageId = lastMessage.id;
                }
            });
    }

    // Función principal que obtiene el id del usuario y empieza la actualización
    function startChat() {
        getCurrentUser().then(currentUserId => {
            if (currentUserId !== null) {
                updateChat(currentUserId);
                setInterval(() => updateChat(currentUserId), 5000);
            } else {
                console.log("No se pudo obtener el idUsuario");
            }
        });
    }


    DomElements.clearChat.addEventListener("click", () => {
        confirmationModal("¿Seguro que quieres vaciar este chat?", () => {
            fetch("../api/deletemessages.php").then(response => {
                return response.text();
            }).then(() => {
                window.location.reload();
            }).catch(error => {
                console.error("Fallo en el fetch", error);
            })
        })
    })

    startChat();


});