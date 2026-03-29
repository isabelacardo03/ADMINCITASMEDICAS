document.addEventListener("DOMContentLoaded", () => {
    cargarCitas("");
});

// =====================
// CARGAR CITAS ASIGNADAS
// =====================
async function cargarCitas(estado = "") {

    const tabla = document.getElementById("tablaCitas");
    tabla.innerHTML = "<tr><td colspan='5'>Cargando...</td></tr>";

    let url = `../asignacionCitas/consulta.php`;
    if (estado !== "") {
        url += `?estado=${estado}`;
    }

    const respuesta = await fetch(url);
    const data = await respuesta.json();

    if (!data.ok || data.datos.length === 0) {
        tabla.innerHTML = "<tr><td colspan='5'>No hay registros</td></tr>";
        return;
    }

    let html = "";

    for (let a of data.datos) {
        html += `
            <tr>
                <td>${a.id}</td>
                <td>${a.idCita}</td>
                <td>${a.identiPaciente}</td>
                <td>${a.nombrePaciente}</td>
                <td>${a.estado}</td>
            </tr>
        `;
    }

    tabla.innerHTML = html;
}


// =====================
// BUSCAR CITAS DISPONIBLES
// =====================
async function buscar() {

    const idPaciente = document.getElementById("buscarPaciente").value;

    if (idPaciente === "") {
        alert("Ingrese ID paciente");
        return;
    }

    const tabla = document.getElementById("tablaCitas");
    tabla.innerHTML = "<tr><td colspan='5'>Buscando citas...</td></tr>";

    const respuesta = await fetch(`../asignacionCitas/obtenerCitas.php`);
    const data = await respuesta.json();


    if (!data.ok || data.citas.length === 0) {
        tabla.innerHTML = "<tr><td colspan='5'>No hay citas disponibles</td></tr>";
        return;
    }

    let html = "";

    for (let c of data.citas) {
        html += `
            <tr>
                <td>${c.id}</td>
                <td>${c.fechaHora}</td>
                <td colspan="2">
                    <button onclick="asignar(${c.id})">Asignar</button>
                </td>
            </tr>
        `;
    }

    tabla.innerHTML = html;
}



// =====================
// ASIGNAR CITA
// =====================
async function asignar(idCita) {
    const idPaciente = document.getElementById("buscarPaciente").value;
    const estado = document.getElementById("estadoCita").value;

    if (idPaciente === "") {
        alert("Ingrese ID paciente");
        return;
    }

    if (estado === "") {
        alert("Seleccione un estado (Confirmada o Cancelada)");
        return;
    }

    // Llamada al PHP con idPaciente, idCita y estado
    await fetch(`../asignacionCitas/guardarAsignacion.php?idPaciente=${idPaciente}&idCita=${idCita}&estado=${estado}`);

    alert("Cita asignada");
    cargarCitas("");
}

// =====================
// LIMPIAR
// =====================
function limpiar() {
    document.getElementById("buscarPaciente").value = "";
    cargarCitas("");
}