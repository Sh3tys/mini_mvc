document.addEventListener("DOMContentLoaded", function () {
  const filterButtons = document.querySelectorAll(".filter-btn");
  const productCards = document.querySelectorAll(".product-card");

  // --- 1. Logique du clic sur les boutons ---
  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const selectedCategory = this.getAttribute("data-category");

      // Gestion visuelle des boutons (Active / Inactive)
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      // Filtrage des produits
      productCards.forEach((card) => {
        // On récupère l'ID de catégorie stocké dans la carte produit
        const productCategory = card.getAttribute("data-category");

        if (
          selectedCategory === "all" ||
          productCategory === selectedCategory
        ) {
          card.classList.remove("hidden");
        } else {
          card.classList.add("hidden");
        }
      });
    });
  });

  // --- 2. Logique automatique au chargement de la page ---

  // On regarde si l'URL contient "?category=X"
  const params = new URLSearchParams(window.location.search);
  const categoryIdFromUrl = params.get("category");

  // Si on a un ID dans l'URL
  if (categoryIdFromUrl) {
    // On cherche le bouton qui a cet ID précis
    const targetButton = document.querySelector(
      `.filter-btn[data-category="${categoryIdFromUrl}"]`
    );

    // Si le bouton existe, on simule un clic dessus
    if (targetButton) {
      targetButton.click();
    }
  }
});
