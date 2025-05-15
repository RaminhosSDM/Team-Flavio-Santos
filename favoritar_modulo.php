<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_modulo'])) {
    $id = intval($_POST['id_modulo']);
    $query = $conn->query("SELECT favorito FROM modulos WHERE id_modulo = $id");
    $modulo = $query->fetch_assoc();

    $novoFavorito = $modulo['favorito'] ? 0 : 1;
    $conn->query("UPDATE modulos SET favorito = $novoFavorito WHERE id_modulo = $id");
}

header("Location: modulos.php");
exit();
?>
