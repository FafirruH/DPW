document.addEventListener("DOMContentLoaded", function () {
    initDataTable({
        labelKey: "judul",
        columns: [
            { key: "judul" },
            { key: "pengarang" },
            { key: "kategori" },
            { key: "tahun", center: true },
            { key: "stok", center: true }
        ],
        fields: [
            { key: "judul", label: "Judul buku" },
            { key: "pengarang", label: "Pengarang" },
            { key: "tahun", label: "Tahun terbit" },
            { key: "isbn", label: "ISBN" },
            { key: "stok", label: "Stok" },
            { key: "kategori", label: "Kategori" }
        ]
    });
});
