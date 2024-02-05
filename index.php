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
    $dataHead[] = array_merge($itemIndex,$row);
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
  // if($keyItem == $dataHead[0]){
    // echo $keyItem."<br>";
    // print_r($dataHead);
    // echo "<br>";
    // print_r($row);
    // echo "<br>";
  // }
  // if($key > 8){
  //   $keyItem = $key+1;
  //   if (strpos($row[0], 'No Account') === false
  //   //       strpos($row, 'Account') === false ||
  //   //       strpos($row, 'Debet') === false ||
  //   //       strpos($row, 'Kredit') === false
  //   ){
  //     if(!empty($row[0])){
  //       // echo $keyItem." - ";
  //       // echo "<br>";
  //       // print_r($dataHead[0]);
  //       // echo "<br>";
  //       // print_r($row);
  //       // echo "<br>";
  //       $dataItem[] = array_merge($dataHead[0],$row);
  //       // $keyItemx = array($keyItem);
  //       // $dataItem[] = array_merge($keyItemx,$row);
  //     }
  //   }
  //   // if(in_array($keyItem,$dataHead[0])){
  //   //   if(!empty($row[0])){
  //   //     print_r($row);
  //   //     echo "<br>";
  //   //   }
  //   // }
  // }
// }

// print_r($dataItem);
// return false;

// DAPATKAN RANGE DATA BASED ON KEY 0 TIDAK BOLEH KOSONG
$dataItem = array();
foreach ($data as $key => $row) {
  if($key > 8){
    $keyItem = $key+1;
    if (strpos($row[0], 'No Account') === false
    //       strpos($row, 'Account') === false ||
    //       strpos($row, 'Debet') === false ||
    //       strpos($row, 'Kredit') === false
    ){
      if(!empty($row[0])){
        // echo $keyItem." - ";
        // echo "<br>";
        // print_r($dataHead[0]);
        // echo "<br>";
        // print_r($row);
        // echo "<br>";
        $dataItem[] = array_merge($dataHead[0],$row);
        // $keyItemx = array($keyItem);
        // $dataItem[] = array_merge($keyItemx,$row);
      }
    }
    // if(in_array($keyItem,$dataHead[0])){
    //   if(!empty($row[0])){
    //     print_r($row);
    //     echo "<br>";
    //   }
    // }
  }
}

// UPDATE KEY 1,2,3 BASED ON 6,7,8
foreach ($dataItem as &$subarray) {
    // Update nilai pada key 1, 2, dan 3 berdasarkan nilai pada key 6, 7, dan 8

    // JIKA VARIABLE SUBARRRAY[1] DAN 6 EXPLODABLE MAKA CEK APAKAH TGL[0] SAMA?

    $tgl1 = explode('/',$subarray[1]);
    $tgl2 = explode('/',$subarray[6]);
    if($subarray[1] == $subarray[6] && $subarray[2] == $subarray[7] && $subarray[3] == $subarray[8]){
      $subarray[1] = $subarray[6];
      $subarray[2] = $subarray[7];
      $subarray[3] = $subarray[8];
    }
}

print_r($dataItem);
return false;

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

function filterByCount($subarray)
{
    return count($subarray) > 4;
}

$dataItemArray = array_values(array_filter($resetArray, 'filterByCount'));
// Remove subarray key 0
$modifiedArray = array_map(function ($subarray) {
    return array_slice($subarray, 1);
}, $dataItemArray);

// print_r($modifiedArray);
// return false;

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
  $filteredArray = array_filter($subarray, function ($value) {
      return $value !== "";
  });
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

