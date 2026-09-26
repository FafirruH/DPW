document.addEventListener("DOMContentLoaded", function () {
    const reloadBtn = document.getElementById("btn-reload");
    if (reloadBtn) {
        reloadBtn.addEventListener("click", function () {
            window.location.reload(); 
        });
    }
});