<?php
require 'vendor/autoload.php'; // Sesuaikan path autoload.php sesuai dengan proyek Anda

use PhpOffice\PhpSpreadsheet\IOFactory;

// Tentukan path file Excel yang akan diimpor
$excelFilePath = 'rpjurnal.xls';

// Tentukan path untuk menyimpan file CSV
$csvFilePath = 'file_excel_new.csv';

// Load file Excel
$spreadsheet = IOFactory::load($excelFilePath);

// Ambil data dari sheet pertama (indeks 0)
$sheet = $spreadsheet->getActiveSheet();

$data = $sheet->toArray();

// OLAH DATA

// HEADING BY INDEX
$noAccountIndex = [];
$noAccountItem = [];
foreach ($data as $key => $row) {
    foreach ($row as $key2 => $val2) {
        if (strpos($val2, 'No Account') !== false) { 
            $noAccountIndex[] = $key; // start index = 10
            $noAccountItem[] = $key+1; // start index = 11
        }
    }
}

// print_r($noAccountIndex);
// return false;

// GET HEAD DATA BY INDEX
$dataHead = array();
$noHead = 0;
foreach ($data as $key => $row) {
  $noHead++;
  if(in_array($noHead,$noAccountIndex)){ // looping sampai $noHead ada didalam array $noAccountIndex
    // print_r($row);
    // echo "<br>";
    $itemIndex = array($noHead); // +2
    // $dataHead[] = array_merge($itemIndex,$row);
    $dataHead[] = array_merge($row);
    // echo "item ".$itemIndex."<br>";
    // echo $itemIndex."<br>";
  }
  // if(in_array($itemIndex,$noAccountIndex)){
  //   print_r($row);
  //   echo "<br>";
  // }
}

$dataHead = array_values($dataHead);
// print_r($dataHead);
// return false;

// DAPATKAN RANGE DATA BASED ON KEY 0 TIDAK BOLEH KOSONG
// $dataItem = array();
// foreach ($data as $key => $row) {
//   $keyItem = $key+1;
//   foreach($dataHead as $kHead => $rHead){
//     if ($rHead[0] === $keyItem) {
//       $dataItem[] = array_unique(array_merge($rHead,$row));
//     }
//   }
//   if($keyItem == $dataHead[0]){
//     echo $keyItem."<br>";
//     print_r($dataHead);
//     echo "<br>";
//     print_r($row);
//     echo "<br>";
//   }
//   if($key > 8){
//     $keyItem = $key+1;
//     if (strpos($row[0], 'No Account') === false
//     //       strpos($row, 'Account') === false ||
//     //       strpos($row, 'Debet') === false ||
//     //       strpos($row, 'Kredit') === false
//     ){
//       if(!empty($row[0])){
//         // echo $keyItem." - ";
//         // echo "<br>";
//         // print_r($dataHead[0]);
//         // echo "<br>";
//         // print_r($row);
//         // echo "<br>";
//         $dataItem[] = array_merge($dataHead[0],$row);
//         // $keyItemx = array($keyItem);
//         // $dataItem[] = array_merge($keyItemx,$row);
//       }
//     }
//     // if(in_array($keyItem,$dataHead[0])){
//     //   if(!empty($row[0])){
//     //     print_r($row);
//     //     echo "<br>";
//     //   }
//     // }
//   }
// }

// print_r($dataItem);
// return false;

// foreach ($dataHead as &$subArrayHead) {
//     // Mengosongkan nilai kunci nomor 1 pada setiap array
//     $subArrayHead[1] = ''; // Atau $subArray[1] = ''; untuk mengosongkan dengan string kosong
// }

// print_r($dataHead);
// return false;
// $dataItem = $dataHead;

