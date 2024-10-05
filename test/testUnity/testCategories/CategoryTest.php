<?php
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase {

    public function testCategorySave() {
        
        // Connect to database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "cscs_db";

        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare test data
        $category_name = "categoria prueba";
        $category_description = "Categoria prueba";
        $category_status = 1 ;

        // Insert test data into database
        $sql = "INSERT INTO category_list (name, description, status) VALUES ('$category_name', '$category_description', '$category_status')";
        $result = $conn->query($sql);

        // Check if insert was successful
        $this->assertTrue($result);

        // Close database connection
        $conn->close();
    }

}
