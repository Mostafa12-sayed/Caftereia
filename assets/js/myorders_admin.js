<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", () => {
  let selectedProducts =
    JSON.parse(localStorage.getItem("selectedProducts")) || [];

  // User selection
  document.getElementById("userSelect").addEventListener("change", (e) => {
    document.getElementById("selected_user").value = e.target.value;
  });

  // Product selection
  document.querySelectorAll(".product-card").forEach((card) => {
    card.addEventListener("click", () => {
      const productId = parseInt(card.dataset.id);
      const productName = card.querySelector("h6").textContent;
      const productPrice = parseFloat(card.querySelector(".price").textContent);
      const productImage = card.querySelector("img").src.split("/").pop();

      if (!selectedProducts.some((p) => p.id === productId)) {
        selectedProducts.push({
          id: productId,
          name: productName,
          price: productPrice,
          image: productImage,
          quantity: 1,
        });
        updateSelectedProducts();
        calculateTotal();
      }
    });
=======
document.addEventListener('DOMContentLoaded', () => {
    let selectedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];
    
    // Admin-only: User selection logic
    const userSelect = document.getElementById('userSelect');
    if (userSelect) {
        userSelect.addEventListener('change', (e) => {
            document.getElementById('selected_user').value = e.target.value;
        });
    }

    // Product selection (for both admin and user)
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', () => {
            const productId = parseInt(card.dataset.id);
            const productName = card.querySelector('h6').textContent;
            const productPrice = parseFloat(
                card.querySelector('.price').textContent.replace('EGP', '').trim()
            );
            const productImage = card.querySelector('img').src.split('/').pop();

            // Add product if not already selected
            if (!selectedProducts.some(p => p.id === productId)) {
                selectedProducts.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1
                });
                updateSelectedProducts();
                calculateTotal();
            }
>>>>>>> aa8ebaea989d433e5a9f5ee26dbccf1af66e07ed
  });

  // Quantity controls
  document
    .querySelector(".selected-products")
    .addEventListener("click", (e) => {
      const productItem = e.target.closest(".selected-product-item");
      if (!productItem) return;

      const productId = parseInt(productItem.dataset.id);
      const product = selectedProducts.find((p) => p.id === productId);

      if (e.target.classList.contains("btn-decrease")) {
        if (product.quantity > 1) {
          product.quantity--;
        } else {
          selectedProducts = selectedProducts.filter((p) => p.id !== productId);
        }
      } else if (e.target.classList.contains("btn-increase")) {
        product.quantity++;
      } else if (e.target.closest(".btn-remove")) {
        selectedProducts = selectedProducts.filter((p) => p.id !== productId);
      }

      updateSelectedProducts();
      calculateTotal();
    });

  // Update display
  function updateSelectedProducts() {
    const container = document.querySelector(".selected-products");
    container.innerHTML = selectedProducts
      .map(
        (product) => `
            <div class="d-flex align-items-center p-2 border rounded mb-2 selected-product-item" data-id="${
              product.id
            }">
                <img src="assets/images/products/${
                  product.image
                }" class="product-thumbnail">  
                <div class="ms-2 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="fw-bold">${product.name}</label>
                        <span class="text-primary">EGP ${product.price.toFixed(
                          2
                        )}</span>
                    </div>
                    <div class="d-flex align-items-center mt-1">
                        <div class="input-group input-group-sm" style="width: 100px;">
                            <button type="button" class="btn btn-outline-secondary btn-decrease">-</button>
                            <input type="number" class="form-control text-center quantity-input" 
                                   value="${product.quantity}" min="1" readonly>
                            <button type="button" class="btn btn-outline-secondary btn-increase">+</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 btn-remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `
      )
      .join("");

    localStorage.setItem("selectedProducts", JSON.stringify(selectedProducts));
  }

  // Calculate total
  function calculateTotal() {
    const total = selectedProducts.reduce(
      (sum, product) => sum + product.price * product.quantity,
      0
    );
    document.querySelector(
      ".order-total .h5"
    ).textContent = `EGP ${total.toFixed(2)}`;
  }

  // Form submission
  document.getElementById("orderForm").addEventListener("submit", (e) => {
    document.getElementById("products_json").value = JSON.stringify(
      selectedProducts.map((p) => ({
        id: p.id,
        quantity: p.quantity,
      }))
    );

    localStorage.removeItem("selectedProducts");
  });

  // Initial load
  updateSelectedProducts();
  calculateTotal();
});

document
  .getElementById("profileToggle")
  .addEventListener("click", function (event) {
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.style.display =
      dropdown.style.display === "block" ? "none" : "block";
    event.stopPropagation();
  });

document.addEventListener("click", function () {
  document.getElementById("dropdownMenu").style.display = "none";
});