// DAPATKAN RANGE DATA BASED ON KEY 0 TIDAK BOLEH KOSONG
$dataItem = array();
$date = array();
foreach ($data as $key => $row) {
  if($key > 8){
    $keyItem = $key+1;
    if (strpos($row[0], 'No Account') === false
          // strpos($row, 'Account') === false ||
          // strpos($row, 'Debet') === false ||
          // strpos($row, 'Kredit') === false
    ){
      if(!empty($row[0])){
//         // echo $keyItem." - ";
//         // echo "<br>";
//         // print_r($dataHead[0]);
//         // echo "<br>";
//         // print_r($row);
//         // echo "<br>";
//         // $dataItem[] = $dataHead[0][1] = '';
        if(strpos($row[0], '/') !== false && count(explode('/', $row[0])) === 3) {
          $date = array($row[0],$row[1],$row[2]); // simpan array 
        }else{
          // Jika tidak, gabungkan nilai elemen dengan tanggal yang disimpan sebelumnya
          $dataItem[] = array_merge($date,$row);
        }
          // $dataItem[] = array_merge($row);
          // $dataItem[] = array_merge($dataHead[0]);
        // $dataItem[] = array_merge($row);
//         // $dataItem[] = array_merge($dataHead[$nKey],$row);
//         // $dataItem[] = $dataHead[$nKey];
//         // $keyItemx = array($keyItem);
//         // $dataItem[] = array_merge($keyItemx,$row);
//       }
//     }
//     // if(in_array($keyItem,$dataHead[0])){
//     //   if(!empty($row[0])){
//     //     print_r($row);
//     //     echo "<br>";
      }
    }
  }
}

// print_r($dataItem);
// return false;


// Variabel untuk menyimpan hasil penggabungan
// $result = [];

// // Variabel untuk menyimpan array sementara untuk penggabungan
// $tempArray = [];

// // Perulangan untuk mengakses setiap elemen array
// foreach ($dataItem as $item) {
//     // Memeriksa apakah nilai kunci nomor 0 adalah tanggal
//     if (strtotime(str_replace('/', '-', $item[0])) !== false) {
//         // Jika ya, gabungkan array sementara ke hasil penggabungan
//         if (!empty($tempArray)) {
//             $result[] = $tempArray;
//         }
//         // Reset array sementara
//         $tempArray = $item;
//     } else {
//         // Jika tidak, gabungkan array ke array sementara
//         $tempArray = array_merge($tempArray, $item);
//     }
// }

// // Tambahkan array sementara terakhir ke hasil penggabungan
// if (!empty($tempArray)) {
//     $result[] = $tempArray;
// }

// Array hasil yang akan dibentuk
// $result = [];

// Variabel untuk menyimpan tanggal dari array pertama
// $date = $dataItem[0][0];

// print_r($date);
// return false;

// Perulangan untuk iterasi melalui setiap elemen array
// foreach ($dataItem as $item) {
    // Jika elemen pertama adalah tanggal, set variabel tanggal
    // if (strtotime(str_replace('/', '-', $item[0])) !== false) {
      // echo $item[0]."<br>";
    // if(strpos($item[0], '/') !== false) {
    //     $date = $item[0];
    // } else {
    //     // Jika tidak, gabungkan nilai elemen dengan tanggal yang disimpan sebelumnya
    //     $result[] = array_merge([$date],[$item[0]], array_slice($item, 1));
    // }
// }

// Output hasil array
// print_r($result);
// return false;

// $dataItem1 = array();
// foreach($dataItem as $kitm => $itm1){
//   echo $kitm."<br>";
//   // print_r($itm1);
//   // echo "<br>";
//   foreach($itm1 as $itx1){
//     if(strpos($itx1, '/') !== false) { // jika variable tersebut adalah tanggal maka cek
//       $filtered = array_filter($dataHead, function($row1) use ($row2) {
//           // Cocokkan kondisi
//           return $row2[0] !== $row1[1];
//       });
//       echo $itx1."<br>";
//     }
//   }
//   echo "<br>";
// }


// $noItem = 0;
// $dataItemx = [];
// foreach ($data as $key => $row2) {
//   if($key > 8){
//     if (strpos($row2[0], 'No Account') === false
//       //       strpos($row, 'Account') === false ||
//       //       strpos($row, 'Debet') === false ||
//       //       strpos($row, 'Kredit') === false
//       ){
//         if(!empty($row2[0])){
//           $filtered = array_filter($dataHead, function($row1) use ($row2) {
//               // Cocokkan kondisi
//               return $row2[0] !== $row1[1];
//           });
//           $dataItemx[] = $filtered;
//         //   $dataItemx[] = $row2; // array_merge($row1,$row);
//         }
//     }
//   }
// }
// print_r($dataItemx);
// return false;

// $filteredArray = array_filter($dataHead, function($item) use ($data) {
//     // Cocokkan kondisi
//     // return in_array($data[1], array_column($dataHead, 0)) && 
//     //        in_array($data[2], array_column($dataHead, 1)) && 
//     //        in_array($data[3], array_column($dataHead, 2));
//     return in_array($dataHead[1], array_column($data, 0));
// });

