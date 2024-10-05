<?php
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Conectar a la base de datos
        $this->conn = new mysqli('localhost', 'root', '', 'cscs_db');

        if ($this->conn->connect_error) {
            die('Conexión fallida: ' . $this->conn->connect_error);
        }
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos
        $this->conn->close();
    }

    public function testSaveProductToDatabase()
    {
        // Datos del producto a guardar
        $product = [
            'category_id' => '',
            'name' => 'Producto de prueba',
            'description' => 'Descripción del producto de prueba',
            'price' => 9999,
            'status' => 1
        ];

        // Verificar si hay campos vacíos
        foreach ($product as $key => $value) {
            $this->assertNotEmpty($value, 'El campo "'.$key.'" no puede estar vacío');
        }

        // Consulta SQL para insertar el producto
        $sql = "INSERT INTO product_list (category_id, name, description, price, status)
                VALUES ('".$product['category_id']."', '".$product['name']."', '".$product['description']."', '".$product['price']."', '".$product['status']."')";

        // Ejecutar la consulta
        $result = $this->conn->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        $this->assertTrue($result);

        // Mostrar los valores
        echo "Valores insertados:\n";
        echo "ID de categoría: ".$product['category_id']."\n";
        echo "Nombre de producto: ".$product['name']."\n";
        echo "Descripción de producto: ".$product['description']."\n";
        echo "Precio de producto: ".$product['price']."\n";
        echo "Estado de producto: ".($product['status'] == 1 ? "Activo" : "Inactivo")."\n";
    }
}
