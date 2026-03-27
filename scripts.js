document.addEventListener('DOMContentLoaded', () => {
    listar();
});

async function listar(){
    const tabla = document.getElementById('tablaPacientes');

    tabla.innerHTML = '<p>No hay pacientes...</p>';

    try{
        const respuesta = await fetch("listar.php");
        const resultado = await respuesta.json();

        if (!resultado.ok){
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
                <tr id="fila-${p.identificacion}">
                    <td>${p.identificacion}</td>
                    <td>${p.nombre}</td>
                    <td>${p.apellido}</td>
                    <td>${p.telefono}</td>
                    <td>${p.estado}</td>
                    <td>
                        <button onclick="eliminarPaciente('${p.identificacion}')">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
        }

        html += `</tbody></table>`;
        tabla.innerHTML = html;

    }catch(error){
        tabla.innerHTML = '<p>Error al conectar con el servidor</p>';
        console.error(error);
    }
}

async function eliminarPaciente(id) {

    if (!confirm(`¿Eliminar paciente ${id}?`)) return;

    const fila = document.getElementById(`fila-${id}`);
    if(fila) fila.style.opacity = '0.4';

    try{
        const datos = new FormData();
        datos.append('id', id);

        const respuesta = await fetch("eliminarPaciente.php", {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if(resultado.Ok){
            listarPacientes();
        }else{
            alert("Error: " + resultado.mensaje);
            if(fila) fila.style.opacity = '1';
        }

    }catch(error){
        alert("Error del servidor");
        if(fila) fila.style.opacity = '1';
    }
}