// // Fungsi untuk menambahkan elemen dari array kedua ke hasil filter array pertama
// $result = array_map(function($item) use ($data) {
//     // Temukan indeks yang cocok di array kedua
//     $index = array_search($item[0], array_column($data, 1));
//     // Kembalikan array gabungan
//     return array_merge($item, $data[$index]);
// }, $filteredArray);

// $result = [];
// foreach ($dataHead as $item) {
//     $filtered = array_filter($dataItemx, function($subArray) use ($item) {
//         // Cocokkan kondisi
//         return $subArray[0] !== $item[0];
//     });
    
//     // Jika ada hasil filter, tambahkan ke array hasil
//     if (!empty($filtered)) {
//         // Ambil salah satu hasil filter
//         $filteredItem = reset($filtered);
//         // Gabungkan array pertama dengan hasil filter
//         $result[] = array_merge($item, $filteredItem);
//     }
// }
// print_r($result);
// return false;

// foreach($dataHead as $row1){
//   foreach ($data as $key => $row2) {
//     // $noItem++;
//     // if(in_array($noItem,$noAccountIndex)){
//     if($key > 8){
//     //   $keyItem = $key+1;
//       if (strpos($row2[0], 'No Account') === false
//       //       strpos($row, 'Account') === false ||
//       //       strpos($row, 'Debet') === false ||
//       //       strpos($row, 'Kredit') === false
//       ){
//         if(!empty($row2[0])){
//           // echo $keyItem." - ";
//           // echo "<br>";
//           // print_r($dataHead[0]);
//           // echo "<br>";
//           // print_r($row);
//           // echo "<br>";
//           // $dataItem[] = $dataHead[0][1] = '';
//           // $dataItem[] = array_merge($dataHead[0],$row);
//           // $dataItem[] = array_merge($dataHead[0]);
//           // echo $row1[1]." - ".$row2[0]."<br>";
//           if ($row2[0] !== $row1[1]) {
//             if(strpos($row[1], '/') !== false) {
//               $row[1] = $row2[0];
//             }
//             $dataItem[] = $row1; // array_merge($row1,$row);
//           }
//           //   $dataItemx = array_merge($row1,$row);
//           //   $dataItem[] = array_unique($dataItemx);
//           // }
//           // $dataItem[] = array_merge($dataHead[$nKey],$row);
//           // $dataItem[] = $dataHead[$nKey];
//           // $keyItemx = array($keyItem);
//           // $dataItem[] = array_merge($keyItemx,$row);
//         }
//       // }
//       // if(in_array($keyItem,$dataHead[0])){
//       //   if(!empty($row[0])){
//       //     print_r($row);
//       //     echo "<br>";
//       //   }
//       }
//     }
//   }
// }

// print_r($dataItem);
// return false;

// foreach ($dataItem as $subdItem) {
//   if($subdItem[3] == "" && $subdItem[4] == ""){

//   }
//     // Copy nilai dari kunci nomor 6 ke kunci nomor 1
//     // $subArray[1] = $subArray[6];
// }

// print_r($dataItem);
// return false;

// UPDATE KEY 1,2,3 BASED ON 6,7,8
// foreach ($dataItem as $ksub => &$subarray) {
//     // Update nilai pada key 1, 2, dan 3 berdasarkan nilai pada key 6, 7, dan 8

//     // JIKA VARIABLE SUBARRRAY[1] DAN 6 EXPLODABLE MAKA CEK APAKAH TGL[0] SAMA?
//     // $tgl1 = explode('/',$subarray[1]);
//     // $tgl2 = explode('/',$subarray[6]);
//     // if($subarray[1] == $subarray[6] && $subarray[2] == $subarray[7] && $subarray[3] == $subarray[8]){
//     //   $subarray[1] = $subarray[6];
//     //   $subarray[2] = $subarray[7];
//     //   $subarray[3] = $subarray[8];
//     // }
//     // foreach($subArray as $sbArray){
//       if($subarray[1] !== $subarray[6]){
//           // cek apakah subarray[6] itu tanggal?
//           if(strpos($subarray[6], '/') !== false) {
//             $subarray[1] = $subarray[6];
//           }
//       }
//       // echo $ksub." : ".$subarray[1]." - ".$subarray[6]."<br>";
//       // if($subarray[2] === $subarray[7]){
//       //   $subarray[2] = $subarray[7];
//       // }
//       // if($subarray[3] === $subarray[8]){
//       //   $subarray[3] = $subarray[8];
//       // }
//     // }
// }

// print_r($dataItem);
// return false;

