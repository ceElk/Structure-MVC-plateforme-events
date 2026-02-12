// ========== AJAX : MODIFIER UN ATELIER EN MODALE ==========

async function openEditAtelierModal(atelierId) {
  const modal = new bootstrap.Modal(
    document.getElementById("editAtelierModal")
  );
  const modalTitle = document.getElementById("editAtelierModalTitle");
  const modalBody = document.getElementById("editAtelierModalBody");
  const saveBtn = document.getElementById("saveAtelierBtn");

  // Réinitialise
  modalTitle.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...';
  modalBody.innerHTML =
    '<div class="text-center py-5"><div class="spinner-border" style="color: #d4af37;"></div></div>';
  saveBtn.style.display = "none";

  modal.show();

  try {
    // ✅ Récupère le formulaire pré-rempli
    const response = await fetch(
      `?controller=atelier&action=editAjax&id=${atelierId}`
    );
    const result = await response.json();

    if (result.success) {
      const a = result.data;

      modalTitle.innerHTML =
        '<i class="fas fa-edit me-2"></i> Modifier l\'atelier';
      modalBody.innerHTML = `
                <form id="editAtelierForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="${a.id}">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Titre *</label>
                            <input type="text" class="form-control" name="title" value="${
                              a.title
                            }" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date *</label>
                            <input type="date" class="form-control" name="date_start" value="${
                              a.date_start
                            }" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4">${
                          a.description || ""
                        }</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lieu</label>
                            <input type="text" class="form-control" name="location" value="${
                              a.location || ""
                            }">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ville</label>
                            <input type="text" class="form-control" name="location_city" value="${
                              a.location_city || ""
                            }">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prix (€)</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="${
                              a.price
                            }">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Capacité</label>
                            <input type="number" class="form-control" name="capacity" value="${
                              a.capacity
                            }">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Places disponibles</label>
                            <input type="number" class="form-control" name="available_spots" value="${
                              a.available_spots
                            }">
                        </div>
                    </div>
                    
                    ${
                      a.image
                        ? `
                        <div class="mb-3">
                            <label class="form-label">Image actuelle</label>
                            <div><img src="${a.image}" class="img-thumbnail" style="max-height:150px;"></div>
                        </div>
                    `
                        : ""
                    }
                    
                    <div class="mb-3">
                        <label class="form-label">Changer l'image (optionnel)</label>
                        <input type="file" class="form-control" name="picture" accept="image/*">
                    </div>
                </form>
            `;

      saveBtn.style.display = "inline-block";

      // ✅ Event listener sur le bouton "Enregistrer"
      saveBtn.onclick = () => submitEditAtelier(atelierId);
    } else {
      modalTitle.innerHTML =
        '<i class="fas fa-exclamation-triangle"></i> Erreur';
      modalBody.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
    }
  } catch (error) {
    modalTitle.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Erreur';
    modalBody.innerHTML =
      '<div class="alert alert-danger">Erreur de connexion</div>';
    console.error(error);
  }
}

// ========== ENVOI DU FORMULAIRE DE MODIFICATION ==========
async function submitEditAtelier(atelierId) {
  const form = document.getElementById("editAtelierForm");
  const saveBtn = document.getElementById("saveAtelierBtn");
  const saveText = document.getElementById("saveText");
  const saveSpinner = document.getElementById("saveSpinner");

  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  // Animation
  saveBtn.disabled = true;
  saveText.style.display = "none";
  saveSpinner.style.display = "inline-block";

  const formData = new FormData(form);

  try {
    const response = await fetch(`?controller=atelier&action=updateAjax`, {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    if (result.success) {
      // Ferme la modale
      const modal = bootstrap.Modal.getInstance(
        document.getElementById("editAtelierModal")
      );
      modal.hide();

      // Recharge la page pour voir les modifications
      setTimeout(() => window.location.reload(), 500);
    } else {
      alert("Erreur: " + (result.message || "Erreur inconnue"));
    }
  } catch (error) {
    alert("Erreur de connexion au serveur");
    console.error(error);
  }

  // Réactive le bouton
  saveBtn.disabled = false;
  saveText.style.display = "inline";
  saveSpinner.style.display = "none";
}
