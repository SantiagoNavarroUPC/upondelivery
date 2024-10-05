<?php
use PHPUnit\Framework\TestCase;

class SalesTestError extends TestCase {

    protected $db;

    protected function setUp(): void {
        $this->db = new mysqli('localhost', 'root', '', 'cscs_db');
    }

    public function testCanSaveSale() {
        // Preparar los datos del pedido
        $code = "2023567890088";
        $client = "AAAAAAAAAAAAAAAAAAAAAAAAAAA";
        $amount = 10000000000000000;
        $payment_type = 2;
        $payment_code = "245669361478";

        // Guardar el pedido en la base de datos
        $sql = "INSERT INTO sale_list (code,client, amount, payment_type, payment_code) VALUES ('$code','$client', $amount, '$payment_type', '$payment_code')";
        $result = $this->db->query($sql);

        // Verificar si se guardó correctamente
        $this->assertEquals(true, $result);

        // Limpiar la base de datos
        //$sql = "DELETE FROM sale_list WHERE id = '$id'";
        //$this->db->query($sql);
    }

    protected function tearDown(): void {
        $this->db->close();
    }
}
