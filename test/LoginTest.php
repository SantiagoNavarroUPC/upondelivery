<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testInvalidLogin()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/cscs/admin/login.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=admin1&password=admin1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $this->assertStringContainsString('Nombre de usuario o contraseña incorrecta', $response);
    }
}


