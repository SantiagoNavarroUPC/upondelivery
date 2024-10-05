<?php
use PHPUnit\Framework\TestCase;

class UserTestError extends TestCase
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
        $firstname = '123456789012345678901234567890123456789012345678951';
        $lastname = '123456789012345678901234567890123456789012345678951';
        $username = '12345678911';
        $password = 'myp';
        $type = 2;

        // Consulta SQL para insertar el usuario
        $sql = "INSERT INTO users (firstname, lastname, username, password, type)
                VALUES ('$firstname', '$lastname', '$username', '$password', '$type')";

        // Ejecutar la consulta
        $result = $this->conn->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        $this->assertTrue($result);
    }
}
