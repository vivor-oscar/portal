<?php
/**
 * Migration script to add alumni_year, promotion_status and promotion_target to students table
 * and migrate existing "Old Student - YEAR" labels into structured data.
 *
 * Run from CLI (PowerShell) while XAMPP Apache & MySQL are running:
 * php tools/migrate_alumni_and_promotions.php
 */

include(__DIR__ . '/../includes/database.php');

echo "Starting migration...\n";

$queries = [
    "ALTER TABLE students ADD COLUMN IF NOT EXISTS alumni_year INT NULL",
    "ALTER TABLE students ADD COLUMN IF NOT EXISTS promotion_status VARCHAR(20) NULL",
    "ALTER TABLE students ADD COLUMN IF NOT EXISTS promotion_target VARCHAR(100) NULL",
];

foreach ($queries as $q) {
    echo "Running: $q\n";
    if ($conn->query($q) === TRUE) {
        echo "OK\n";
    } else {
        // Some MySQL versions don't support IF NOT EXISTS on ALTER for columns; ignore duplicate errors
        echo "Result: " . $conn->error . "\n";
    }
}

// Migrate existing class values like 'Old Student - 2024' into alumni_year and normalize class to 'Old Student'
$scanSql = "SELECT student_id, `class` FROM students WHERE `class` LIKE 'Old Student - %' OR `class` LIKE 'Old Student-%'";
$res = $conn->query($scanSql);
$count = 0;
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $sid = $conn->real_escape_string($r['student_id']);
        $cls = $r['class'];
        if (preg_match('/(\d{4})$/', $cls, $m)) {
            $year = (int)$m[1];
            $update = "UPDATE students SET alumni_year={$year}, `class`='Old Student' WHERE student_id='" . $sid . "'";
            if ($conn->query($update)) {
                $count++;
            } else {
                echo "Failed to migrate $sid: " . $conn->error . "\n";
            }
        }
    }
}

echo "Migrated $count students to alumni_year and normalized class.\n";

$conn->close();
echo "Done.\n";

?>
