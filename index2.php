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
echo '<table>
  <thead>
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
  </thead>
  <tbody>
    <tr>
      <td rowspan="2">2024-01-30</td>
      <td>K123</td>
      <td>Akun1</td>
      <td>J123</td>
      <td>B123</td>
      <td>Keterangan 1</td>
      <td>500</td>
      <td>0</td>
    </tr>
    <tr>
      <td>K124</td>
      <td>Akun2</td>
      <td>J124</td>
      <td>B124</td>
      <td>Keterangan 2</td>
      <td>0</td>
      <td>300</td>
    </tr>
  </tbody>
</table>';
// echo '<table style="width: 100%" border="1" cellspacing="0" cellpadding="0">
//       <tr>
//          <th >First Name </th>
//          <th>Job role</th>
//       </tr>
//       <tr>
//          <td >Tharun</td>
//          <td rowspan="2">Content writer</td>
//       </tr>
//       <tr>
//          <td >Akshaj</td>
//       </tr>
//       <tr>
//          <td colspan="2">Welcome to the company</td>
//       </tr>
//    </table>';
// Dapatkan data sebagai array
$data = $sheet->toArray();

// OLAH DATA
$x = 0;
$fix = array();
$nobukti1 = array();
foreach ($data as $row) {
    $x++;
    // $htmlTable .= "<tr>";
    if($x >= 10){ // start awal
      // if(count($row) > 4){
        // $tgl = array();
        // $nojurnal = array();
        // $nobukti  = array();
        $nocell = 0;
        // $nobukti = array();
        foreach ($row as $cl) {
            $cell = htmlspecialchars($cl);
            $nocell++;
            if(strpos($cell, '/') !== false) {
                if(strlen($cell) == 10){
                    $tgl = $cell;
                }else{
                    $nojurnal = $cell;
                }
            }else{
                // if(strpos($cell, 'JR') !== false){
                //   $nobukti1[$nocell] = $cell;
                // }
                // if(strpos($cell, 'No Account1') === false && strpos($cell, 'No Account') === false && strpos($cell, 'Account') === false && strpos($cell, 'Debet') === false && strpos($cell, 'Kredit') === false) {
                  $nobukti = $cell; // $nb.",".
                // }
            }
            // $dataHeader = array_merge($tgl,$nojurnal,$nobukti);
            if(!empty($tgl) && !empty($nojurnal) && !empty($nobukti)){
              // $htmlTable .= "<td><td>";
              // if(count($nobukti1) == 0){
              //   $nobukti = $nobukti.",";
              // }else{
              // $tb = "";
              // if(count($nobukti1) > 0){
              //   $tb = implode(",",$nobukti1);
              //   if($tb != $nobukti){
              //     // $nobukti = $nobukti.",".$tb;
              //     $tb = $tb;
              //   }
              //   // else{
              //   //   $nobukti = $tb;
              //   // }
              // }
              $dTgl = array($tgl);
              $dNj  = array($nojurnal);
              $dNb  = array($nobukti);
              // if(strpos($cell, 'JR') !== false){
              //     $nobukti1[$nocell] = $cell;
              // }
              // $tb   = array($tb);
              $fix[] = array_merge($dTgl,$dNj,$dNb);
              // $dt = array_merge($dTgl,$dNj,$dNb);
              // print_r($dt);
              // echo "<br>";
              // echo $tgl.",".$nobukti.",".$nojurnal.",<br>";
            }
        }
        // echo "<br>";
      // }
    }
    // $htmlTable .= "</tr>";
    // print_r($dataHeader);
}
// END OLAH DATA

// if(count($fix) > 3){
  // print_r($fix);
// }
// $datavv = array();
// // $dataParent = array();
// foreach($fix as $k => $v){
//   foreach($v as $kk => $vv){
//     // if($kk == 0){ // dijadikan patokan untuk semua array childnya
//       // echo "key ".$k." - ";
//       $datavv[] = $vv;
//       // print_r($vv);
//       // echo "<br>";
//     // }
//   }
// }
// print_r(array_unique($datavv));
// print_r($dataParent);

// $dataParent = array_values(array_unique($datavv));
// print_r($dataParent);
// foreach($dataParent as $dp => $vp){

// }

// return false;

// echo "<br><br>";
$v1 = array();
$v2 = array();
$v3 = array();
$vv = array();

// print_r($fix);

foreach($fix as $fk){
  print_r($fk);
  echo "<br>";
}

