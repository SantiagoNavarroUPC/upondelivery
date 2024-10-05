<?php
class CategoryManagement {
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

    public function addCategory($name, $description, int $status) {
        // Insert category into the database
        $sql = "INSERT INTO category_list (name, description, status) VALUES ('$name', '$description', '$status')";
        if ($this->conn->query($sql) === TRUE) {
            echo "Categoría agregada exitosamente.\n";
        } else {
            echo "Error al agregar la categoría: " . $this->conn->error . "\n";
        }
    }

    public function updateCategory($name, $newName, $description, int $status) {
        // Update category in the database
        $sql = "UPDATE category_list SET name='$newName', description='$description', status='$status' WHERE name='$name'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Categoría actualizada exitosamente.\n";
        } else {
            echo "Error al actualizar la categoría: " . $this->conn->error . "\n";
        }
    }

    public function deleteCategory($name) {
        // Delete category from the database
        $sql = "DELETE FROM category_list WHERE name='$name'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Categoría eliminada exitosamente.\n";
        } else {
            echo "Error al eliminar la categoría: " . $this->conn->error . "\n";
        }
    }

    public function showMenu() {
        echo "Bienvenido a la Prueba de Integracion del modulo gestión de categorías.\n";

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

            if ($type == 1) {
                while (true) {
                    // Mostrar el menú de opciones para el administrador
                    echo "\nMenú de opciones:\n";
                    echo "1. Agregar categoría\n";
                    echo "2. Modificar categoría\n";
                    echo "3. Eliminar categoría\n";
                    echo "4. Salir\n";
                    $choice = readline("Seleccione una opción: ");

                    switch ($choice) {
                        case "1":
                            $name = readline("Ingrese el nombre de la categoría: ");
                            $description = readline("Ingrese la descripción de la categoría: ");
                            $status = readline("Ingrese el estado de la categoría: ");
                            $this->addCategory($name, $description,$status);
                            break;
                        case "2":
                            $currentName = readline("Ingrese el nombre de la categoría a modificar: ");
                            $newName = readline("Ingrese el nuevo nombre de la categoría: ");
                            $description = readline("Ingrese la nueva descripción de la categoría: ");
                            $status = readline("Ingrese el nuevo estado de la categoría: ");
                            $this->updateCategory($currentName, $newName, $description, $status);
                            break;
                        case "3":
                            $name = readline("Ingrese el nombre de la categoría a eliminar: ");
                            $this->deleteCategory($name);
                            break;
                        case "4":
                            echo "Prueba OK\n";
                            return;
                        default:
                            echo "Opción inválida. Por favor, seleccione una opción válida.\n";
                    }
                }
            } else {
                echo "No tienes permisos de administrador. Acceso denegado.\n";
            }
        } else {
            // Autenticación fallida
            echo "Inicio de sesión fallido. Usuario no válido.\n";
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

$categoryManagement = new CategoryManagement();
$categoryManagement->showMenu();
$categoryManagement->closeConnection();
