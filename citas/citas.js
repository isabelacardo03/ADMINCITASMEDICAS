document.addEventListener('DOMContentLoaded', () => {       
    listarCitas();  
});





function guardarCita() {

    const paciente = document.getElementById('paciente').value;
    const medico   = document.getElementById('medico').value;
    const fecha    = document.getElementById('fecha').value;
    const hora     = document.getElementById('hora').value;

    const datos = new FormData();

    datos.append("tipo", "cita");
    datos.append("paciente", paciente);
    datos.append("medico", medico);
    datos.append("fecha", fecha);
    datos.append("hora", hora);

    fetch("guardarCita.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(resultado => {

        if (resultado.ok) {
            listarCitas();
        } else {
            alert(resultado.mensaje);
        }

    })
    .catch(error => {
        alert("Error al guardar");
    });
}


function listarCitas(){

    const tabla = document.getElementById("tablaCitas");

    if (!tabla) return;

    tabla.innerHTML = "Cargando...";

    fetch("listarCitas.php?tipo=cita")
    .then(res => res.json())
    .then(resultado => {

        if (!resultado.ok) {
            tabla.innerHTML = "Error";
            return;
        }

        let html = `
        <table>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acción</th>
            </tr>
        `;

        for (const c of resultado.citas) {
            html += `
            <tr>
                <td>${c.id}</td>
                <td>${c.paciente}</td>
                <td>${c.medico}</td>
                <td>${c.fecha}</td>
                <td>${c.hora}</td>
                <td>
                    <button class="botones-tablas" onclick="eliminarCita(${c.id})">
                        Cancelar
                    </button>
                </td>

                <td>
                    <button class="botones-tablas" onclick="modificarCita(${c.id})">
                        Modificar
                    </button>
                </td>
            </tr>
            `;
        }

        html += `</table>`;
        tabla.innerHTML = html;

    })
    .catch(error => {
        tabla.innerHTML = "Error del servidor";
    });
}


function eliminarCita(id) {

    if (!confirm("¿Cancelar cita?")) return;

    const datos = new FormData();
    datos.append("id", id);

    fetch("eliminarCita.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(resultado => {

        if (resultado.ok) {
            listarCitas();
        } else {
            alert(resultado.mensaje);
        }

    })
    .catch(error => {
        alert("Error");
    });
}

async function consultarCitas() {
    const paciente = document.getElementById('filtroPaciente').value.trim();
    const medico   = document.getElementById('filtroMedico').value.trim();
    const fecha    = document.getElementById('filtroFecha').value;

    const tabla = document.getElementById('tablaCitas');
    tabla.innerHTML = "Buscando...";

    // Construir parámetros GET dinámicamente
    let params = new URLSearchParams({ tipo: "cita" });
    if (paciente) params.append("paciente", paciente);
    if (medico) params.append("medico", medico);
    if (fecha) params.append("fecha", fecha);

    try {
        const res = await fetch("listarCitas.php?" + params.toString());
        const data = await res.json();

        if (!data.ok) return tabla.innerHTML = `<p>Error: ${data.mensaje}</p>`;
        if (data.citas.length === 0) return tabla.innerHTML = "<p>No se encontraron citas</p>";

        let html = `<table>
            <thead>
                <tr>
                    <th>ID</th><th>Paciente</th><th>Médico</th>
                    <th>Fecha</th><th>Hora</th><th>Acción</th>
                </tr>
            </thead><tbody>`;

        for (const c of data.citas) {
            html += `<tr id="filaCita-${c.id}">
                        <td>${c.id}</td>
                        <td>${c.paciente}</td>
                        <td>${c.medico}</td>
                        <td>${c.fecha}</td>
                        <td>${c.hora}</td>
                        <td>
                            <button onclick="modificarCita(${c.id})">Modificar</button>
                            <button onclick="eliminarCita(${c.id})">Cancelar</button>
                        </td>
                    </tr>`;
        }

        html += `</tbody></table>`;
        tabla.innerHTML = html;

    } catch (err) {
        tabla.innerHTML = "Error del servidor";
        console.error(err);
    }
}

let citaEditandoId = null; // ID de la cita que estamos editando

// Preparar formulario para modificar cita (solo fecha y hora)
function modificarCita(id) {
    const fila = document.getElementById(`filaCita-${id}`);
    if (!fila) return;

    const cells = fila.getElementsByTagName('td');

    // Copiamos fecha y hora de la fila al formulario
    document.getElementById('fecha').value = cells[3].innerText;
    document.getElementById('hora').value   = cells[4].innerText;

    citaEditandoId = id; // Guardamos el ID para enviar al PHP

    // Cambiamos el texto del botón para que quede claro que es actualización
    document.querySelector('#formCitas .botones button').innerText = "Actualizar";
}


function actualizarCita() {
    const paciente = document.getElementById('paciente').value;
    const medico   = document.getElementById('medico').value;
    const fecha    = document.getElementById('fecha').value;
    const hora     = document.getElementById('hora').value;

    const datos = new FormData();
    datos.append("id", citaEditandoId);
    datos.append("paciente", paciente);
    datos.append("medico", medico);
    datos.append("fecha", fecha);
    datos.append("hora", hora);

    fetch("modificarCita.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(resultado => {
        if (resultado.ok) {
            listarCitas(); // refresca la lista
            citaEditandoId = null; // resetea edición
            document.getElementById("paciente").value = "";
            document.getElementById("medico").value = "";
            document.getElementById("fecha").value = "";
            document.getElementById("hora").value = "";
        } else {
            alert(resultado.mensaje);
        }
    })
    .catch(error => alert("Error al actualizar"));
}