return false;
foreach($fix as $key => $val){
  // if($key)
  $vv[] = $val;
  $nov = 0;
  $tv1 = array();
  foreach($val as $kx1 => $vx1){
    if($kx1 == 0){
      $v1[] = $vx1;
      $vd1 = $vx1;
    }
    if($kx1 == 2){
      // $v2[] = $vx;
      $vd2 = $vx1;
    }
    // if($kx == 2){
    //   $v3[] = $vx;
    // }
    $no++;
  }
  foreach($val as $kx2 => $vx2){
    if($kx2 == 1){
      $v2[] = $vx1."|".$vd2."|".$val;
    }
    // if($kx == 2){
    //   $v3[] = $vx;
    // }
  }
  // foreach($val as $kx3 => $vx3){
  //   if($kx3 == 2){
  //     $v3[] = $vx3;
  //   }
  // }
}
// print_r($vv);
$datav1 = array_values(array_unique($v1));
$datav2 = array_values(array_unique($v2));
// $datav3 = array_values(array_unique($v3));
// print_r($datav1);
// echo "<br><br>";
print_r($datav2);
// echo "<br><br>";
// print_r($datav3);

// print_r($fix);
return false;

$result = array();

// Iterasi setiap elemen pada array data
foreach ($datav2 as $item) {
    // Pecah setiap baris data menjadi array
    $values = explode("|", $item);

    // Ambil tanggal sebagai kunci
    $tanggal = $values[0];

    // Jika tanggal belum ada di array hasil, tambahkan array baru dengan kunci tanggal
    if (!isset($result[$tanggal])) {
        $result[$tanggal] = array();
    }

    // Tambahkan array ke dalam array hasil
    $result[$tanggal] = array_unique(array_merge($result[$tanggal], $values));

    // Pecah setiap baris data menjadi array
    // $values = explode("|", $item);

    // Ambil tanggal sebagai kunci
    // $tanggal = $values[0];
    // $nomorJurnal = $values[1];
    // if(strpos($nomorJurnal, 'JR') !== false){
    //   $result[$tanggal] = array($item);
    // }

    // Jika tanggal belum ada di array hasil, tambahkan array baru dengan kunci tanggal
    // if (!isset($result[$tanggal])) {
    //     $result[$tanggal] = array();
    // }

    // // Tambahkan array ke dalam array hasil
    // $result[$tanggal][] = $values[1]; // Gunakan kunci 1 sebagai nilai

    // // Gunakan kunci 2 sebagai kunci tambahan (opsional)
    // // if (isset($values[2])) {
    // if(strpos($values[2], '.') !== false){
    //     $result[$tanggal][$values[2]] = $values[2];
    // }
}

// Menampilkan hasil
// print_r($result);

// foreach($result as $key => $value){
//   if (strtotime($key)) {
//     // Jika ya, hapus elemen array tersebut
//     unset($result[$key]);
//   }
// }

print_r($result);
return false;

// $htmlTable = '<table border="1" cellspacing="0" cellpadding="0">';
// $htmlTable .= '<thead>
//     <tr>
//       <th>Tgl</th>
//       <th>Kode Akun</th>
//       <th>Nama Akun</th>
//       <th>No Jurnal</th>
//       <th>No Bukti</th>
//       <th>Keterangan</th>      
//       <th>Debet</th>
//       <th>Kredit</th>
//     </tr>
//   </thead><tbody>';

// foreach($datav1 as $keyv => $dtv){
//   $countDataFromDate = 0;
//   foreach ($datav2 as $item) {
//       $values = explode(",", $item);
//       if (in_array($dtv, $values)) {
//           $countDataFromDate++;
//       }
//   }
//   echo "jumlah data pada tanggal ".$dtv." -> ".$countDataFromDate."<br>";
  // if($keyv == 0){
  //   $tglv = $dtv;
  // }
  // $htmlTable .= '<tr>
  //                   <td>'.$tglv.'</td>
  //                   <td>'.$c2.'</td>
  //                   <td>'.$c3.'</td>
  //                   <td>'.$c4.'</td>
  //                   <td>'.$c5.'</td>
  //                   <td>'.$c6.'</td>
  //                   <td>'.$c7.'</td>
  //                   <td>'.$c8.'</td>
  //               </tr>';
// }







// $nm = 0;
// foreach($fix as $key => $value){
  // $nm++;
  // print_r($f);
  // echo "<br><br>";
  // C1
  // if($key == 0){
    // echo $key;
  // }
  // foreach ($f as $key1 => $value1) {
  //   if($key1 == 0){
  //     $c1 = $value1;
  //     // echo $cx1."<br>";
  //   }
  // }
  // $ncx1 = 0;
  // foreach($f as $cx1){
  //   $ncx1++;
  //   if($ncx1 == 1){
  //     $c1 = $f[0];
  //     // echo $cx1."<br>";
  //   }
  // }
  // C2
  // foreach ($f as $key2 => $value2) {
  //   if($key2 == 2){
  //     if (strpos($value, '.') !== false) {
  //       $c2 = $value2;
  //     }else{
  //       $c2 = "x";
  //     }
  //     // echo $cx1."<br>";
  //   }
  // }
  // $ncx2 = 0;
  // foreach($f as $cx2){
  //   $ncx2++;
  //   if($ncx2 == 3){
  //     $c2 = $cx2;
  //     // echo $cx2."<br>";
  //   }
  // }
  // // C4
  // $ncx4 = 0;
  // foreach($f as $cx4){
  //   $ncx4++;
  //   if($ncx4 == 2){
  //     $c4 = $cx4;
  //     // echo $cx4."<br>";
  //   }
  // }
  // echo "<br>";

  // $htmlTable .= '<tr>
  //                   <td>'.$c1.'</td>
  //                   <td>'.$c2.'</td>
  //                   <td>'.$c3.'</td>
  //                   <td>'.$c4.'</td>
  //                   <td>'.$c5.'</td>
  //                   <td>'.$c6.'</td>
  //                   <td>'.$c7.'</td>
  //                   <td>'.$c8.'</td>
  //               </tr>';
