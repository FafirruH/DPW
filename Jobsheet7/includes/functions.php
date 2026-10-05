<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function app_base_url(): string
{
    $root = realpath(dirname(__DIR__));
    $scriptDirectory = realpath(dirname($_SERVER['SCRIPT_FILENAME'] ?? ''));
    if ($root === false || $scriptDirectory === false) {
        return '';
    }

    $root = rtrim(str_replace('\\', '/', $root), '/');
    $scriptDirectory = str_replace('\\', '/', $scriptDirectory);
    $relativeDirectory = trim(substr($scriptDirectory, strlen($root)), '/');
    if ($relativeDirectory === '') {
        return '';
    }

    return str_repeat('../', substr_count($relativeDirectory, '/') + 1);
}

function app_data_path(string $type): string
{
    $files = [
        'buku' => dirname(__DIR__) . '/data/buku.json',
        'anggota' => dirname(__DIR__) . '/data/anggota.json',
    ];
    if (!isset($files[$type])) {
        throw new InvalidArgumentException('Jenis data tidak dikenal.');
    }
    return $files[$type];
}

function app_read_data(string $type): array
{
    $contents = file_get_contents(app_data_path($type));
    if ($contents === false) {
        throw new RuntimeException('Data tidak dapat dibaca. Periksa file JSON dan izin aksesnya.');
    }

    try {
        $data = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $error) {
        throw new RuntimeException('Format file JSON tidak valid.', 0, $error);
    }
    if (!is_array($data)) {
        throw new RuntimeException('Format data JSON tidak valid.');
    }
    return $data;
}

function app_write_data(string $type, array $data): void
{
    $contents = json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    if (file_put_contents(app_data_path($type), $contents . PHP_EOL, LOCK_EX) === false) {
        throw new RuntimeException('Data tidak dapat disimpan. Periksa izin tulis folder data.');
    }
}

function app_validate_record(string $type, array $input, ?string $currentId = null): array
{
    $requiredText = static function (string $key, string $label) use ($input): string {
        $value = trim((string) ($input[$key] ?? ''));
        if ($value === '') {
            throw new InvalidArgumentException($label . ' wajib diisi.');
        }
        return $value;
    };

    if ($type === 'buku') {
        $year = filter_var($input['tahun'] ?? null, FILTER_VALIDATE_INT);
        $stock = filter_var($input['stok'] ?? null, FILTER_VALIDATE_INT);
        if ($year === false || $year < 1900 || $year > (int) date('Y')) {
            throw new InvalidArgumentException('Tahun terbit harus di antara 1900 dan tahun ini.');
        }
        if ($stock === false || $stock < 0) {
            throw new InvalidArgumentException('Stok harus berupa angka nol atau lebih.');
        }
        $isbn = trim((string) ($input['isbn'] ?? ''));
        if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
            throw new InvalidArgumentException('ISBN hanya boleh berisi angka dan tanda hubung (-).');
        }

        return [
            'judul' => $requiredText('judul', 'Judul buku'),
            'pengarang' => $requiredText('pengarang', 'Pengarang'),
            'tahun' => $year,
            'isbn' => $isbn,
            'stok' => $stock,
            'kategori' => $requiredText('kategori', 'Kategori'),
        ];
    }

    if ($type === 'anggota') {
        $memberNumber = $requiredText('no_anggota', 'Nomor anggota');
        foreach (app_read_data('anggota') as $member) {
            if (($member['no_anggota'] ?? '') === $memberNumber && ($member['id'] ?? '') !== $currentId) {
                throw new InvalidArgumentException('Nomor anggota sudah terdaftar.');
            }
        }

        return [
            'no_anggota' => $memberNumber,
            'nama' => $requiredText('nama', 'Nama'),
            'alamat' => trim((string) ($input['alamat'] ?? '')),
            'no_hp' => trim((string) ($input['no_hp'] ?? '')),
        ];
    }

    throw new InvalidArgumentException('Jenis data tidak dikenal.');
}

function app_render_flash(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $type = in_array($flash['type'] ?? '', ['success', 'danger', 'warning', 'info'], true)
        ? $flash['type']
        : 'info';
    $message = htmlspecialchars((string) ($flash['pesan'] ?? ''), ENT_QUOTES, 'UTF-8');
    echo '<div class="container mt-3"><div class="alert alert-' . $type . '" role="alert">' . $message . '</div></div>';
}
