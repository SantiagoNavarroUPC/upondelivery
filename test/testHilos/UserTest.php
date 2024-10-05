<?php
use PHPUnit\Framework\TestCase;
class UserTest extends TestCase
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

    public function testGuardarUsuario()
    {
        // Datos del usuario a guardar
        $firstname = '';
        $lastname = '';
        $username = 'jlopez1';
        $password = '123';
        $type = 1; // 1: Administrador, 2: Personal, 3: Repartidor

        // Verificar si hay campos vacíos
        $this->assertNotEmpty($firstname, 'El campo "Nombre" no puede estar vacío');
        $this->assertNotEmpty($lastname, 'El campo "Apellido" no puede estar vacío');
        $this->assertNotEmpty($username, 'El campo "Username" no puede estar vacío');
        $this->assertNotEmpty($password, 'El campo "Password" no puede estar vacío');

        // Verificar el tipo de usuario
        $typeLabel = '';
        switch ($type) {
            case 1:
                $typeLabel = 'Administrador';
                break;
            case 2:
                $typeLabel = 'Personal';
                break;
            case 3:
                $typeLabel = 'Repartidor';
                break;
            default:
                $this->fail('El valor del tipo de usuario es inválido');
        }

        // Consulta SQL para insertar el usuario
        $sql = "INSERT INTO users (firstname, lastname, username, password, type)
                VALUES ('$firstname', '$lastname', '$username', '$password', '$type')";

        // Ejecutar la consulta
        $result = $this->conn->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        $this->assertTrue($result);

        // Mostrar los valores
        echo "Valores insertados:\n";
        echo "Nombre: $firstname\n";
        echo "Apellido: $lastname\n";
        echo "Username: $username\n";
        echo "Password: $password\n";
        echo "Tipo: $typeLabel\n";
    }
}

