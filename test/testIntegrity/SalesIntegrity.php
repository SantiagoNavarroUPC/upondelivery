
<?php
class SalesManagement {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "cscs_db";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function addSale($clientName, $amount, $paymentType, $paymentCode = null) {
        // Insert sale into the database
        $sql = "INSERT INTO sale_list (client_name, amount, payment_type, payment_code) VALUES ('$clientName', '$amount', '$paymentType', '$paymentCode')";
        if ($this->conn->query($sql) === TRUE) {
            $saleId = $this->conn->insert_id;
            echo "Pedido agregado exitosamente. ID del pedido: $saleId\n";
        } else {
            echo "Error al agregar el pedido: " . $this->conn->error . "\n";
        }
    }

    public function updateSale($saleId, $clientName, $amount, $paymentType, $paymentCode = null) {
        // Update sale in the database
        $sql = "UPDATE sale_list SET client_name='$clientName', amount='$amount', payment_type='$paymentType', payment_code='$paymentCode' WHERE id='$saleId'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Pedido actualizado exitosamente.\n";
        } else {
            echo "Error al actualizar el pedido: " . $this->conn->error . "\n";
        }
    }

    public function deleteSale($saleId) {
        // Delete sale from the database
        $sql = "DELETE FROM sale_list WHERE id='$saleId'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Pedido eliminado exitosamente.\n";
        } else {
            echo "Error al eliminar el pedido: " . $this->conn->error . "\n";
        }
    }

    public function showMenu() {
        echo "Bienvenido a la Prueba de Integracion del módulo de gestión de pedidos.\n";

        // Solicitar datos de inicio de sesión al usuario
        $username = readline("Ingrese su nombre de usuario: ");
        $password = readline("Ingrese su contraseña: ");
        $encryptedPassword = md5($password);

        // Verificar la autenticidad del usuario en la base de datos
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$encryptedPassword'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $type = $user['type'];

            if ($type == 1 || $type == 2) {
                // Autenticación exitosa y usuario es administrador, mostrar el menú de gestión de pedidos
                while (true) {
                    echo "\nMenú de opciones:\n";
                    echo "1. Agregar pedido\n";
                    echo "2. Modificar pedido\n";
                    echo "3. Eliminar pedido\n";
                    echo "4. Salir\n";
                    $choice = readline("Seleccione una opción: ");

                    switch ($choice) {
                        case "1":
                            $clientName = readline("Ingrese el nombre del cliente: ");
                            $amount = readline("Ingrese el monto del pedido: ");
                            $paymentType = readline("Ingrese el tipo de pago: ");

                            if ($type == 2 || $type == 3) {
                                $paymentCode = readline("Ingrese el código de pago: ");
                                $this->addSale($clientName, $amount, $paymentType, $paymentCode);
                            } else {
                                $this->addSale($clientName, $amount, $paymentType);
                            }

                            break;
                        case "2":
                            $saleId = readline("Ingrese el ID del pedido a modificar: ");
                            $clientName = readline("Ingrese el nuevo nombre del cliente: ");
                            $amount = readline("Ingrese el nuevo monto del pedido: ");
                            $paymentType = readline("Ingrese el nuevo tipo de pago: ");

                            if ($type == 2 || $type == 3) {
                                $paymentCode = readline("Ingrese el nuevo código de pago: ");
                                $this->updateSale($saleId, $clientName, $amount, $paymentType, $paymentCode);
                            } else {
                                $this->updateSale($saleId, $clientName, $amount, $paymentType);
                            }

                            break;
                        case "3":
                            $saleId = readline("Ingrese el ID del pedido a eliminar: ");
                            $this->deleteSale($saleId);
                            break;
                        case "4":
                            echo "PRUEBA OK\n";
                            return;
                        default:
                            echo "Opción inválida. Por favor, seleccione una opción válida.\n";
                    }
                }
            } else {
                echo "No tienes permisos. Acceso denegado.\n";
            }
        } else {
            // Autenticación fallida
            echo "Inicio de sesión fallido. Usuario no válido.\n";
        }
    }
}

$salesManagement = new SalesManagement();
$salesManagement->showMenu();