function removeDuplicatesAndBlanks($array)
{
    return array_unique(array_filter($array, function ($value) {
        return $value !== "" && $value !== null;
    }));
}

$filteredArray = array_map('removeDuplicatesAndBlanks', $dataItem);
// $uniqueArray = array_map('unserialize', array_unique(array_map('serialize', $filteredArray)));
$uniqueArray = array_map('unserialize', array_map('serialize', $filteredArray)); // array_unique(
$uniqueArray = array_values($uniqueArray);
$resetArray = array_map('array_values', $uniqueArray);

// print_r($resetArray);
// return false;

// function filterByCount($subarray)
// {
//     return count($subarray) > 4;
// }

// $dataItemArray = array_values(array_filter($resetArray, 'filterByCount'));
// // Remove subarray key 0
// $modifiedArray = array_map(function ($subarray) {
//     return array_slice($subarray, 1);
// }, $dataItemArray);

// print_r($modifiedArray);
// return false;

$modifiedArray = $resetArray;

// SWITCHING VALUE BASED ON KEY
$key1 = 1;
$key3 = 3;
// Loop through each subarray
foreach ($modifiedArray as &$subarray) {
    // Use a temporary variable to swap values
    $temp = $subarray[$key1];
    $subarray[$key1] = $subarray[$key3];
    $subarray[$key3] = $temp;
}

$key1x = 2;
$key3x = 3;
// Loop through each subarray
foreach ($modifiedArray as &$subarray) {
    // Use a temporary variable to swap values
    $temp = $subarray[$key1x];
    $subarray[$key1x] = $subarray[$key3x];
    $subarray[$key3x] = $temp;
}

// print_r($modifiedArray);
// return false;

// TAMBAHKAN VALUE KOSONG
$newKey = 2;
// Add a new value to the specified key
$newValue = "";
// array_splice($modifiedArray[0], $newKey, 0, $newValue);
foreach ($modifiedArray as &$subarray) {
    array_splice($subarray, $newKey, 0, $newValue);
}

// print_r($modifiedArray);
// return false;

// HILANGKAN SEMUA KARAKTER DAN SIMBOL PADA KEY 6 DAN 7
$keysToProcess = [6, 7];
// Loop through each subarray
foreach ($modifiedArray as &$subarray) {
    // Process specified keys
    foreach ($keysToProcess as $key) {
        // Remove symbols, characters except for numbers and dot (.), and remove the last two digits
        $subarray[$key] = str_replace('.','',preg_replace('/[^0-9.]/', '', $subarray[$key]));
        $subarray[$key] = substr($subarray[$key], 0, -2);
    }
}

// Output the result
// print_r($modifiedArray);
// return false;

// Variabel untuk menyimpan array sebelumnya
$previousValues = [];

// Perulangan untuk mengakses setiap elemen array
foreach ($modifiedArray as $key => $item) {
    // Memeriksa apakah nilai kunci 3 dan 4 sudah ada di array sebelumnya
    if (in_array($item[3], $previousValues) && in_array($item[4], $previousValues)) {
        // Kosongkan nilai kunci 3 dan 4
        $modifiedArray[$key][3] = '';
        $modifiedArray[$key][4] = '';
    } else {
        // Tambahkan nilai kunci 3 dan 4 ke array sebelumnya
        $previousValues[] = $item[3];
        $previousValues[] = $item[4];
    }
}

// Output array setelah modifikasi
// print_r($modifiedArray);
// return false;

$htmlTable = '';
$htmlTable = '<table border="1" cellspacing="0" cellpadding="0">';
$htmlTable .= '<thead>
    <tr>
      <th>Tgl</th>
      <th>Kode Akun</th>
      <th>Nama Akun</th>
      <th>No Jurnal</th>
      <th>No Bukti</th>
      <th>Keterangan</th>      
      <th>Debet</th>
      <th>Kredit</th>
    </tr>
  </thead><tbody>';

foreach($modifiedArray as $subarray){
  // $filteredArray = array_filter($subarray, function ($value) {
  //     return $value !== "";
  // });
  if(count($filteredArray) > 5){
    $htmlTable .= '<tr>';
    foreach ($subarray as $keyItem => $item) {
      $htmlTable .= '<td>'.$item.'</td>';
    }
    $htmlTable .= '</tr>';
  }else{
    // print_r($filteredArray);
    // echo "<br>";
    $htmlTable .= '<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>';
  }
}
// Output the HTML table
echo $htmlTable;

