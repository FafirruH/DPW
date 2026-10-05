<?php
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function api_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

$type = $_GET['type'] ?? '';
if (!in_array($type, ['buku', 'anggota'], true)) {
    api_response(['error' => 'Jenis data tidak dikenal.'], 400);
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
try {
    $records = app_read_data($type);
    if ($method === 'GET') {
        api_response(['data' => $records]);
    }

    if (!in_array($method, ['POST', 'PUT', 'DELETE'], true)) {
        header('Allow: GET, POST, PUT, DELETE');
        api_response(['error' => 'Metode tidak didukung.'], 405);
    }

    if ($method === 'DELETE') {
        $id = (string) ($_GET['id'] ?? '');
        $filtered = array_values(array_filter(
            $records,
            static fn(array $record): bool => (string) ($record['id'] ?? '') !== $id
        ));
        if (count($filtered) === count($records)) {
            api_response(['error' => 'Data tidak ditemukan.'], 404);
        }
        app_write_data($type, $filtered);
        api_response(['message' => 'Data berhasil dihapus.']);
    }

    $rawInput = file_get_contents('php://input');
    try {
        $input = json_decode($rawInput === false ? '' : $rawInput, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        throw new InvalidArgumentException('Isi permintaan JSON tidak valid.');
    }
    if (!is_array($input)) {
        throw new InvalidArgumentException('Isi permintaan tidak valid.');
    }

    if ($method === 'POST') {
        $record = app_validate_record($type, $input);
        $record['id'] = strtoupper(substr($type, 0, 1)) . bin2hex(random_bytes(5));
        $records[] = $record;
        app_write_data($type, $records);
        api_response(['data' => $record, 'message' => 'Data berhasil ditambahkan.'], 201);
    }

    $id = (string) ($input['id'] ?? '');
    foreach ($records as $index => $record) {
        if ((string) ($record['id'] ?? '') === $id) {
            $updatedRecord = app_validate_record($type, $input, $id);
            $updatedRecord['id'] = $id;
            $records[$index] = $updatedRecord;
            app_write_data($type, $records);
            api_response(['data' => $updatedRecord, 'message' => 'Data berhasil diperbarui.']);
        }
    }
    api_response(['error' => 'Data tidak ditemukan.'], 404);
} catch (InvalidArgumentException $error) {
    api_response(['error' => $error->getMessage()], 422);
} catch (JsonException) {
    api_response(['error' => 'Data tidak dapat disimpan dalam format JSON.'], 500);
} catch (RuntimeException $error) {
    api_response(['error' => $error->getMessage()], 500);
}
