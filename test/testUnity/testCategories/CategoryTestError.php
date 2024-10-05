<?php
use PHPUnit\Framework\TestCase;

class CategoryTestError extends TestCase {

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
        $category_name = "123456789012345678901234567890123456789012345678951";
        $category_description = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678101";
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
