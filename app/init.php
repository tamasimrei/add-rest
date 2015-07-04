<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
// (Re)initialize the database used by the application

$databaseFile = __DIR__ . '/data/add-rest.sq3';
unlink($databaseFile);

$pdo = new PDO('sqlite:' . $databaseFile);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = <<< EOS
CREATE TABLE addresses (
    id INTEGER PRIMARY KEY,
    name CHAR NOT NULL,
    phone CHAR,
    street CHAR
);
EOS;
$pdo->exec($sql);

$inputfile = fopen(__DIR__ . '/data/example.csv', 'r');
if (! $inputfile) {
    throw new Exception('Cannot open input file');
}

$insertStatement = $pdo->prepare(
    "INSERT INTO addresses (name, phone, street) VALUES (?, ?, ?)"
);
while (is_array($line = fgetcsv($inputfile, 255, ','))) {
    $insertStatement->execute($line);
}

@fclose($inputfile);
