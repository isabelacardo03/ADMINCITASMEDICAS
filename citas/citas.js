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
function listarCitas() {
    const div = document.getElementById("citasTabla");

    // Hacer petición básica al PHP
    fetch("../citas/listarCitas.php")
        .then(res => res.json()) // Convertir a JSON
        .then(data => {
            if (!data.ok) {
                div.innerHTML = "Error al cargar citas";
                return;
            }

            if (data.citas.length === 0) {
                div.innerHTML = "No hay citas";
                return;
            }

            // Construir tabla básica
            let html = "<table border='1'>";
            html += "<tr><th>ID</th><th>Médico</th><th>Fecha y Hora</th><th>Tipo</th><th>Estado</th><th>Acciones</th></tr>";

            data.citas.forEach(c => {
                html += `<tr>
                            <td>${c.id}</td>
                            <td>${c.medico}</td>
                            <td>${c.fechaHora}</td>
                            <td>${c.tipoCita}</td>
                            <td>${c.estado}</td>
                            <td>
                                <button onclick="modificarCita(${c.id}, '${c.medicoId}', '${c.fechaHora}', '${c.tipoCita}')">Modificar</button>
                                <button onclick="cancelarCita(${c.id})">Cancelar</button>
                            </td>
                         </tr>`;
            });

            html += "</table>";
            div.innerHTML = html;
        })
        .catch(error => {
            div.innerHTML = "Error al conectar con el servidor";
            console.error(error);
        });
}


let citaEditandoId = null;

// Cargar datos de una cita en el formulario para modificar
function modificarCita(id, medicoId, fechaHora, tipoCita) {
    citaEditandoId = id;
    document.getElementById('medicoId').value = medicoId;
    document.getElementById('fechaHora').value = fechaHora;
    document.getElementById('tipoCita').value = tipoCita;
    document.querySelector('#formCitas .botones button').innerText = "Actualizar";
}

// Función para actualizar cita
function actualizarCita() {
    if (!citaEditandoId) return;

    const medicoId = document.getElementById('medicoId').value.trim();
    const fechaHora = document.getElementById('fechaHora').value;
    const tipoCita = document.getElementById('tipoCita').value.trim();

    if (!medicoId || !fechaHora || !tipoCita) {
        alert("Todos los campos son obligatorios");
        return;
    }

    const datos = new FormData();
    datos.append("id", citaEditandoId);
    datos.append("idMedico", medicoId);
    datos.append("fechaHora", fechaHora);
    datos.append("tipoCita", tipoCita);

    fetch("../citas/modificarCita.php", { method: "POST", body: datos })
        .then(res => res.json())
        .then(res => {
            if (res.ok) {
                alert("Cita actualizada correctamente");
                listarCitas();       // Refresca tabla
                limpiarFormulario(); // Limpia formulario
                citaEditandoId = null;
            } else {
                alert(res.mensaje);
            }
        })
        .catch(err => {
            alert("Error al actualizar cita");
            console.error(err);
        });
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('medicoId').value = "";
    document.getElementById('fechaHora').value = "";
    document.getElementById('tipoCita').value = "";
    document.querySelector('#formCitas .botones button').innerText = "Guardar";
}
// Cancelar cita
function cancelarCita(id) {
    if (!confirm("Deseas cancelar la cita?")) return;
    const datos = new FormData();
    datos.append("id", id);

    fetch("../citas/eliminarCita.php", { method: "POST", body: datos })
        .then(res => res.json())
        .then(res => {
            if (res.ok) listarCitas();
            else alert(res.mensaje);
        });
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('idMedico').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('fechaHora').value = "";
    document.getElementById('tipoCita').value = "";
    document.querySelector('#formCitas .botones button').innerText = "Guardar";
}