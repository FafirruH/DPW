// Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/buku.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarBuku = await res.json();

        daftarBuku.forEach(function (buku) {
            const badgeStok = Number(buku.stok) > 0
                ? "bg-success-subtle text-success border border-success-subtle"
                : "bg-danger-subtle text-danger border border-danger-subtle";

            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td class=\"fw-medium\">" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.kategori + "</td>" +
                "<td class=\"text-center\">" + buku.tahun + "</td>" +
                "<td class=\"text-center\"><span class=\"badge " + badgeStok + "\">" + buku.stok + "</span></td>" +
                "<td class=\"text-center\">" +
                "<div class=\"btn-group btn-group-sm\" role=\"group\">" +
                "<button type=\"button\" class=\"btn btn-warning text-white\">Edit</button>" +
                "<button type=\"button\" class=\"btn btn-danger btn-hapus\">Hapus</button>" +
                "</div>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"6\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);