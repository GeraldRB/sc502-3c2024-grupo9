let hijosContador = 1;

function agregarHijo() {
    hijosContador++;

    const contenedor = document.getElementById("hijos-contenedor");

    const nuevoHijo = document.createElement("div");
    nuevoHijo.classList.add("mb-3", "hijo-entry");

    nuevoHijo.innerHTML = `
        <label for="nombreHijo${hijosContador}" class="form-label">Hijo ${hijosContador}</label>
        <input type="text" class="form-control mb-2" id="nombreHijo${hijosContador}" name="nombreHijo${hijosContador}" placeholder="Primer nombre">

        <label for="fechaNacimiento${hijosContador}" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="fechaNacimiento${hijosContador}" name="fechaNacimiento${hijosContador}" required>
    `;

    contenedor.appendChild(nuevoHijo);
}
