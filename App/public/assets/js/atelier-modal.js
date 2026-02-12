async function openAtelierModal(atelierId) {
  const modal = new bootstrap.Modal(document.getElementById("atelierModal"));
  const modalTitle = document.getElementById("atelierModalTitle");
  const modalBody = document.getElementById("atelierModalBody");
  const reserveBtn = document.getElementById("atelierReserveBtn");

  modalTitle.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...';
  modalBody.innerHTML =
    '<div class="text-center py-5"><div class="spinner-border" style="color: #d4af37;"></div></div>';
  reserveBtn.style.display = "none";
  modal.show();

  try {
    const response = await fetch(
      `?controller=atelier&action=showAjax&id=${atelierId}`
    );
    const result = await response.json();

    if (result.success) {
      const a = result.data;
      modalTitle.innerHTML = `<i class="fas fa-calendar-alt me-2"></i> ${a.title}`;
      modalBody.innerHTML = `
                ${
                  a.image
                    ? `<img src="App/public/${a.image}" class="img-fluid rounded mb-4" style="max-height:400px;width:100%;object-fit:cover;">`
                    : ""
                }
                <div class="row mb-3">
                    <div class="col-md-6"><h6><i class="fas fa-calendar me-2" style="color:#d4af37;"></i>Date</h6><p>${
                      a.date_formatted
                    }</p></div>
                    <div class="col-md-6"><h6><i class="fas fa-clock me-2" style="color:#d4af37;"></i>Horaire</h6><p>${
                      a.time_start || "Non spécifié"
                    }</p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><h6><i class="fas fa-map-marker-alt me-2" style="color:#d4af37;"></i>Lieu</h6><p>${
                      a.location || "À définir"
                    }</p></div>
                    <div class="col-md-6"><h6><i class="fas fa-tag me-2" style="color:#d4af37;"></i>Catégorie</h6><span class="badge" style="background-color:${
                      a.category_color || "#6c757d"
                    }">${a.category_icon || "📁"} ${
        a.category_name || "Non classé"
      }</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><h6><i class="fas fa-euro-sign me-2" style="color:#d4af37;"></i>Prix</h6><p class="h4" style="color:#d4af37;">${
                      a.price
                    } €</p></div>
                    <div class="col-md-6"><h6><i class="fas fa-users me-2" style="color:#d4af37;"></i>Places</h6><p class="h4 ${
                      a.available_spots > 0 ? "text-success" : "text-danger"
                    }">${a.available_spots}/${a.capacity}</p></div>
                </div>
                <div class="mb-3"><h6><i class="fas fa-info-circle me-2" style="color:#d4af37;"></i>Description</h6><p>${
                  a.description || "Aucune description."
                }</p></div>
                <div class="alert ${
                  a.available_spots > 0 ? "alert-success" : "alert-danger"
                }">${
        a.available_spots > 0
          ? '<i class="fas fa-check-circle me-2"></i>Places disponibles !'
          : '<i class="fas fa-times-circle me-2"></i>Complet'
      }</div>
            `;
      if (a.available_spots > 0 && a.can_reserve) {
        reserveBtn.style.display = "inline-block";
        reserveBtn.href = `?controller=reservation&action=create&eventId=${a.id}`;
      }
    } else {
      modalTitle.innerHTML =
        '<i class="fas fa-exclamation-triangle"></i> Erreur';
      modalBody.innerHTML = `<div class="alert alert-danger">${
        result.message || "Erreur"
      }</div>`;
    }
  } catch (error) {
    modalTitle.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Erreur';
    modalBody.innerHTML =
      '<div class="alert alert-danger">Erreur de connexion</div>';
    console.error(error);
  }
}
