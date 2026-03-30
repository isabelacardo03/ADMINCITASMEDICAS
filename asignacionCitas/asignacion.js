document.addEventListener("DOMContentLoaded", () => {
    cargarCitas("");
});


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
        tabla.innerHTML = "<tr><td>No hay citas disponibles</td></tr>";
        return;
    }

    let html = "";

    for (let c of data.citas) {
        html += `
            <tr>
                <td>${c.id}</td>
                <td>${c.fechaHora}</td>
                <td >
                    <button onclick="asignar(${c.id})">Asignar</button>
                </td>
            </tr>
        `;
    }

    tabla.innerHTML = html;
}


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

async function cargarMedicos() {
    const select = document.getElementById("selectMedico");

    try {
        const res = await fetch("../medicos/listarMedicocombo.php");
        const datos = await res.json();

        select.innerHTML = '';

         datos.medicos.forEach(medico => {
            select.innerHTML += `
                <option value="${medico.idMedico}">
                    ${medico.nombre}
                </option>
            `;
        });

        // 🔥 Selecciona automáticamente el primero
        if (datos.length > 0) {
            select.value = datos[0].idMedico;
        }

    } catch (error) {
        console.error("Error cargando médicos:", error);
    }
}

async function cargarAgendas() {
    const idMedico = document.getElementById("selectMedico").value;
    const selectAgenda = document.getElementById("selectAgenda");

    if (!idMedico) {
        selectAgenda.innerHTML = '<option value="">Seleccione agenda</option>';
        return;
    }

    try {
        const res = await fetch(`../citas/listarAgendas.php?idMedico=${idMedico}`);
        const datos = await res.json();

        selectAgenda.innerHTML = '<option value="">Seleccione agenda</option>';

        datos.agendas.forEach(agenda => {
            selectAgenda.innerHTML += `
                <option value="${agenda.idCita}">
                    ${agenda.fechaHora}
                </option>
            `;
        });

    } catch (error) {
        console.error("Error cargando agendas:", error);
    }
}
// =====================
// LIMPIAR
// =====================
function limpiar() {
    document.getElementById("buscarPaciente").value = "";
    cargarCitas("");
}

document.addEventListener("DOMContentLoaded", async () => {
    await cargarMedicos();
    cargarAgendas(); 
});