<?php
function sanitize_input($data) {
    if ($data === null) return "";
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
function redirect($url) {
    header("Location: " . $url);
    exit();
}
?>
