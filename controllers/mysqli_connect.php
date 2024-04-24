<?php

// // Define constants
// define('DB_HOST', 'lhcp1074.webapps.net');
// define('DB_USER', 'o328uxbf_jgs');
// define('DB_PASSWORD', '4X8RnF0TlJw6');
// define('DB_NAME', 'o328uxbf_salvavidas');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '21yDs##SK9');
define('DB_NAME', 'senilife');

try {
$conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
  die();
}


// Tratar as requecições para evitar ataques
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (!is_array($value)) {
            $_POST[$key] = htmlspecialchars($value);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    foreach ($_GET as $key => $value) {
        if (!is_array($value)) {
            $_GET[$key] = htmlspecialchars($value);
        }
    }
}

// Define encryption and decryption functions

function gs_encrypt($value2encrypt)
{
    if (empty($value2encrypt))
        return $value2encrypt;
    else {
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($value2encrypt, $cipher, DB_PASSWORD, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, DB_PASSWORD, $as_binary = true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }
}

function gs_decrypt($value2decrypt)
{
    if (empty($value2decrypt)) {
        return $value2decrypt;
    } else {
        $c = base64_decode($value2decrypt);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, DB_PASSWORD, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, DB_PASSWORD, $as_binary = true);
        if (hash_equals($hmac, $calcmac))
            return $original_plaintext;
        else
            return false;
    }
}

