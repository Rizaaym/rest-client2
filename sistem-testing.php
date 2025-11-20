<?php
// require_once "index.php"; // Ganti dengan file yang berisi fungsi utama aplikasi Anda
// Asumsi: Di sini kita menggunakan fungsi dummy untuk simulasi pengujian

// --- FUNGSI SIMULASI APLIKASI REST CLIENT (Ganti dengan fungsi API Anda yang sebenarnya) ---
/**
 * Mensimulasikan pengambilan data dari NewsAPI.org.
 * @param string $apiKey Kunci API yang digunakan
 * @param string $country Kode negara (misalnya, 'us')
 * @param string $category Kategori berita (misalnya, 'technology')
 * @return array Hasil respons API (simulasi)
 * @throws Exception Jika API Key tidak valid atau data tidak ditemukan
 */
function getDataFromApi($apiKey, $country, $category) {
    if ($apiKey === "INVALID_KEY_SIMULASI") {
        // Simulasi respon gagal (Error Autentikasi)
        throw new Exception("API Key Autentikasi Gagal: Invalid API Key.");
    }

    if ($category === "nonexistent") {
        // Simulasi respon gagal (Parameter tidak valid)
        throw new Exception("Parameter Gagal: Kategori 'nonexistent' tidak didukung.");
    }
    
    // Simulasi respon sukses dengan data valid
    return [
        'status' => 'ok',
        'articles' => [
            ['title' => 'Berita Teknologi 1'],
            ['title' => 'Berita Teknologi 2']
        ]
    ];
}

// --- FUNGSI UTAMA VALIDATOR / TEST RUNNER ---

/**
 * Fungsi untuk menjalankan satu Test Case.
 * @param string $id ID Test Case
 * @param string $description Deskripsi Uji
 * @param callable $testFunction Fungsi anonim yang berisi logika pengujian
 */
function runSystemTest($id, $description, $testFunction) {
    echo "\n[TEST RUNNER] Running Test Case: " . $id . " - " . $description . "...\n";
    
    try {
        $testFunction();
        echo "✅ PASS: Semua validasi berhasil.\n";
    } catch (Exception $e) {
        echo "❌ FAIL: " . $e->getMessage() . "\n";
    }
}


// --- 3 TEST CASE OTOMATIS ---

// 1. Test Case Positif: Memastikan pengambilan data sukses untuk parameter valid.
$validApiKey = "SIMULASI_VALID_KEY"; // Ganti dengan API Key valid Anda
runSystemTest("WB_API_001_VALID", "Pengambilan Berita Teknologi AS (Jalur Sukses)", function() use ($validApiKey) {
    // Aksi: Coba ambil data dengan parameter valid
    $result = getDataFromApi($validApiKey, 'us', 'technology'); 
    
    // Validasi 1: Memastikan status adalah 'ok'
    if (!isset($result['status']) || $result['status'] !== 'ok') {
        throw new Exception("Status respons API tidak 'ok'.");
    }

    // Validasi 2: Memastikan array artikel tidak kosong
    if (!isset($result['articles']) || count($result['articles']) === 0) {
        throw new Exception("Array artikel kosong atau tidak ditemukan.");
    }
});


// 2. Test Case Negatif: Memastikan aplikasi menangani API Key yang salah.
$invalidApiKey = "INVALID_KEY_SIMULASI";
runSystemTest("WB_API_002_AUTH_FAIL", "Otentikasi Gagal (Invalid API Key)", function() use ($invalidApiKey) {
    $expectedErrorMessage = "API Key Autentikasi Gagal";
    
    try {
        // Aksi: Coba ambil data dengan API Key yang salah
        getDataFromApi($invalidApiKey, 'us', 'technology');
        
        // Jika kode mencapai sini, berarti pengecualian (Exception) tidak dilempar, yang merupakan kegagalan
        throw new Exception("Error otentikasi GAGAL ditangkap, tidak ada Exception dilempar.");
        
    } catch (Exception $e) {
        // Validasi: Memastikan pesan error yang dilempar sesuai harapan
        if (strpos($e->getMessage(), $expectedErrorMessage) === false) {
            throw new Exception("Error ditangkap, namun pesan tidak sesuai harapan. Pesan diterima: " . $e->getMessage());
        }
        // Jika Exception ditangkap dan pesan sesuai, dianggap PASS (karena berhasil menangani error)
    }
});


// 3. Test Case Negatif: Memastikan aplikasi menangani parameter kategori yang tidak didukung.
runSystemTest("WB_API_003_PARAM_FAIL", "Parameter Kategori Tidak Valid", function() use ($validApiKey) {
    $expectedErrorMessage = "Parameter Gagal";
    
    try {
        // Aksi: Coba ambil data dengan parameter kategori yang tidak valid
        getDataFromApi($validApiKey, 'us', 'nonexistent');
        
        // Jika kode mencapai sini, berarti pengecualian (Exception) tidak dilempar
        throw new Exception("Error parameter GAGAL ditangkap, tidak ada Exception dilempar.");
        
    } catch (Exception $e) {
        // Validasi: Memastikan pesan error yang dilempar sesuai harapan
        if (strpos($e->getMessage(), $expectedErrorMessage) === false) {
            throw new Exception("Error ditangkap, namun pesan tidak sesuai harapan. Pesan diterima: " . $e->getMessage());
        }
        // Jika Exception ditangkap dan pesan sesuai, dianggap PASS
    }
});

?>