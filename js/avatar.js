//Creación de color aleatorio
function generarColorAleatorio() {
    const letras = "0123456789ABC"; // Evitamos valores altos (D-F) para evitar colores claros
    let color = "#";
    for (let i = 0; i < 6; i++) {
        color += letras[Math.floor(Math.random() * letras.length)];
    }
    return color;
}

//Función para generar avatar de usuario
function generarImagenInicial(nombre) {
    const inicial = nombre.charAt(0).toUpperCase();
    const canvas = document.createElement("canvas");
    canvas.width = 100;
    canvas.height = 100;
    const ctx = canvas.getContext("2d");

    // Fondo con color aleatorio
    ctx.fillStyle = generarColorAleatorio();
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Establecer fuente más fina
    ctx.font = "normal 50px Arial";
    ctx.fillStyle = "#FFF";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";

    // Calcular la posición centrada y desplazar 10px hacia abajo
    const x = canvas.width / 2;
    const y = canvas.height / 2 + 5;

    ctx.fillText(inicial, x, y);

    return canvas.toDataURL("image/png");
}

// Función para enviar la imagen al servidor
export function enviarImagen(nombre, email) {
    const imagenBase64 = generarImagenInicial(nombre);

    fetch("../api/saveimagen.php", {
        method: "POST",
        body: JSON.stringify({ imagen: imagenBase64, email: email }),
        headers: { "Content-Type": "application/json" }
    })
        .catch(error => console.error("Error:", error));
}