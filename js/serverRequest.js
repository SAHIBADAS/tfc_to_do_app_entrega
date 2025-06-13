import { DomElements } from "./domElements.js";
//Settear proyecto iniciado
export function setCurrentProyect(idProyecto, nameProyecto) {
    const data = { id: idProyecto, nombre: nameProyecto };
    const options = {
        method: "post",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    }
    fetch("../api/setcurrentproyect.php", options).catch(error => {
        console.error("Fallo en el fetch", error);
    })
}

// Cambiamos de estado la tarea según en qué container caiga
export async function updateTaskState(taskDbId, newState) {

    const taskIndex = parseInt(taskDbId.replace("task-", ""), 10);
    const options = {
        method: "post",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: taskIndex, estado: newState }),
    }

    // Petición al backend para actualizar el estado en la BBDD
    fetch("../api/setstate.php", options).catch(error => {
        console.error("Hubo un error actualizando la tarea:", error);
    });

}

//Get Usuario Iniciado
export async function getCurrentUser() {
    return fetch("../api/getcurrentuser.php")
        .then(response => response.json())
        .then(data => {
            return data.idUsuario;
        })
        .catch(error => {
            console.error("Error al obtener el usuario actual", error);
            return null;
        });
}

//Get proyecto iniciado
export async function getCurrentProyect() {
    let currentProyectId;
    try {
        const response = await fetch("../api/getcurrentproyect.php");
        const data = await response.text(); // Asumiendo que la respuesta es texto
        currentProyectId = data;
    } catch (error) {
        console.error("Fallo en el fetch", error);
    }
    return currentProyectId;
}

//Cerrar sesion
export function closeSesion() {
    showLoader();
    fetch("../api/closesession.php").then(response => {
        return response.text();
    }).then(() => {
        window.location.href = '../views/login.php';
        hideLoader();
    }).catch(error => {
        console.error("Fallo en el fetch", error);
    })
}

//Fetching a un php
export function fetchData(url, callback) {
    fetch(url).then(response => {
        return response.text();
    }).then(data => {
        let arrData = JSON.parse(data);
        callback(arrData);
    }).catch(error => {
        console.error("Fallo en el fetch", error);
    })
}

//Borrar Colaborador
export function deleteCollab(collabId) {
    showLoader();
    const options = {
        method: "post",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: collabId }),
    }

    fetch("../api/deletecollab.php", options).then(response => {
        return response.text();
    }).then(() => {
        window.location.href = '../views/dashboard.php';
        hideLoader();
    })
}

//Borrar Colaborador
export function deleteProyect(proyectId) {
    showLoader();
    const options = {
        method: "post",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: proyectId }),
    }

    fetch("../api/deleteproyect.php", options).then(response => {
        return response.text();
    }).then(() => {
        window.location.href = '../views/dashboard.php';
        hideLoader();
    })
}

//Modal error
export function errorModal(message) {
    DomElements.modalMessageError.textContent = message;
    DomElements.modal2.showModal();
    DomElements.acceptBtn2.addEventListener("click", () => {
        DomElements.modal2.close();
    });
}

//Modal confirmacion
export function confirmationModal(message, actionToExecute) {
    DomElements.modalMessage.textContent = message;
    DomElements.modal.showModal();
    DomElements.acceptBtn.addEventListener("click", () => {
        DomElements.modal.close();
        actionToExecute();
    });
    DomElements.cancelBtn.onclick = function () {
        DomElements.modal.close();
    };
}

//Verificar si hay errores de sesion
export function checkAndShowErrorModal() {
    fetch('../api/error.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                errorModal(data.message); // Mostrar solo si hay un error
            }
        })
        .catch(err => {
            console.error('Error al verificar el error:', err);
        });
}


// Verificar si hay mensajes
export function checkAndShowSuccess() {
    fetch('../api/success.php')
        .then(response => response.json())
        .then(data => {
            // Verificamos que el campo 'success' existe y tiene contenido no vacío
            if (data && typeof data.success === 'string' && data.success.trim() !== '') {
                if (DomElements && DomElements.successDiv) {
                    DomElements.successDiv.style.display = "flex";
                    DomElements.successDiv.textContent = `✅ ${data.success} ✅`;

                    setTimeout(() => {
                        DomElements.successDiv.style.display = "none";
                    }, 4000);
                }
            }
        })
        .catch(err => {
            console.error('Error al verificar el mensaje de éxito:', err);
        });
}

//Rellenar campos formulario con tarea seleccionada
export function fillInputs(taskId) {
    fetch("../api/tasks.php").then(response => {
        return response.text();
    }).then(data => {
        let arrData = JSON.parse(data);
        for (let tarea of arrData) {
            if (tarea.id == taskId) {
                DomElements.titleEdit.value = tarea.titulo;
                DomElements.estimationEdit.value = tarea.estimacion;
                DomElements.stateEdit.value = tarea.estado;
                DomElements.priorityEdit.value = tarea.prioridad;
                DomElements.descEdit.value = tarea.descripcion;
                DomElements.idEdit.value = tarea.id;
                DomElements.colorEdit.value = tarea.color_agenciado;
                DomElements.asigEdit.value = tarea.idUsuarioAsignado;
            }
        }
    }).catch(error => {
        console.error("Fallo en el fetch", error);
    })
}

export function showLoader() {
    DomElements.loader.style.display = 'block';
}

export function hideLoader() {
    DomElements.loader.style.display = 'none';
}

//Inactividad
export function iniciarDetectorInactividad() {
    let temporizador;

    const reiniciarTemporizador = () => {
        clearTimeout(temporizador);
        temporizador = setTimeout(closeSesion, 600000);
    };

    // Eventos que reinician el temporizador
    const eventos = ['mousemove', 'keydown', 'scroll', 'touchstart'];

    eventos.forEach(evento => {
        window.addEventListener(evento, reiniciarTemporizador);
    });

    reiniciarTemporizador();
}

