<?php
use PHPUnit\Framework\TestCase;
class SalesTest extends TestCase
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

    public function testCanSaveSale()
    {
        // Preparar los datos del pedido
        $code = "2023567890088";
        $client = "";
        $amount = 100000;
        $payment_type = 1;
        $payment_code = "";

        // Obtener el nombre del tipo de pago
        $payment_type_name = "";
        switch ($payment_type) {
            case 1:
                $payment_type_name = "Efectivo";
                break;
            case 2:
                $payment_type_name = "Tarjeta de débito";
                break;
            case 3:
                $payment_type_name = "Tarjeta de crédito";
                break;
            default:
                $payment_type_name = "Desconocido";
        }

        // Consulta SQL para insertar el pedido
        $sql = "INSERT INTO sale_list (code, client_name, amount, payment_type, payment_code)
                VALUES ('$code', '$client', $amount, '$payment_type', '$payment_code')";

        // Ejecutar la consulta
        $result = $this->conn->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        $this->assertTrue($result);

        // Mostrar los valores
        echo "Valores insertados:\n";
        echo "Código de venta: $code\n";
        echo "Cliente: $client\n";
        echo "Monto: $amount\n";
        echo "Tipo de pago: $payment_type_name\n";
        echo "Código de pago: $payment_code\n";
    }
}


