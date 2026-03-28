document.addEventListener('DOMContentLoaded', () => {
    listarCitas();
});



// Traer nombre de médico automáticamente
document.getElementById('medicoId').addEventListener('blur', () => {
    const id = document.getElementById('medicoId').value.trim();
    if (!id) return;
    fetch("../citas/traerMedico.php?idMedico=" + id)
        .then(res => res.json())
        .then(data => {
            document.getElementById('medicoNombre').value = data.nombre || "";
        });
});

// Guardar nueva cita
function guardarCita() {
    const medicoId = document.getElementById('idMedico').value.trim();
    const fechaHora = document.getElementById('fechaHora').value;
    const tipoCita = document.getElementById('tipoCita').value.trim();

    if (!medicoId || !fechaHora || !tipoCita) {
        alert("Todos los campos son obligatorios");
        return;
    }

    const datos = new FormData();
    datos.append("idMedico", medicoId);
    datos.append("fechaHora", fechaHora);
    datos.append("tipoCita", tipoCita);

    fetch("../citas/guardarCita.php", { method: "POST", body: datos })
        .then(res => res.json())
        .then(res => {
            if (res.ok) {
                listarCitas();
                limpiarFormulario();
            } else alert(res.mensaje);
        });
}

// Listar citas
async function listarCitas() {
    const div = document.getElementById("citasTabla");
    div.innerHTML = '<p>Cargando citas...</p>';

    try {
        const respuesta = await fetch("../citas/listarCitas.php");
        const data = await respuesta.json();

        if (!data.ok) {
            div.innerHTML = `<p>Error: ${data.mensaje}</p>`;
            return;
        }

        if (data.citas.length === 0) {
            div.innerHTML = '<p>No hay citas</p>';
            return;
        }

        let html = `
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Médico</th>
                    <th>Fecha y Hora</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
        `;

        for (const c of data.citas) {
            html += `
                <tr id="fila-${c.id}">
                    <td>${c.id}</td>
                    <td>${c.medico}</td>
                    <td>${c.fechaHora}</td>
                    <td>${c.tipoCita}</td>
                    <td>${c.estado}</td>
                    <td class="botones">
                        <button onclick="eliminarCita(${c.id})">Cancelar</button>
                        <button onclick="modificarCita(${c.id})">Modificar</button>
                    </td>
                </tr>
            `;
        }

        html += `</tbody></table>`;
        div.innerHTML = html;

    } catch (error) {
        div.innerHTML = '<p>Error al conectar con el servidor</p>';
        console.error(error);
    }
}


function modificarCita(idCita) {
    window.location.href = `../citas/modificarCita.php?id=${idCita}`;
}


async function eliminarCita(idCita) {
    if (!confirm("Deseas cancelar la cita?"+idCita)) return;

    const fila = document.getElementById(`fila-${idCita}`);
    if (fila) fila.style.opacity = '0.4';

    try {
        const datos = new FormData();
        datos.append("id", idCita);

        const respuesta = await fetch("../citas/eliminarCita.php", {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.ok) {
            listarCitas();
        } else {
            alert("Error: " + resultado.mensaje);
            if (fila) fila.style.opacity = '1';
        }

    } catch (error) {
        alert("Error del servidor");
        if (fila) fila.style.opacity = '1';
        console.error(error);
    }
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('idMedico').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('fechaHora').value = "";
    document.getElementById('tipoCita').value = "";
    document.querySelector('#formCitas .botones button').innerText = "Guardar";
}