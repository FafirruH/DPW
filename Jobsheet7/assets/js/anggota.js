document.addEventListener("DOMContentLoaded", function () {
    initDataTable({
        labelKey: "nama",
        columns: [
            { key: "no_anggota" },
            { key: "nama" },
            { key: "alamat" },
            { key: "no_hp" }
        ],
        fields: [
            { key: "no_anggota", label: "Nomor anggota" },
            { key: "nama", label: "Nama" },
            { key: "alamat", label: "Alamat" },
            { key: "no_hp", label: "Nomor HP" }
        ]
    });
});