// }

// $tglHeading = array_unique($tgl);

// $x = 0;
// foreach ($data as $row) {
//     $x++;

    // foreach($tgl as $tglx){ // loop tgl
    //     echo $tglx."<br>";
    // }
    // if($x > 11){
    //     $htmlTable .= '<tr>
    //         <td rowspan="2">\</td>';
    //     if($row[0] != ""){
    //         // get no jurnal, no bukti, keterangan
    //         // $nojurnal   = "";
    //         // $nobukti    = "";
    //         // $keterangan = "";
    //         // $y1 = 0;
    //         // foreach($row as $c1){
    //         //     $y1++;
    //         //     if($y == 3){
    //         //         $htmlTable .= "<td>".$c1."</td>";
    //         //     }
    //         //     if($y == 3){
    //         //         $htmlTable .= "<td>".$c1."</td>";
    //         //     }
    //         // }
    //         $y = 0;
    //         foreach($row as $c1){
    //             $y++;
    //             if($y == 3 || $y == 4 || $y == 5){
    //                 $htmlTable .= "<td></td>";
    //             }else{
    //                 $htmlTable .= "<td>".$c1."</td>";
    //             }
    //         }
    //     }
    //     // hitung berapa item account
    //     // $jmlAccount = [];
    //     // foreach ($row as $c1) {
    //     //     if($c1 != ""){
    //     //         $jmlAccount[] = $c1;
    //     //     }
    //     // }
    //     // echo "jumlah "+count($jmlAccount);
    //     // $htmlTable .= '<tr>';
    // //     $htmlTable .= '<tr>
    // //   <td rowspan="2">2024-01-30</td>
    // //   <td>K123</td>
    // //   <td>Akun1</td>
    // //   <td>J123</td>
    // //   <td>B123</td>
    // //   <td>Keterangan 1</td>
    // //   <td>500</td>
    // //   <td>0</td>
    // // </tr>';
    //     // foreach ($row as $cell) {
    //     //     $val = htmlspecialchars($cell);
    //     //     if(strpos($val, '/') !== false) { // cek jika tanggal
    //     //         $t = explode('/',$val);
    //     //         $htmlTable .= '<td rowspan="3">'.date('d',strtotime($t[0])).'-'.date('M',strtotime($t[1])).'-'.date('y',strtotime($t[2])).'</td>';
    //     //         $htmlTable .= '<td>'.$val.'</td>';
    //     //         $htmlTable .= '<td>'.$val.'</td>';
    //     //     }else{
    //     //         $htmlTable .= '<td>'.$val.'</td>';
    //     //         // $htmlTable .= '<td>'.$val.'</td>';
    //     //     }
    //     // }
    //     // $htmlTable .= '</tr>';
    //     // $htmlTable .= '<tr>';
    //     // foreach ($row as $cell) {
    //     //     $val1 = htmlspecialchars($cell);
    //     //     $htmlTable .= '<td>'.$val.'</td>';
    //     //     $htmlTable .= '<td>'.$val.'</td>';
    //     // }
    //     // $htmlTable .= '</tr>';
    // }
// }
$htmlTable .= '</tbody></table>';
// Output the HTML table
echo $htmlTable;


// ORIGINAL
// $htmlTable = '<table border="1">';
// foreach ($data as $row) {
//     $htmlTable .= '<tr>';
//     foreach ($row as $cell) {
//         $htmlTable .= '<td>' . htmlspecialchars($cell) . '</td>';
//     }
//     $htmlTable .= '</tr>';
// }
// $htmlTable .= '</table>';
// // Output the HTML table
// echo $htmlTable;


// print_r($data);
// Simpan data ke file CSV
// $file = fopen($csvFilePath, 'w');
// foreach ($data as $row) {
    // fputcsv($file, $row);
    // echo $row."<br>";
// }
// fclose($file);

// echo "File Excel berhasil diimpor dan disimpan sebagai CSV.";
?>