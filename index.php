<html>
  <head>
    <meta charset="utf-8" />
		<meta name="description" content="Mini ERP" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="id_ID" />
		<meta property="og:type" content="website" />
		<meta name="robots" content="noindex">
		<meta name="googlebot" content="noindex">
    <title>.::LBN TRANS - Mini ERP::.</title>
    <style>
      .widthh{
            max-width:450px !important;
      }
      @media screen and (min-width: 100px) and (max-width: 991px){
        .widthh{
          max-width:100% !important;
        }
      }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container widthh">
      <form action="main.php" method="post" enctype="multipart/form-data" class="d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="row">
          <center><img src="lbn-newlogo.png" style="width:auto;height:100px;"></center>
          <div class="col-12 mt-4">
            <label class="form-check-label">Excel Utama <span style="color:red">*<span></label>
            <div class="input-group mb-3">
              <input type="file" name="fileUpload" accept=".xlsx, .xls" class="form-control" id="inputGroupFile02">
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="customOn" value="1" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">Custom</label>
            </div>
            <div id="showOption" class="d-none mb-3">
              <label class="form-check-label">Gabungkan Dengan Excel Utama (optional)</label>
              <div class="input-group mb-3">
                <input type="file" name="fileUpload2" accept=".xlsx, .xls" class="form-control" id="inputGroupFile03">
              </div>
              <label class="form-check-label">*Custom Heading (Pilih Dengan Menekan CTRL)</label>
              <select name="customColumn[]" class="form-control" multiple>
                <option value="tgl">Tanggal</option>
                <option value="kode">Kode Akun</option>
                <option value="nama">Nama Akun</option>
                <option value="jurnal">No Jurnal</option>
                <option value="bukti">No Bukti</option>
                <option value="ket">Keterangan</option>
                <option value="debet">Debet</option>
                <option value="kredit">Kredit</option>
              </select>
            </div>  
          </div>
          <div class="col-6">
            <button type="submit" name="upload" value="view" style="width:100%;border:1px solid grey;" class="btn btn-default">View File</button>
          </div>      
          <div class="col-6">
            <button type="submit" name="upload" value="process" style="width:100%;" class="btn btn-primary">Convert File</button>
          </div>      
        </div>      
      </form>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript">
      $(document).ready(function(){
        $("input[name='customOn']").click(function(){
          var value = $(this).val();
          if ($(this).is(":checked")) {
            $("#showOption").removeClass('d-none');
          }else{
            $("#showOption").addClass('d-none');
          }
        });
      });
  </script>
</html>