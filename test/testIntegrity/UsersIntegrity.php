<?php 
class UserManagement {
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

    public function addUser($firstname, $lastname, $username, $password, $type) {
        // Encrypt the password with MD5
        $encryptedPassword = md5($password);

        // Insert user into the database
        $sql = "INSERT INTO users (firstname, lastname, username, password, type) VALUES ('$firstname', '$lastname', '$username', '$encryptedPassword', '$type')";
        if ($this->conn->query($sql) === TRUE) {
            echo "Usuario agregado exitosamente.\n";
        } else {
            echo "Error al agregar el usuario: " . $this->conn->error . "\n";
        }
    }

    public function updateUser($nombre, $firstname, $lastname, $username, $password, $type) {
        // Encrypt the password with MD5
        $encryptedPassword = md5($password);
    
        // Update user in the database
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', username='$username', password='$encryptedPassword', type='$type' WHERE firstname='$nombre'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Usuario actualizado exitosamente.\n";
        } else {
            echo "Error al actualizar el usuario: " . $this->conn->error . "\n";
        }
    }
    

    public function deleteUser($nombre) {
        // Delete user from the database
        $sql = "DELETE FROM users WHERE firstname='$nombre'";
        if ($this->conn->query($sql) === TRUE) {
            echo "Usuario eliminado exitosamente.\n";
        } else {
            echo "Error al eliminar el usuario: " . $this->conn->error . "\n";
        }
    }

    public function showMenu() {
        echo "Bienvenido al menú de gestión de usuarios.\n";

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
                // Autenticación exitosa y usuario es administrador
                // Mostrar el menú de gestión de usuarios
                while (true) {
                    echo "\nMenú de opciones:\n";
                    echo "1. Agregar usuario\n";
                    echo "2. Modificar usuario\n";
                    echo "3. Eliminar usuario\n";
                    echo "4. Salir\n";
                    $choice = readline("Seleccione una opción: ");

                    switch ($choice) {
                        case "1":
                            $firstname = readline("Ingrese el nombre: ");
                            $lastname = readline("Ingrese el apellido: ");
                            $newUsername = readline("Ingrese el nombre de usuario: ");
                            $newPassword = readline("Ingrese la contraseña: ");
                            $newtype = readline("Ingrese el tipo de usuario: ");
                            $this->addUser($firstname, $lastname, $newUsername, $newPassword, $newtype);
                            break;
                        case "2":
                            $nombre = readline("Ingrese el nombre del usuario a modificar: ");
                            $firstname = readline("Ingrese el nuevo nombre: ");
                            $lastname = readline("Ingrese el nuevo apellido: ");
                            $newUsername = readline("Ingrese el nuevo nombre de usuario: ");
                            $newPassword = readline("Ingrese la nueva contraseña: ");
                            $newtype = readline("Ingrese el tipo de usuario: ");
                            $this->updateUser($nombre, $firstname, $lastname, $newUsername, $newPassword, $newtype);
                            break;
                        case "3":
                            $nombre = readline("Ingrese el nombre del usuario a eliminar: ");
                            $this->deleteUser($nombre);
                            break;
                        case "4":
                            echo "PRUEBA OK\n";
                            return;
                        default:
                            echo "Opción inválida. Por favor, seleccione una opción válida.\n";
                    }
                }
            } else {
                // Autenticación exitosa pero usuario no es administrador
                echo "No tienes permisos de administrador para acceder al menú de gestión de usuarios.\n";
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

$userManagement = new UserManagement();
$userManagement->showMenu();
$userManagement->closeConnection();
