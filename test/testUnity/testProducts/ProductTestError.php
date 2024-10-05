<?php
use PHPUnit\Framework\TestCase;

class ProductTestError extends TestCase
{
    public function testSaveProductToDatabase()
    {
        // Datos del producto a guardar
        $product = [
            'category_id' => 1,
            'name' => '123456789012345678901234567890123456789012345678951',
            'description' => 'Descripción del producto de prueba',
            'price' => 999,
            'status' => 1
        ];
        
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cscs_db";
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Verificar si hay algún error en la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        // Query para insertar el producto en la tabla
        $sql = "INSERT INTO product_list (category_id, name, description, price, status)
                VALUES ('".$product['category_id']."', '".$product['name']."', '".$product['description']."', '".$product['price']."', '".$product['status']."')";
        
        // Ejecutar la query
        if ($conn->query($sql) === TRUE) {
            $result = "ok";
        } else {
            $result = "error";
        }
        
        // Cerrar la conexión
        $conn->close();
        
        // Verificar si el resultado es correcto
        $this->assertEquals("ok", $result);
    }
}
