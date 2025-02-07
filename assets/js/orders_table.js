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
