document.addEventListener('DOMContentLoaded', () => {
    const contenedor = document.getElementById('productos-container');
    const botonAgregar = document.getElementById('agregar-producto');
    const formulario = document.getElementById('form-alimento');
    const alertas = document.getElementById('alertas');

    // Botones mostrar productos / mostrar menos
    const btnMostrarProductos = document.getElementById('btn-mostrar-productos');
    const btnMostrarMenos = document.getElementById('btn-mostrar-menos');

    // Contenedor donde se mostrará la lista de productos
    let contenedorProductosRegistrados = document.getElementById('productos-registrados');
    if (!contenedorProductosRegistrados) {
        contenedorProductosRegistrados = document.createElement('div');
        contenedorProductosRegistrados.id = 'productos-registrados';
        contenedorProductosRegistrados.className = 'mt-4';
        formulario.parentNode.appendChild(contenedorProductosRegistrados);
    }

    let contador = 0;
    const maxProductos = 100;

    // Crear grupo de inputs para nuevo producto
    function crearGrupoProducto() {
        if (contador >= maxProductos) return;

        const grupo = document.createElement('div');
        grupo.className = 'border rounded p-3 mb-3 bg-black text-white';

        grupo.innerHTML = `
            <div class="mb-2">
                <input type="text" name="nombre[]" class="form-control" placeholder="Nombre del alimento" required>
            </div>
            <div class="mb-2">
                <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required>
            </div>
            <div class="mb-2">
                <select name="categoria[]" class="form-select" required>
                    <option value="">Seleccione Categoría</option>
                    <option value="comida">Comida</option>
                    <option value="bebida">Bebida</option>
                    <option value="objeto">Objeto</option>
                </select>
            </div>
            <div class="mb-2">
                <select name="estado[]" class="form-select" required>
                    <option value="disponible">Disponible</option>
                    <option value="faltante">Faltante</option>
                </select>
            </div>
        `;
        contenedor.appendChild(grupo);
        contador++;
    }

    botonAgregar.addEventListener('click', crearGrupoProducto);
    crearGrupoProducto(); // Primer producto por defecto

    // Manejar envío del formulario
    formulario.addEventListener('submit', function (e) {
        e.preventDefault();

        const datos = new FormData(formulario);

        fetch('registro_alimento.php', {
            method: 'POST',
            body: datos
        })
        .then(response => response.text())
        .then(texto => {
            mostrarAlerta(texto.trim(), 'success');
            formulario.reset();
            contenedor.innerHTML = '';
            contador = 0;
            crearGrupoProducto();
        })
        .catch(() => {
            mostrarAlerta('Error al enviar los datos.', 'danger');
        });
    });

    // Mostrar alertas Bootstrap
    function mostrarAlerta(mensaje, tipo) {
        alertas.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        `;
    }

    // Cargar y mostrar productos registrados (tabla)
    function cargarProductosRegistrados() {
        fetch('obtener_productos.php')
            .then(res => res.json())
            .then(productos => {
                if (!Array.isArray(productos) || productos.length === 0) {
                    contenedorProductosRegistrados.innerHTML = '<p class="text-white">No hay productos registrados.</p>';
                    return;
                }

                let html = `
                    <h3 class="text-danger">Productos Registrados</h3>
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Fecha Inventario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                productos.forEach(p => {
                    html += `
                        <tr>
                            <td>${p.id}</td>
                            <td>${p.nombre}</td>
                            <td>${p.cantidad}</td>
                            <td>${p.categoria}</td>
                            <td>${p.estado}</td>
                            <td>${p.fecha_inventario}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-editar" data-id="${p.id}">Editar</button>
                                <button class="btn btn-sm btn-danger btn-eliminar" data-id="${p.id}">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });

                html += `</tbody></table>`;
                contenedorProductosRegistrados.innerHTML = html;

                // Añadir eventos a botones eliminar
                document.querySelectorAll('.btn-eliminar').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        eliminarProducto(id);
                    });
                });

                // Añadir eventos a botones editar
                document.querySelectorAll('.btn-editar').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        abrirModalEditar(id);
                    });
                });
            })
            .catch(() => {
                contenedorProductosRegistrados.innerHTML = '<p class="text-danger">Error al cargar productos.</p>';
            });
    }

    // Eliminar producto con confirmación
    function eliminarProducto(id) {
        if (!confirm('¿Seguro que quieres eliminar este producto?')) return;

        fetch('eliminar_producto.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${encodeURIComponent(id)}`
        })
        .then(res => res.text())
        .then(texto => {
            mostrarAlerta(texto.trim(), 'success');
            cargarProductosRegistrados();
        })
        .catch(() => {
            mostrarAlerta('Error al eliminar el producto.', 'danger');
        });
    }

    // Modal editar producto - crear modal si no existe
    let modalEditar = document.getElementById('modal-editar-producto');
    if (!modalEditar) {
        modalEditar = document.createElement('div');
        modalEditar.className = 'modal fade';
        modalEditar.id = 'modal-editar-producto';
        modalEditar.tabIndex = -1;
        modalEditar.setAttribute('aria-hidden', 'true');
        modalEditar.innerHTML = `
        <div class="modal-dialog">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
              <h5 class="modal-title text-danger">Editar Producto</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form-editar-producto">
              <div class="modal-body">
                <input type="hidden" name="id" id="editar-id">
                <div class="mb-3">
                  <label for="editar-nombre" class="form-label">Nombre</label>
                  <input type="text" name="nombre" id="editar-nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="editar-cantidad" class="form-label">Cantidad</label>
                  <input type="number" name="cantidad" id="editar-cantidad" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="editar-categoria" class="form-label">Categoría</label>
                  <select name="categoria" id="editar-categoria" class="form-select" required>
                    <option value="">Seleccione Categoría</option>
                    <option value="comida">Comida</option>
                    <option value="bebida">Bebida</option>
                    <option value="objeto">Objeto</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="editar-estado" class="form-label">Estado</label>
                  <select name="estado" id="editar-estado" class="form-select" required>
                    <option value="disponible">Disponible</option>
                    <option value="faltante">Faltante</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Guardar Cambios</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div>
        </div>
        `;
        document.body.appendChild(modalEditar);
    }

    const modalBootstrap = new bootstrap.Modal(modalEditar);

    // Abrir modal y cargar datos para editar
    function abrirModalEditar(id) {
        fetch(`obtener_producto_por_id.php?id=${encodeURIComponent(id)}`)
            .then(res => res.json())
            .then(producto => {
                if (!producto) {
                    mostrarAlerta('Producto no encontrado.', 'danger');
                    return;
                }
                document.getElementById('editar-id').value = producto.id;
                document.getElementById('editar-nombre').value = producto.nombre;
                document.getElementById('editar-cantidad').value = producto.cantidad;
                document.getElementById('editar-categoria').value = producto.categoria;
                document.getElementById('editar-estado').value = producto.estado;

                modalBootstrap.show();
            })
            .catch(() => {
                mostrarAlerta('Error al obtener producto.', 'danger');
            });
    }

    // Manejar formulario de editar producto
    document.getElementById('form-editar-producto').addEventListener('submit', function (e) {
        e.preventDefault();

        const formEditar = e.target;
        const datos = new FormData(formEditar);

        fetch('editar_producto.php', {
            method: 'POST',
            body: datos
        })
        .then(res => res.text())
        .then(texto => {
            mostrarAlerta(texto.trim(), 'success');
            modalBootstrap.hide();
            cargarProductosRegistrados();
        })
        .catch(() => {
            mostrarAlerta('Error al actualizar producto.', 'danger');
        });
    });

    // Mostrar / ocultar productos con botones
    btnMostrarProductos.addEventListener('click', () => {
        cargarProductosRegistrados();
        btnMostrarProductos.style.display = 'none';
        btnMostrarMenos.style.display = 'inline-block';
        contenedorProductosRegistrados.style.display = 'block';
    });

    btnMostrarMenos.addEventListener('click', () => {
        contenedorProductosRegistrados.style.display = 'none';
        btnMostrarMenos.style.display = 'none';
        btnMostrarProductos.style.display = 'inline-block';
    });

    // Inicialmente ocultamos contenedor y botón mostrar menos
    contenedorProductosRegistrados.style.display = 'none';
    btnMostrarMenos.style.display = 'none';

});
