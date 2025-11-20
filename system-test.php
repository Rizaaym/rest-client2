<?php
// system-test.php
// White Box Testing untuk REST Client NewsAPI.org menggunakan try-catch
// Output: PASS / FAIL

function testNewsApiConnection() {
    $apiKey = "15e4d9d307424160ace92aec43c2fd95";
    $url = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" . $apiKey;

    try {
        // Eksekusi permintaan
        $response = file_get_contents($url);

        // Jika respons diterima dan tidak kosong
        if ($response !== false && !empty($response)) {
            echo "WB-TC-01: PASS - API dapat diakses dan menghasilkan respons.\n";
        } else {
            echo "WB-TC-01: FAIL - Respons API kosong atau tidak valid.\n";
        }

    } catch (Exception $e) {
        // Jika terjadi error/tidak bisa mengakses API
        echo "WB-TC-01: FAIL - Terjadi error saat mengakses API: " . $e->getMessage() . "\n";
    }
}

// Jalankan Test Case
testNewsApiConnection();
?>
