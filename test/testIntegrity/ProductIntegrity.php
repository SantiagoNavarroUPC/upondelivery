
<?php
class ProductManagement {
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

    public function addProduct($categoryID, $name, $description, float $price, int $status) {
        // Insert product into the database
        $sql = "INSERT INTO product_list (category_id, name, description, price, status) VALUES ('$categoryID', '$name', '$description', '$price', '$status')";
        if ($this->conn->query($sql) === TRUE) {
            echo "Producto agregado exitosamente.\n";
        } else {
            echo "Error al agregar el producto: " . $this->conn->error . "\n";
        }
    }

    public function updateProduct($productName, $name, $description, float $price, int $status) {
        // Update product in the database
        $sql = "UPDATE product_list SET name='$name', description='$description', price='$price', status='$status' WHERE name='$productName'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Producto actualizado exitosamente.\n";
        } else {
            echo "Error al actualizar el producto: " . $this->conn->error . "\n";
        }
    }

    public function deleteProduct($productName) {
        // Delete product from the database
        $sql = "DELETE FROM product_list WHERE name='$productName'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Producto eliminado exitosamente.\n";
        } else {
            echo "Error al eliminar el producto: " . $this->conn->error . "\n";
        }
    }

    public function showMenu() {
        echo "Bienvenido a la Prueba de Integracion del modulo gestión de productos.\n";
    
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
                // Autenticación exitosa y usuario es administrador, mostrar el menú de gestión de productos
                while (true) {
                    echo "\nMenú de opciones:\n";
                    echo "1. Agregar producto\n";
                    echo "2. Modificar producto\n";
                    echo "3. Eliminar producto\n";
                    echo "4. Salir\n";
                    $choice = readline("Seleccione una opción: ");
    
                    switch ($choice) {
                        case "1":
                            // Mostrar las categorías disponibles
                            $categorySql = "SELECT * FROM category_list";
                            $categoryResult = $this->conn->query($categorySql);
    
                            if ($categoryResult->num_rows > 0) {
                                echo "\nCategorías disponibles:\n";
                                while ($category = $categoryResult->fetch_assoc()) {
                                    echo "ID: " . $category['id'] . ", Nombre: " . $category['name'] . "\n";
                                }
    
                                // Solicitar información del producto al usuario
                                $categoryID = readline("Ingrese el ID de la categoría: ");
                                $name = readline("Ingrese el nombre del producto: ");
                                $description = readline("Ingrese la descripción del producto: ");
                                $price = readline("Ingrese el precio del producto: ");
                                $status = readline("Ingrese el estado del producto: ");
                                $this->addProduct($categoryID, $name, $description, $price, $status);
                            } else {
                                echo "No hay categorías disponibles. Agregue categorías antes de agregar productos.\n";
                            }
    
                            break;
                        case "2":
                            $productName = readline("Ingrese el nombre del producto a modificar: ");
                            $name = readline("Ingrese el nuevo nombre del producto: ");
                            $description = readline("Ingrese la nueva descripción del producto: ");
                            $price = readline("Ingrese el nuevo precio del producto: ");
                            $status = readline("Ingrese el nuevo estado del producto: ");
                            $this->updateProduct($productName, $name, $description, $price, $status);
                            break;
                        case "3":
                            $productName = readline("Ingrese el nombre del producto a eliminar: ");
                            $this->deleteProduct($productName);
                            break;
                        case "4":
                            echo "Saliendo del menú de gestión de productos...\n";
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

$productManagement = new ProductManagement();
$productManagement->showMenu();
