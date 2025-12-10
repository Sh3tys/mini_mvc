// Gestion des quantités dans le panier

/**
 * Décrémente la quantité (minimum 1)
 */
function decrementQty(button) {
  const form = button.closest(".quantity-form");
  const input = form.querySelector(".qty-input");
  let value = parseInt(input.value);

  if (value > 1) {
    input.value = value - 1;
    form.submit();
  }
}

/**
 * Incrémente la quantité
 */
function incrementQty(button) {
  const form = button.closest(".quantity-form");
  const input = form.querySelector(".qty-input");
  let value = parseInt(input.value);

  input.value = value + 1;
  form.submit();
}

/**
 * Validation de la saisie manuelle
 */
document.addEventListener("DOMContentLoaded", function () {
  const qtyInputs = document.querySelectorAll(".qty-input");

  qtyInputs.forEach((input) => {
    input.addEventListener("blur", function () {
      let value = parseInt(this.value);

      // Vérifier que c'est un nombre valide
      if (isNaN(value) || value < 1) {
        this.value = 1;
        this.closest(".quantity-form").submit();
      }
    });

    // Validation en temps réel
    input.addEventListener("input", function () {
      // Empêcher les valeurs négatives et 0
      if (this.value < 1) {
        this.value = 1;
      }
    });
  });
});
