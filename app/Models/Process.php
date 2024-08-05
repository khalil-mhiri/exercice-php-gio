<?php

namespace App\Models;

use DateTime;
use Exception;
use mysqli;

class Process
{
    public static function getAll(): array
    {
        // Database connection parameters
        $servername = 'localhost';
        $username = 'root'; // your MySQL username
        $password = ''; // your MySQL password
        $dbname = 'your_database'; // your database name

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            throw new Exception('Connection failed: ' . $conn->connect_error);
        }

        $transactions = [];
        $sql = "SELECT id, date, check_number, description, amount FROM transactions";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $transactions[] = $row;
            }
        }

        $conn->close();
        return $transactions;
    }
    public static function processCsv(string $filePath): void
    {
        // Database connection parameters
        $servername = 'localhost';
        $username = 'root'; // your MySQL username
        $password = ''; // your MySQL password
        $dbname = 'your_database'; // your database name

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            throw new Exception('Connection failed: ' . $conn->connect_error);
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle);

            // Prepare an SQL statement for inserting data
            $stmt = $conn->prepare("INSERT INTO transactions (date, check_number, description, amount) VALUES (?, ?, ?, ?)");

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $date = DateTime::createFromFormat('m/d/Y', $data[0])->format('Y-m-d');
                $check_number = !empty($data[1]) ? $data[1] : null;
                $description = $data[2];
                $amount = str_replace(['$', ','], '', $data[3]);

                $stmt->bind_param('sssd', $date, $check_number, $description, $amount);
                $stmt->execute();
            }

            fclose($handle);
            $stmt->close();
        } else {
            throw new Exception('Unable to open the file at path: ' . $filePath);
        }

        $conn->close();
    }
}
