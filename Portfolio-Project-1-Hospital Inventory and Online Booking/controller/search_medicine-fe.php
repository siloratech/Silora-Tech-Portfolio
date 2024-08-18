<?php
include 'db_con.php';

// Get the search ID from the POST request
$search_id = isset($_POST['search_id']) ? $_POST['search_id'] : '';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to search for retail medicines by ID
$query = $conn->prepare("SELECT category, medicine_id, name, description, brand, manufacturer, price, quantity_available, expiry_date, batch_number, dosage_form, strength, prescription_required FROM medicines WHERE medicine_id = ?");
$query->bind_param("i", $search_id);
$query->execute();
$result = $query->get_result();

// Generate HTML for search results
if ($result->num_rows > 0) {
    echo '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Manufacturer</th>
                    <th>Quantity Available</th>
                   
                    <th>Strength</th>
                    <th>Prescription Required</th>
                    <th>Price (Rs)</th>
                    <th>Discount (%)</th>
                    <th>Price after Discount (Rs)</th>
          
                </tr>
            </thead>
            <tbody>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row["category"].'-'.$row["medicine_id"], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["description"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["brand"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["manufacturer"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["quantity_available"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
               
                <td>' . htmlspecialchars($row["strength"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["prescription_required"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["price"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["batch_number"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($row["dosage_form"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
       
            </tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Manufacturer</th>
                    <th>Quantity Available</th>
                    <th>Expiry Date</th>
                    <th>Strength</th>
                    <th>Prescription Required</th>
                    <th>Price (Rs)</th>
                    <th>Discount (%)</th>
                    <th>Price after Discount (Rs)</th>
                
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="13">No retail medicines found with the provided ID.</td></tr>
            </tbody>
        </table>';
}

$query->close();
$conn->close();
?>
