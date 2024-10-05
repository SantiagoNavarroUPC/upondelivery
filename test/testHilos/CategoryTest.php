<?php
use PHPUnit\Framework\TestCase;
class CategoryTest extends TestCase
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

    public function testCategorySave()
    {
        // Prepare test data
        $category_name = "";
        $category_description = "Se entrega por motocicletas";
        $category_status = 1;

        // Verificar si hay campos vacíos
        $this->assertNotEmpty($category_name, 'El campo "Nombre de categoría" no puede estar vacío');

        // Consulta SQL para insertar la categoría
        $sql = "INSERT INTO category_list (name, description, status)
                VALUES ('$category_name', '$category_description', '$category_status')";

        // Ejecutar la consulta
        $result = $this->conn->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        $this->assertTrue($result);

        // Mostrar los valores
        echo "Valores insertados:\n";
        echo "Nombre de categoría: $category_name\n";
        echo "Descripción de categoría: $category_description\n";
        echo "Estado de categoría: " . ($category_status == 1 ? "Activa" : "Inactiva") . "\n";
    }
}


