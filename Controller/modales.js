function abrirEditar(id, nombre, categoria, precio) {
  document.getElementById('editar_id').value = id;
  document.getElementById('editar_nombre').value = nombre;
  document.getElementById('editar_categoria').value = categoria;
  document.getElementById('editar_precio').value = precio;
  document.getElementById('modalEditar').style.display = 'flex';
}

function abrirAumentar(id) {
  document.getElementById('aumentar_id').value = id;
  document.getElementById('modalAumentar').style.display = 'flex';
}

function abrirEliminar(id) {
  document.getElementById('eliminar_id').value = id;
  document.getElementById('modalEliminar').style.display = 'flex';
}

function cerrarModal(id) {
  document.getElementById(id).style.display = 'none';
}
