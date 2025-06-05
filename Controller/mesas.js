const maxMesas = 16;
let mesaCount = 5;

document.addEventListener("DOMContentLoaded", () => {
  for (let i = 1; i <= mesaCount; i++) {
    crearMesa(i);
  }

  document.getElementById("agregarMesaBtn").addEventListener("click", () => {
    if (mesaCount < maxMesas) {
      mesaCount++;
      crearMesa(mesaCount);
    } else {
      alert("Máximo 16 mesas permitidas.");
    }
  });

  const modal = document.getElementById("modalRecibo");
  const span = document.getElementsByClassName("close")[0];

  span.onclick = () => modal.style.display = "none";
  window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
  };
});

function crearMesa(numero) {
  const mesa = document.createElement("div");
  mesa.classList.add("mesa");
  mesa.innerHTML = `
    <h3>Mesa ${numero}</h3>
    <form>
      <label>Mesero:</label>
      <select name="mesero" class="select-mesero" required>
        <option value="">Cargando meseros...</option>
      </select>
      <input type="date" name="fecha" required max="${new Date().toISOString().split('T')[0]}">
      <div class="productos"></div>
      <button type="button" onclick="agregarProducto(this)">+ Producto</button>
      <button type="button" onclick="hacerPedido(this, ${numero})">Hacer Pedido</button>
      <button type="button" onclick="verRecibo(${numero})">Generar Recibo</button>
    </form>
  `;
  document.getElementById("mesas").appendChild(mesa);
  agregarProducto(mesa.querySelector("button"));

  // Cargar meseros dinámicamente
  fetch('../php/listar_meseros.php')
    .then(res => res.text())
    .then(html => {
      mesa.querySelector('.select-mesero').innerHTML = html;
    });
}

function agregarProducto(boton) {
  const contenedor = boton.parentElement.querySelector(".productos");
  const div = document.createElement("div");
  div.innerHTML = `
    <select name="producto[]" required>${listarProductos()}</select>
    <input type="number" name="cantidad[]" placeholder="Cantidad" min="1" required>
  `;
  contenedor.appendChild(div);
}

function listarProductos() {
  const req = new XMLHttpRequest();
  req.open("GET", "../php/listar_productos.php", false); // síncrono porque es para opciones
  req.send(null);
  return req.responseText;
}

function hacerPedido(btn, mesaNum) {
  const form = btn.closest("form");
  const datos = new FormData(form);
  datos.append("mesa", mesaNum);

  fetch("../php/pedido.php", {
    method: "POST",
    body: datos
  })
  .then(res => res.text())
  .then(msg => {
    if (msg.includes("exitosamente")) {
      alert("Pedido registrado.");
    } else {
      alert("Error: " + msg);
    }
  });
}

function verRecibo(mesaNum) {
  fetch("../php/recibo.php?mesa=" + mesaNum)
    .then(res => res.text())
    .then(html => {
      document.getElementById("contenidoRecibo").innerHTML = html;
      document.getElementById("modalRecibo").style.display = "block";
    });
}

document.getElementById("confirmarPago").onclick = () => {
  const mesaText = document.querySelector("#contenidoRecibo h3").innerText;
  const mesa = mesaText.match(/\d+/)[0];

  const datos = new FormData();
  datos.append("mesa", mesa);

  fetch("../php/guardar_pago.php", {
    method: "POST",
    body: datos
  })
  .then(res => res.text())
  .then(resp => {
    if (resp === "OK") {
      alert("Pago registrado correctamente.");
      window.location.reload();
    } else {
      alert("Error: " + resp);
    }
  });
};
