function toggleClave() {
  const adminSelect = document.getElementById("esAdmin");
  const claveDiv = document.getElementById("claveAdminDiv");
  claveDiv.style.display = (adminSelect.value === "si") ? "block" : "none";
}
