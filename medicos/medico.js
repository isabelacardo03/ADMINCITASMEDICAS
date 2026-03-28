document.addEventListener('DOMContentLoaded', () => {
    listar();
});

async function listar() {
    const tabla = document.getElementById('tablaMedicos');

    tabla.innerHTML = '<p>No hay médicos...</p>';

    try {
        const respuesta = await fetch("../medicos/listarMedi.php");
        const resultado = await respuesta.json();

        if (!resultado.ok) {
            tabla.innerHTML = `<p>Error: ${resultado.mensaje}</p>`;
            return;
        }

        if (resultado.medicos.length === 0) {
            tabla.innerHTML = '<p>No hay médicos registrados</p>';
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

        for (const m of resultado.medicos) {
            html += `
                <tr id="fila-${m.idMedico}">
                    <td>${m.idMedico}</td>
                    <td>${m.nombre}</td>
                    <td>${m.apellido}</td>
                    <td>${m.telefono}</td>
                    <td>${m.estado}</td>
                    <td class="botones">
                        <button class="btn-eliminar" onclick="eliminarMedi('${m.idMedico}')">
                            Eliminar
                        </button>
                        <button class="btn-modificar" onclick="modificarMedi('${m.idMedico}')">
                            Modificar
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
// 🔹 ELIMINAR MÉDICO
async function eliminarMedi(idMedico) {

    if (!confirm(`¿Eliminar médico ${idMedico}?`)) return;

    const fila = document.getElementById(`fila-${idMedico}`);
    if (fila) fila.style.opacity = '0.4';

    try {
        const datos = new FormData();
        datos.append('idMedico', idMedico);

        const respuesta = await fetch("../medicos/eliminarMedi.php", {
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

function modificarMedi(idMedico) {
    window.location.href = `../medicos/modificarMedi.php?idMedico=${idMedico}`;
}

async function buscarMedi() {
    const id = document.getElementById('buscarId').value;
    const div = document.getElementById('resultadoMedico');

    if (id === "") {
        div.innerHTML = "Ingrese un ID";
        return;
    }

    div.innerHTML = "Buscando...";

    try {
        const res = await fetch(`../medicos/listarmedi.php?tipo=buscar&idMedico=${id}`);
        const data = await res.json();

        if (!data.ok) {
            div.innerHTML = data.mensaje;
            return;
        }

        const m = data.medico;

        div.innerHTML = `
        <div class="resultado-consulta">
            <p><b>Nombre:</b> ${m.nombre}</p>
            <p><b>Apellido:</b> ${m.apellido}</p>
            <p><b>Estado:</b> ${m.estado}</p>
        </div>
        `;

    } catch (error) {
        div.innerHTML = "Error del servidor";
        console.error(error);
    }
}

function limpiarBusqueda() {
    document.getElementById('buscarId').value = "";
    document.getElementById('resultadoMedico').innerHTML = "";
}