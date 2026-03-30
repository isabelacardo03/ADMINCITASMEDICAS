document.addEventListener('DOMContentLoaded', () => {
    listar();
});

async function listar() {
    const tabla = document.getElementById('tablaPacientes');

    tabla.innerHTML = '<p>No hay pacientes...</p>';

    try {
        const respuesta = await fetch("../pacientes/listar.php?tipo=paciente");
        const resultado = await respuesta.json();

        if (!resultado.ok) {
            tabla.innerHTML = `<p>Error: ${resultado.mensaje}</p>`;
            return;
        }

        if (resultado.pacientes.length === 0) {
            tabla.innerHTML = '<p>No hay pacientes registrados</p>';
            return;
        }

        let html = `
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
        `;

        for (const p of resultado.pacientes) {
            html += `
                <tr id="fila-${p.idPaciente}">
                    <td>${p.idPaciente}</td>
                    <td>${p.nombre}</td>
                    <td>${p.apellido}</td>
                    <td>${p.telefono}</td>
                    <td>${p.estado}</td>
                    <td class="boton">
                        <button class="btn-eliminar" onclick="eliminar('${p.idPaciente}')">
                            Eliminar
                        </button>
                        <button class="btn-modificar" onclick="modificarPaciente('${p.idPaciente}')">
                            modificar
                        </button>
                    </td>
                </tr>
            `;
        }

        html += `</tbody></table>`;
        tabla.innerHTML = html;

    } catch (error) {
        alert("Error: " + error.message);
        console.error(error);
    }
}

async function eliminar(identificacion) {

    if (!confirm(`¿Eliminar paciente ${identificacion}?`)) return;

    const fila = document.getElementById(`fila-${identificacion}`);
    if (fila) fila.style.opacity = '0.4';

    try {
        const datos = new FormData();
        datos.append("tipo", "paciente");
        datos.append('idPaciente', identificacion);

        const respuesta = await fetch("../pacientes/eliminar.php", {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.ok) {
            listar();
        } else {
            alert("Error: " + resultado.mensaje);
            if (fila) fila.style.opacity = '1';
        }

    } catch (error) {
        alert("Error del servidor");
        if (fila) fila.style.opacity = '1';
    }
}

function modificarPaciente(identificacion) {
    window.location.href = `../pacientes/modificarPaciente.php?idPaciente=${identificacion}`;
}

async function buscarPaciente() {
    const id = document.getElementById('buscarId').value;
    const div = document.getElementById('resultadoPaciente');

    if (id === "") {
        div.innerHTML = "Ingrese un ID";
        return;
    }

    div.innerHTML = "Buscando...";

    try {
        const res = await fetch(`../pacientes/listar.php?tipo=buscar&idPaciente=${id}`);
        const data = await res.json();

        if (!data.ok) {
            div.innerHTML = data.mensaje;
            return;
        }

        const p = data.paciente;
        div.innerHTML = `
    <div class="resultado-consulta">
        <p><b>Nombre:</b> ${p.nombre}</p>
        <p><b>Apellido:</b> ${p.apellido}</p>
        <p><b>Estado:</b> ${p.estado}</p>
    </div>
    `;

    } catch (error) {
        div.innerHTML = "Error del servidor";
        console.error(error);
    }
}

function limpiarBusqueda() {
    document.getElementById('buscarId').value = "";
    document.getElementById('resultadoPaciente').innerHTML = "";
}