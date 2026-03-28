document.addEventListener("DOMContentLoaded", () => {
    consultar("confirmada"); // por defecto
});

function consultar(estado) {
    fetch(`obtenerCitasConfirmadas.php?estado=${estado}`)
        .then(res => res.json())
        .then(data => {
            let tabla = document.getElementById("tablaCitas");
            tabla.innerHTML = "";

            data.forEach(cita => {
                let fila = `
                    <tr>
                        <td>${cita.id}</td>
                        <td>${cita.idCita}</td>
                        <td>${cita.identiPaciente}</td>
                        <td>${cita.estado}</td>
                    </tr>
                `;
                tabla.innerHTML += fila;
            });
        });
}

function buscar() {
    let valor = document.getElementById("buscarPaciente").value;
    cargarCitas("confirmada", valor); // puedes ajustarlo
}

function limpiar() {
    document.getElementById("buscarPaciente").value = "";
    cargarCitas("confirmada");
}