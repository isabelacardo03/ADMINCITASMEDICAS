document.addEventListener('DOMContentLoaded', () => {
    listar();
});

async function listar(){
    const tabla = document.getElementById('tablaPacientes');

    tabla.innerHTML = '<p>No hay pacientes...</p>';

    try{
        const respuesta = await fetch("listar.php?tipo=paciente");
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
                    <td class="boton">
                        <button class="btn-eliminar" onclick="eliminar('${p.identificacion}')">
                            Eliminar
                        </button>
                        <button class="btn-modificar" onclick="modificar('${p.identificacion}')">
                            modificar
                        </button>
                    </td>
                </tr>
            `;
        }

        html += `</tbody></table>`;
        tabla.innerHTML = html;

    }catch(error){
        alert("Error: " + error.message);
    console.error(error);
    }
}

async function eliminar(identificacion) {

    if (!confirm(`¿Eliminar paciente ${identificacion}?`)) return;

    const fila = document.getElementById(`fila-${identificacion}`);
    if(fila) fila.style.opacity = '0.4';

    try{
        const datos = new FormData();
        datos.append("tipo", "paciente");
        datos.append('identificacion', identificacion);

        const respuesta = await fetch("eliminar.php", {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if(resultado.ok){
            listar();
        }else{
            alert("Error: " + resultado.mensaje);
            if(fila) fila.style.opacity = '1';
        }

    }catch(error){
        alert("Error del servidor");
        if(fila) fila.style.opacity = '1';
    }
}

async function modificar(identificacion){

    const respuesta = await fetch("listar.php?tipo=paciente");
    const resultado = await respuesta.json();

    const paciente = resultado.pacientes.find(p => p.identificacion == identificacion);

    document.getElementById("identificacion").value = paciente.identificacion;
    document.getElementById("tipoDocumento").value = paciente.tipoDocumento;
    document.getElementById("nombre").value = paciente.nombre;
    document.getElementById("apellido").value = paciente.apellido;
    document.getElementById("fechaNacimiento").value = paciente.fechaNacimiento;
    document.getElementById("direccion").value = paciente.direccion;
    document.getElementById("telefono").value = paciente.telefono;
    document.getElementById("estado").value = paciente.estado;

    // 🔥 clave
    document.getElementById("modo").value = "editar";
}

async function guardar() {

    const form = document.getElementById("formPaciente");
    const datos = new FormData(form);

    // Agregamos el tipo manualmente por si acaso
    datos.append("tipo", "paciente");

    // Leemos el modo: "guardar" o "editar"
    const modo = document.getElementById("modo").value;

    // Elegimos a qué archivo PHP enviar según el modo
    let url = "";
    if (modo === "editar") {
        url = "modificar.php";   // actualizar paciente existente
    } else {
        url = "guardar.php";     // crear paciente nuevo
    }

    try {
        const respuesta = await fetch(url, {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.ok) {
            alert(resultado.mensaje);
            // Limpiamos el formulario después de guardar
            form.reset();
            // Volvemos al modo guardar
            document.getElementById("modo").value = "guardar";
            // Recargamos la tabla
            listar();
        } else {
            alert("Error: " + resultado.mensaje);
        }

    } catch (error) {
        alert("Error de conexión: " + error.message);
    }
}