<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" src="Script.js"></script>
  <link href="css.css" rel="stylesheet">
  <link href="table.css" rel="stylesheet">
  <title>BÖLÜMLER</title>

  <!-- Bootstrap core CSS -->


  <!-- Custom styles for this template -->

</head>

<body>
  <div id="TumSayfa">
    <?php
    include "leftMenu.php";
    include "dataBaseInfo.php";
    $conn = new mysqli($servername, $user, $pass, $dbname);
    $query = "select bolumNo,bolumAdi,(select fakulteAdi from fakulte where fakulteNo = bolum.fakulteNo) as fakulteAdi from bolum";
    $result = $conn->query($query);
    echo $leftMenu;
    ?>
    <div id="Icerik">
      <div id="GenelTabloSinirlamaAlani">
        <div class="col-md-12">

          <h3 class="title-5 m-b-35">BÖLÜM BİLGİLERİ</h3>
          <div class="table-data__tool">

            <div class="table-data__tool-right">
              <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#myModalBolumEkle"><i class="zmdi zmdi-plus"></i>Yeni Bölüm Ekle</button>
            </div>
          </div>
          <div class="table-responsive table-responsive-data2">
            <table id="TabloSinirlamaAlani" class="table table-data2">
              <thead>
                <tr>
                  <th>Bölüm Kodu</th>
                  <th>Bölüm Adı</th>
                  <th>Fakülte Adı</th>
                  <th>Program Kazanımları</th>
                  <th>Düzenle</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($bolum = mysqli_fetch_array($result)) {
                  echo '<tr class="tr-shadow">
                <td >' . $bolum["bolumNo"] . '</td>
                
                <td class="status--process"> ' . $bolum["bolumAdi"] . ' </td>
                
                <td>' . $bolum["fakulteAdi"] . '</td>
                
                <td><button class="au-btn au-btn-icon au-btn--darkseagreen au-btn--small" data-toggle="modal" data-target="">Göster</button></td>
                <td>
                  <div class="table-data-feature">
                    <button onclick="depEdit(' . $bolum["bolumNo"] . ',`' . ($bolum["bolumAdi"]) . '`,`' . $bolum["fakulteAdi"] . '`)" data-target="#myModalDepEdit" data-toggle="modal" class="item" data-toggle="tooltip" data-placement="top" title="Güncelle" data-original-title="Edit">
                      <i class="zmdi zmdi-edit"></i>
                    </button>
                    <button class="item" data-toggle="tooltip" data-placement="top" title="Sil" data-original-title="Delete">
                      <i class="zmdi zmdi-delete"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr class="spacer"></tr>';
                }
                ?>
                 <script>
                  function depEdit(bolumNo, bolumAdi, fakulteAdi) {
                    getDepName(bolumNo, bolumAdi, fakulteAdi);
                  }

                  function getDepName(bolumNo, bolumAdi, fakulteAdi) {
                    document.getElementById("bolumNoID").value = bolumNo;
                    document.getElementById("oldBolumNoID").value = bolumNo;
                    document.getElementById("bolumAdiID").value = bolumAdi;
                    document.getElementById("editFacultyName").value = fakulteAdi;
                  }
                </script>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="myModalBolumEkle">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Bölüm Ekle</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="insertDepartment.php" method="post">
            <div class="form-group">
              <label><b>Bölüm No:</b></label>
              <input type="text" class="form-control" name="bolumNo">
            </div>
            <div class="form-group">
              <label><b>Bölüm Adı:</b></label>
              <input type="text" class="form-control" name="bolumAdi">
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Fakülte:</label>
              <select class="form-control" name="fakulteAdi">
                <?php 
                  $fakulte_query = "select * from fakulte;";
                  $fakulte_result = $conn->query($fakulte_query);
                  while($fakulteler = mysqli_fetch_array($fakulte_result))
                  {
                    echo '<option>'.$fakulteler['fakulteAdi'].'</option>';
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Ekle</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--Department Edit Modal -->
<div class="modal fade" id="myModalDepEdit">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Bölüm Düzenle</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="" method="post">
            <div class="form-group">
              <label><b>Bölüm No:</b></label>
              <input id="oldBolumNoID" type="hidden" class="form-control" name="oldBolumNo" value="">
              <input id="bolumNoID" type="text" class="form-control" name="bolumNo">
            </div>
            <div class="form-group">
              <label><b>Bölüm Adı:</b></label>
              <input id="bolumAdiID" type="text" class="form-control" name="bolumAdi">
            </div>
            <div class="form-group">
              <label>Fakülte:</label>
              <select class="form-control" name="fakulteAdi" id="editFacultyName">
                <?php 
                  $fakulte_query = "select * from fakulte;";
                  $fakulte_result = $conn->query($fakulte_query);
                  while($fakulteler = mysqli_fetch_array($fakulte_result))
                  {
                    echo '<option>'.$fakulteler['fakulteAdi'].'</option>';
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>