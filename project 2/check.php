<?php
require 'config.php';

echo "Duke testuar lidhjen...<br>";

try {
    $res = $pdo->query("SHOW TABLES")->fetchAll();
    echo "✅ Lidhja me DB është aktive!<br>";
    echo "Tabelat ekzistuese: ";
    foreach ($res as $r) {
        echo $r[0] . " ";
    }
} catch (Exception $e) {
    echo "❌ Gabim: " . $e->getMessage();
}