<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "INSERT INTO productos (nombre, descripcion, codigo_barras, stock, categoria) 
                VALUES (:nom, :desc, :barras, :stock, :cat)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom'    => $_POST['nombre'],
            ':desc'   => $_POST['descripcion'],
            ':barras' => $_POST['codigo_barras'],
            ':stock'  => $_POST['stock'],
            ':cat'    => $_POST['categoria']
        ]);
        
        header("Location: inventario.php?success=1");

    } catch (PDOException $excepcion) {
        die("Error al guardar: " . $e->getMessage());
    }
}