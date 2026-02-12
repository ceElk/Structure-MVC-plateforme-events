// ========== RECHERCHE AJAX UTILISATEURS ==========

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchUsers");
  const filterRole = document.getElementById("filterRole");
  const resetBtn = document.getElementById("resetSearch");
  const tableBody = document.getElementById("usersTableBody");
  const tableContainer = document.getElementById("usersTableContainer");
  const loadingSpinner = document.getElementById("loadingSpinner");
  const searchCount = document.getElementById("searchCount");

  let searchTimeout;

  // Fonction de recherche
  function searchUsers() {
    const query = searchInput.value.trim();
    const role = filterRole.value;

    // Affiche le spinner
    loadingSpinner.style.display = "block";
    tableContainer.style.display = "none";
    searchCount.textContent = "";

    fetch(
      `?controller=admin&action=searchUsersAjax&query=${encodeURIComponent(
        query
      )}&role=${encodeURIComponent(role)}`
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur serveur");
        }
        return response.json();
      })

      .then((result) => {
        if (result.success) {
          const users = result.data;

          // Met à jour le compteur
          if (query || role) {
            searchCount.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i> ${users.length} utilisateur(s) trouvé(s)`;
          }

          if (users.length > 0) {
            // Génère le HTML
            let html = "";
            users.forEach((user) => {
              html += `
                  <tr>
                    <td><span class="badge bg-light text-dark">${
                      user.id
                    }</span></td>
                    <td><strong>${user.username}</strong></td>
                    <td><small class="text-muted">${user.email}</small></td>
                    <td>
                      ${
                        user.role_name === "admin"
                          ? '<span class="badge bg-danger"><i class="fas fa-crown me-1"></i> Admin</span>'
                          : '<span class="badge bg-secondary"><i class="fas fa-user me-1"></i> User</span>'
                      }
                    </td>
                    <td>
                      <small class="text-muted">
                        <i class="far fa-calendar-alt me-1"></i> ${
                          user.created_at
                        }
                      </small>
                    </td>
                    <td>
                      <a href="?controller=admin&action=editUser&id=${user.id}" 
                         class="btn btn-sm btn-outline-primary" title="Modifier">
                         <i class="fas fa-edit"></i>
                      </a>
                    </td>
                  </tr>
                `;
            });

            tableBody.innerHTML = html;
            tableContainer.style.display = "block";
          } else {
            tableContainer.innerHTML = `
                <div class="p-5 text-center text-muted">
                  <i class="fas fa-search fa-4x mb-3 opacity-50"></i>
                  <p class="mb-0 fs-5">Aucun utilisateur trouvé</p>
                  <p class="mb-0 small">Essayez avec d'autres critères</p>
                </div>
              `;
            tableContainer.style.display = "block";
          }
        } else {
          alert("Erreur: " + (result.message || "Erreur inconnue"));
        }
      })

      .catch((error) => {
        console.error("Erreur AJAX:", error);
        tableContainer.innerHTML = `
            <div class="p-5 text-center text-danger">
              <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
              <p class="mb-0 fs-5">Erreur de connexion au serveur</p>
            </div>
          `;
        tableContainer.style.display = "block";
      })

      .finally(() => {
        loadingSpinner.style.display = "none";
      });
  }

  // Event: Recherche avec délai (300ms après la dernière frappe)
  searchInput.addEventListener("input", function () {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchUsers, 300);
  });

  // Event: Filtre de rôle
  filterRole.addEventListener("change", searchUsers);

  // Event: Reset
  resetBtn.addEventListener("click", function () {
    searchInput.value = "";
    filterRole.value = "";
    searchCount.textContent = "";
    window.location.reload();
  });
});
