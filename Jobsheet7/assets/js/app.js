function initDataTable(config) {
    const main = document.querySelector("main[data-api]");
    const tbody = document.querySelector(".table-responsive tbody");
    const loading = document.getElementById("loading-indicator");
    const tableError = document.getElementById("table-error");
    const search = document.getElementById("search-input");
    const reload = document.getElementById("btn-reload");
    if (!main || !tbody || !loading) return;

    const apiUrl = main.dataset.api;
    let records = [];

    function render() {
        if (tableError) tableError.hidden = true;
        const keyword = search ? search.value.trim().toLocaleLowerCase() : "";
        const visibleRecords = records.filter((record) =>
            config.columns.some((column) =>
                String(record[column.key] ?? "").toLocaleLowerCase().includes(keyword)
            )
        );
        tbody.replaceChildren();

        if (visibleRecords.length === 0) {
            const row = document.createElement("tr");
            const cell = document.createElement("td");
            cell.colSpan = config.columns.length + 1;
            cell.className = "text-center text-secondary py-4";
            cell.textContent = keyword ? "Data yang dicari tidak ditemukan." : "Belum ada data.";
            row.appendChild(cell);
            tbody.appendChild(row);
            return;
        }

        visibleRecords.forEach((record) => {
            const row = document.createElement("tr");
            row.dataset.id = record.id;
            config.columns.forEach((column) => {
                const cell = document.createElement("td");
                cell.textContent = String(record[column.key] ?? "-");
                if (column.center) cell.className = "text-center";
                row.appendChild(cell);
            });

            const actions = document.createElement("td");
            actions.className = "text-center text-nowrap";
            const editButton = document.createElement("button");
            editButton.type = "button";
            editButton.className = "btn btn-sm btn-outline-primary me-1";
            editButton.dataset.action = "edit";
            editButton.textContent = "Edit";

            const deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.className = "btn btn-sm btn-outline-danger";
            deleteButton.dataset.action = "delete";
            deleteButton.textContent = "Hapus";
            actions.append(editButton, deleteButton);
            row.appendChild(actions);
            tbody.appendChild(row);
        });
    }

    async function request(url, options) {
        const response = await fetch(url, options);
        const result = await response.json();
        if (!response.ok) {
            throw new Error(result.error || "Permintaan gagal.");
        }
        return result;
    }

    async function loadRecords() {
        loading.style.display = "block";
        try {
            const result = await request(apiUrl);
            records = result.data;
            render();
        } catch (error) {
            if (tableError) {
                tableError.textContent = "Gagal memperbarui data: " + error.message;
                tableError.hidden = false;
            }
        } finally {
            loading.style.display = "none";
        }
    }

    async function editRecord(record) {
        const changes = {};
        for (const field of config.fields) {
            const value = window.prompt(field.label, record[field.key] ?? "");
            if (value === null) return;
            changes[field.key] = value.trim();
        }

        try {
            await request(apiUrl, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: record.id, ...changes })
            });
            await loadRecords();
        } catch (error) {
            window.alert("Data gagal diperbarui: " + error.message);
        }
    }

    async function deleteRecord(record) {
        const label = record[config.labelKey] || "data ini";
        if (!window.confirm('Yakin ingin menghapus "' + label + '"?')) return;
        try {
            await request(apiUrl + "&id=" + encodeURIComponent(record.id), { method: "DELETE" });
            await loadRecords();
        } catch (error) {
            window.alert("Data gagal dihapus: " + error.message);
        }
    }

    if (search) search.addEventListener("input", render);
    if (reload) reload.addEventListener("click", loadRecords);
    tbody.addEventListener("click", function (event) {
        const button = event.target.closest("button[data-action]");
        const row = button ? button.closest("tr[data-id]") : null;
        if (!button || !row) return;

        const record = records.find((item) => String(item.id) === row.dataset.id);
        if (!record) return;
        if (button.dataset.action === "edit") editRecord(record);
        if (button.dataset.action === "delete") deleteRecord(record);
    });
    loadRecords();
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-tambah");
    if (form) {
        form.addEventListener("submit", function (event) {
            if (!form.reportValidity()) event.preventDefault();
        });
    }
});
