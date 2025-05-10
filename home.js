
document.querySelector(".btn i.fa-plus-circle").parentElement.onclick = function () {
    const form = document.getElementById("addProductForm");
    form.style.display = form.style.display === "none" ? "block" : "none";
};
