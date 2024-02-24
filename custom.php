<?php
require 'vendor/autoload.php'; // Sesuaikan path autoload.php sesuai dengan proyek Anda
use PhpOffice\PhpSpreadsheet\IOFactory;

// Tentukan path file Excel yang akan diimpor
$excelFilePath = 'rpjurnal.xls'; // (EXAMPLE)

// Tentukan path untuk menyimpan file CSV
$csvFilePath = 'rpjurnal_convert.xls';

if(isset($_FILES['fileUpload'])) {

  if(empty($_FILES['fileUpload']['name'])){
    echo '<script>';
    echo 'alert("File tidak ada");';
    echo 'window.history.back();'; // Mengarahkan ke halaman sebelumnya
    echo '</script>';
    return false;
  }

  $file = $_FILES['fileUpload'];
  // Tentukan direktori penyimpanan file
  $uploadDirectory = './';
  // Tentukan nama file baru
  $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $newFileName = $excelFilePath; //uniqid('file_') . '.' . $extension;

  // Tentukan jenis file yang diizinkan
  $allowedExtensions = array('xls', 'xlsx');

  // Cek apakah ekstensi file diizinkan
  if(in_array($extension, $allowedExtensions)) {
    if (file_exists($excelFilePath)) {
      unlink($excelFilePath);
    }
    if (file_exists($csvFilePath)) {
      unlink($csvFilePath);
    }
    // Pindahkan file ke direktori penyimpanan dengan nama baru
    if(move_uploaded_file($file['tmp_name'], $uploadDirectory . $newFileName)) {
        
    } else {
        $errorMessage = error_get_last()['message']; // Mengambil pesan error terakhir
        echo '<script>';
        echo 'alert("Gagal mengunggah file: ' . $errorMessage . '");';
        echo 'window.history.back();'; // Mengarahkan ke halaman sebelumnya
        echo '</script>';
        return false;
    }
  } else {
      echo '<script>';
      echo 'alert("Ekstensi file tidak diizinkan. Hanya file dengan ekstensi .xls dan .xlsx yang diizinkan");';
      echo 'window.history.back();'; // Mengarahkan ke halaman sebelumnya
      echo '</script>';
      return false;
  }
}

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
        if ($val2 !== null && strpos($val2, 'No Account') !== false) { 
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
$dataItem = array();
$date = array();
foreach ($data as $key => $row) {
  if($key > 8){
    $keyItem = $key+1;
    if ($row[0] !== null && strpos($row[0], 'No Account') === false
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

$coltgl         = "style='display:none;'";
$colKodeAkun    = "style='display:none;'";
$colNama        = "style='display:none;'";
$colJurnal      = "style='display:none;'";
$colNoBukti     = "style='display:none;'";
$colKet         = "style='display:none;'";
$colDebet       = "style='display:none;'";
$colKredit      = "style='display:none;'";
$indexCol1      = "";
$indexCol2      = "";
$indexCol3      = "";
$indexCol4      = "";
$indexCol5      = "";
$indexCol6      = "";
$indexCol7      = "";
$indexCol8      = "";
foreach($_POST['customColumn'] as $column){
    if($column == "tgl"){
        $coltgl = "";
        $indexCol0 = 0;
    }
    if($column == "kode"){
        $colKodeAkun = "";
        $indexCol1 = 1;
    }
    if($column == "nama"){
        $colNama = "";
        $indexCol2 = 2;
    }
    if($column == "jurnal"){
        $colJurnal = "";
        $indexCol3 = 3;
    }
    if($column == "bukti"){
        $colNoBukti = "";
        $indexCol4 = 4;
    }
    if($column == "ket"){
        $colKet = "";
        $indexCol5 = 5;
    }
    if($column == "debet"){
        $colDebet = "";
        $indexCol6 = 6;
    }
    if($column == "kredit"){
        $colKredit = "";
        $indexCol7 = 7;
    }
}

$htmlTable = '';
$htmlTable = '<table border="1" cellspacing="0" cellpadding="0">';
$htmlTable .= '<thead>
    <tr>
      <th '.$coltgl.'>Tgl</th>
      <th '.$colKodeAkun.'>Kode Akun</th>
      <th '.$colNama.'>Nama Akun</th>
      <th '.$colJurnal.'>No Jurnal</th>
      <th '.$colNoBukti.'>No Bukti</th>
      <th '.$colKet.'>Keterangan</th>      
      <th '.$colDebet.'>Debet</th>
      <th '.$colKredit.'>Kredit</th>
    </tr>
  </thead><tbody>';

foreach($modifiedArray as $subarray){
  // $filteredArray = array_filter($subarray, function ($value) {
  //     return $value !== "";
  // });
  if(count($filteredArray) > 5){
    $htmlTable .= '<tr>';
    foreach ($subarray as $keyItem => $item) {
      if ($item !== null && strpos($item, '&') !== false) { 
        $item = str_replace('&','&amp;',$item);
      }

      if($keyItem == $indexCol0){
        $htmlTable .= '<td '.$coltgl.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol1){
        $htmlTable .= '<td '.$colKodeAkun.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol2){
        $htmlTable .= '<td '.$colNama.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol3){
        $htmlTable .= '<td '.$colJurnal.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol4){
        $htmlTable .= '<td '.$colNoBukti.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol5){
        $htmlTable .= '<td '.$colKet.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol6){
        $htmlTable .= '<td '.$colDebet.'>'.$item.'</td>';
      }
      if($keyItem == $indexCol7){
        $htmlTable .= '<td '.$colKredit.'>'.$item.'</td>';
      }

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
if($_POST['upload'] == "view"){
  echo $htmlTable;
}else{
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
  $spreadsheet = $reader->loadFromString($htmlTable);
  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
  $writer->save($csvFilePath); // save
  // download
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename="'.$csvFilePath.'"');
  header('Cache-Control: max-age=0');
  readfile($csvFilePath);
}


