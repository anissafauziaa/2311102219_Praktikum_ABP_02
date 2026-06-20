<?php

// ===============================
// Function menghitung nilai akhir
// ===============================
function hitungNilaiAkhir($tugas, $uts, $uas)
{
    return ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);
}

// ===============================
// Function menentukan grade
// ===============================
function tentukanGrade($nilai)
{
    if ($nilai >= 85) {
        return "A";
    } elseif ($nilai >= 75) {
        return "B";
    } elseif ($nilai >= 65) {
        return "C";
    } elseif ($nilai >= 55) {
        return "D";
    } else {
        return "E";
    }
}


$mahasiswa = [
    [
        "nama" => "Anita",
        "nim" => "2311102220",
        "tugas" => 80,
        "uts" => 75,
        "uas" => 75
    ],
    [
        "nama" => "Bagas",
        "nim" => "2311102221",
        "tugas" => 70,
        "uts" => 65,
        "uas" => 75
    ],
    [
        "nama" => "Chika",
        "nim" => "2311102222",
        "tugas" => 85,
        "uts" => 88,
        "uas" => 95
    ],
    [
        "nama" => "Davin",
        "nim" => "2311102223",
        "tugas" => 65,
        "uts" => 70,
        "uas" => 72
    ],
    [
        "nama" => "Emili",
        "nim" => "2311102224",
        "tugas" => 79,
        "uts" => 88,
        "uas" => 75
    ],
    [
        "nama" => "Fitrah",
        "nim" => "2311102225",
        "tugas" => 57,
        "uts" => 68,
        "uas" => 65
    ],
    [
        "nama" => "Gilang",
        "nim" => "2311102226",
        "tugas" => 57,
        "uts" => 0,
        "uas" => 60
    ]
];

$totalNilai = 0;
$nilaiTertinggi = 0;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Sistem Penilaian Mahasiswa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #ddd;
        }
    </style>
</head>

<body>

    <h2>Data Nilai Mahasiswa</h2>

    <table>

        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Nilai Tugas</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Nilai Akhir</th>
            <th>Grade</th>
            <th>Status</th>
        </tr>

        <?php

        foreach ($mahasiswa as $m) {

            $nilaiAkhir = hitungNilaiAkhir($m["tugas"], $m["uts"], $m["uas"]);
            $grade = tentukanGrade($nilaiAkhir);

            // Status kelulusan
            if ($nilaiAkhir >= 60) {
                $status = "Lulus";
            } else {
                $status = "Tidak Lulus";
            }

            $totalNilai += $nilaiAkhir;

            if ($nilaiAkhir > $nilaiTertinggi) {
                $nilaiTertinggi = $nilaiAkhir;
            }

            echo "<tr>";
            echo "<td>" . $m["nama"] . "</td>";
            echo "<td>" . $m["nim"] . "</td>";
            echo "<td>" . $m["tugas"] . "</td>";
            echo "<td>" . $m["uts"] . "</td>";
            echo "<td>" . $m["uas"] . "</td>";
            echo "<td>" . number_format($nilaiAkhir, 2) . "</td>";
            echo "<td>" . $grade . "</td>";
            echo "<td>" . $status . "</td>";
            echo "</tr>";
        }

        $rataRata = $totalNilai / count($mahasiswa);

        ?>

    </table>

    <br>

    <h3>Rata-rata Kelas : <?php echo number_format($rataRata, 2); ?></h3>
    <h3>Nilai Tertinggi : <?php echo number_format($nilaiTertinggi, 2); ?></h3>

</body>

</html>