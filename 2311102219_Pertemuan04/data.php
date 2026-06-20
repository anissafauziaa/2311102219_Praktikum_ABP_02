<?php
header('Content-Type: application/json');

// Data profil dalam bentuk array 
$profil = [
    'nama'      => 'Tara',
    'pekerjaan' => 'Dokter',
    'lokasi'    => 'Sukabumi'
];

// Ubah array ke format JSON 
echo json_encode($profil);
?>