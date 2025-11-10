<?php
// Quick script to convert CSV to SQL INSERT statements with proper escaping
$csvFile = 'huisarts.csv';
$sqlOutput = '';

// Function to properly escape strings for SQL
function escapeSqlString($str) {
    return str_replace("'", "''", $str);
}

if (($handle = fopen($csvFile, "r")) !== FALSE) {
    $rowCount = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $rowCount++;
        
        // Skip header row if it exists
        if ($rowCount == 1 && !is_numeric($data[0])) {
            continue;
        }
        
        // Convert date format from M/D/YYYY to YYYY-MM-DD
        $dob = DateTime::createFromFormat('n/j/Y', $data[9])->format('Y-m-d');
        $created = DateTime::createFromFormat('n/j/Y', $data[10])->format('Y-m-d H:i:s');
        $updated = DateTime::createFromFormat('n/j/Y', $data[11])->format('Y-m-d H:i:s');
        
        // Escape special characters in string fields
        $patient_id = (int)$data[0];
        $first_name = escapeSqlString($data[1]);
        $last_name = escapeSqlString($data[2]);
        $address = escapeSqlString($data[3]);
        $house_number = escapeSqlString($data[4]);
        $city = escapeSqlString($data[6]);
        $phone = escapeSqlString($data[7]);
        $email = escapeSqlString($data[8]);
        
        // Handle NULL postcodes
        $postcode = empty($data[5]) ? 'NULL' : "'" . escapeSqlString($data[5]) . "'";
        
        $sqlOutput .= "({$patient_id}, '{$first_name}', '{$last_name}', '{$address}', '{$house_number}', {$postcode}, '{$city}', '{$phone}', '{$email}', '{$dob}', '{$created}', '{$updated}'),\n";
    }
    fclose($handle);
}

// Output the complete SQL
echo "-- Complete INSERT statement for all patient records\n";
echo "INSERT INTO patients (patient_id, first_name, last_name, address, house_number, postcode, city, phone, email, date_of_birth, created_at, updated_at) VALUES\n";
echo rtrim($sqlOutput, ",\n") . ";\n";
?>
