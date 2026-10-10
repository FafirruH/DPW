document.addEventListener("DOMContentLoaded", function () {
    const search = document.getElementById("search-input");
    const rows = document.querySelectorAll(".table-responsive tbody tr");
    if (!search || rows.length === 0) return;

    search.addEventListener("input", function () {
        const keyword = search.value.trim().toLocaleLowerCase();
        rows.forEach(function (row) {
            row.hidden = !row.textContent.toLocaleLowerCase().includes(keyword);
        });
    });
});
