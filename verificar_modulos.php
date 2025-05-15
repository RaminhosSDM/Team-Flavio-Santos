<?php
require 'conexao.php';

// Verificar todos os módulos
$sql = "SELECT * FROM modulos";
$result = $conn->query($sql);

echo "<pre>";
echo "Total de módulos encontrados: " . $result->num_rows . "\n\n";

while($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id_modulo'] . "\n";
    echo "Nome: " . $row['nome_modulo'] . "\n";
    echo "Nível: " . $row['nivel_modulo'] . "\n";
    echo "Descrição: " . $row['descricao_modulo'] . "\n";
    echo "------------------------\n";
}
echo "</pre>";

$result = $conn->query("SELECT id_modulo FROM modulos WHERE nome_modulo LIKE '%Avanc%' OR nome_modulo LIKE '%Avanç%' LIMIT 1");
?> 