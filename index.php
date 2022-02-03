<script>

var clickBTN = document.getElementById("donee")

var table = document.getElementById("tbl")


table.style.opacity = "0.1"

clickBTN.addEventListener("click", function(event) {
    event.preventDefault();

    table.style.opacity = "1";   
    
    });
</script>

<?php
$totalmontantsHT_TVA = [];
$totalmontantsHT = [];
    // config
    class Tranche {
        public $borneMin;
        public $borneMax;
        public $tarif;

        function __construct($bmin, $bmax, $tar){
            $this->borneMin = $bmin;
            $this->borneMax = $bmax;
            $this->tarif = $tar;
        }

        function infos(){
            echo "Borne min: $this->borneMin. Borne max: $this->borneMax. Tarif: $this->tarif";
        }
    }
    $tva = 14;
    $timbre = 0.45;
    $redevance= [
        "small" => 22.65,
        "medium" => 37.05,
        "large" => 46.20
    ];
    //$redevance = array("small" => 22.65, "medium" => 37.05, "large" => 46.20);
    $tarifs = [
        new Tranche(0, 100, 0.794), 
        new Tranche(101, 150, 0.883),
        new Tranche(151, 210, 0.9451),
        new Tranche(211, 310, 1.0489),
        new Tranche(311, 510, 1.2915),
        new Tranche(511, null, 1.4975)
    ];

    $oldIndex;
    $newIndex;
    $consommation;
    $montantsFacture = array(); // tableau où on va stocker les montants facturés
    $montantsHT = array(); // tableau où on va stocker les montants HT

    if (isset($_POST["submit"])) {
        $oldIndex = $_POST["oldIndex"];
        $newIndex = $_POST["newIndex"];
        $calibre = $_POST["calibre"];
        $consommation = $newIndex - $oldIndex;
        // $consommation <= 150
        if($consommation <= 150) {
            // $consommation <= 100
            if($consommation <= $tarifs[0]->borneMax) {
                $montantsFacture[0] = $consommation;
                $montantsHT[0] = $consommation * $tarifs[0]->tarif;
            }
            // 100 < $consommation <= 150
            else {
                $montantsFacture[0] = 100;
                $montantsFacture[1] = $consommation - $montantsFacture[0];
                $montantsHT[0] = $montantsFacture[0] * $tarifs[0]->tarif;
                $montantsHT[1] = $montantsFacture[1] * $tarifs[1]->tarif;
            }
        }
        // $consommation > 150
        // else {
        //     if($consommation <= $tarifs[2]->borneMax) {

        //     }
        // }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">

    <title>Document</title>
</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="background-color: white !important;">
  <!-- Brand/logo -->
  <img src="./favicon.png" alt="" srcset="" style="
    width: 111PX;
    margin-left: 32px;
">

</nav>
<div class="container mt-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-8">
            <form id="regForm" action="index.php" method="POST">
                <h1 id="register">Electricity Calculator</h1>
                <div class="all-steps" id="all-steps"> <span class="step"><i class="fas fa-bolt"></i></span> <span class="step"><i class="fas fa-file-invoice"></i></span>  <span class="step"><i class="fas fa-list-ul"></i></span> </div>
                <div class="tab">
                    <h6>What's your Old Bill?</h6>
                    <p> <input placeholder="Old Bill..." oninput="this.className = ''" name="oldIndex"></p>
                </div>
                <div class="tab">
                    <h6>What's your New Bill?</h6>
                    <p><input placeholder="New Bill..." oninput="this.className = ''" name="newIndex"></p>
                </div>
                <div class="tab">
                    <h6>What's your Favourite Shopping site?</h6>
                    <input class="radio" type="radio" name="calibre" value="small">Caliber 1<br>
                    <input class="radio" type="radio" name="calibre" value="medium">Caliber 2 <br>
                    <input class="radio" type="radio" name="calibre" value="large">Caliber 3
                </div>
                <div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                    <h6>Thankyou for your feedback!</h6> <span>Thanks for your valuable information. It helps us to improve our services!</span>
                    <button type="submit" name="submit" id="donee" class="btn btn-primary">GET Resolt</button>
                   
                    
                </div>
                <div style="overflow:auto;" id="nextprevious">
                    <div style="float:right;"> <button type="button" id="prevBtn" onclick="nextPrev(-1)"><i class="fa fa-angle-double-left"></i></button> <button type="button" id="nextBtn" name="click" onclick="nextPrev(1)"><i class="fa fa-angle-double-right"></i></button> </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id='table'>




<table id="tbl"  class="table table-borderless table1" style="margin-top: 42PX; width : 75%; margin-left : 10%;">

<thead style="
    border: black solid;">
      <tr> <td></td></tr>
  <tr> <td></td></tr>
<tr><th><td>New index :<?php if (isset($_POST["submit"])) {echo $newIndex; }?></td></th><th><td>Old index :<?php if (isset($_POST["submit"])) { echo $oldIndex;} ?></td></th><th><td>Consommation : <?php if (isset($_POST["submit"])) {echo $consommation; }?>KWH</td></th> <th>
<tr> <td></td></tr>
  <tr> <td></td></tr>
          
        </thead>
        <tbody style="
    border: black solid;">

        <tr>
            <th></th>
            <th > مفوتر<br>
                Facturé</th>
            <th>س.و<br>
                P.U</th>
            <th>المبلغ د.إ.ر<br>
                Montant HT</th>
                
            <th>ض.ق.م<br>
                Taux TVA</th>
            <th>مبلغ الرسوم<br>
                Montant Taxes</th>
          </tr>
        <?php



        if (isset($_POST["submit"])) {
            foreach($montantsFacture as $key => $value) {

        ?>
        <tr> <td></td></tr>
  <tr> <td></td></tr>
    
               <tr>
            <td>CONSOMMATION ELECTRICITE</td>
            <td></td>
            
            <td></td>
            
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td>إستھلاك الكھرباء</td>

           
        </tr>
        <tr> <td></td></tr>
  <tr> <td></td></tr>
    
        <tr>
            <td>TRANCHE</td>
            <td><?php   echo $value;  ?></td>
            
            <td><?php  echo $tarifs[$key]->tarif;?></td>
            
            <td><?php  echo $montantsHT[$key];    ?></td>
            
            <td><?php  echo $tva . "%";   ?></td>
            <td><?php   echo $montantsHT[$key] * $tva /100;  ?></td>
            <td></td>
            <td>الشطر</td>
            <?php
   
            array_push($totalmontantsHT_TVA, $montantsHT[$key] * $tva /100);
            array_push($totalmontantsHT, $montantsHT[$key]);
            

            
            ?>
           
        </tr>
    
        <?php
            }
        }
        
        ?>
    <tr>
    
            <td>REDEVANCE FIXE ELECTRICITE</td>
            <td></td>
             <td></td>
        <?php   if (isset($_POST["submit"])) { array_push($totalmontantsHT,$redevance[$calibre] );   } ?>
            <td><?php if (isset($_POST["submit"])) { echo $redevance[$calibre];  } ?></td>
            <td><?php if (isset($_POST["submit"])) { echo $tva . "%";  } ?></td>
            <td><?php if (isset($_POST["submit"])) { array_push($totalmontantsHT_TVA, $redevance[$calibre] * $tva /100); echo $redevance[$calibre] * $tva /100;  }  ?></td>
           <td></td>
            <td class="right">اثاوة ثابتة الكهرباء</td>
          </tr>
          <tr> <td></td></tr>
  <tr> <td></td></tr>
          <tr>
            <td>TAXES POUR LE COMPTE DE L’ETAT</td>
            <td></td>
            
            <td></td>
            
            <td></td>
            
            <td></td>
            <td></td>
            <td></td>
            <td>الرسوم المؤداة لفائدة الدولة</td>

           
        </tr>
       
        <tr> <td></td></tr>
  <tr> <td></td></tr>
   
        <tr>

        <tr>
    
    <td> TOTAL TVA</td>
    <td></td>
     <td></td>

<td></td>
    <td></td>
    <td><?php  if (isset($_POST["submit"])) { echo array_sum($totalmontantsHT_TVA);}?></td>
   <td></td>
    <td class="right"> مجموع ض.ق.م </td>
  </tr>


  <tr>
    
    <td>TIMBRE</td>
    <td></td>
     <td></td>
<td></td>
    <td></td>
    <td><?php  if (isset($_POST["submit"])) { echo $timbre; }?></td>
   <td></td>
    <td class="right"> الطابع</td>
  </tr>
  

  <tr>
    
    <td>SOUS-TOTAL</td>
    <td></td>
     <td></td>
<td><?php if (isset($_POST["submit"])) { echo array_sum($totalmontantsHT);} ?></td>
    <td></td>
    <td><?php  if (isset($_POST["submit"])) { echo array_sum($totalmontantsHT_TVA) + $timbre; }?></td>
   <td></td>
    <td class="right"> المجموع الجزئي </td>
  </tr>

  <tr> <td></td></tr>
  <tr> <td></td></tr>
    
    <td>TOTAL ÉLECTRICITÉ</td>
    <td></td>
     <td></td>
<td></td>
    <td><?php if (isset($_POST["submit"])) { echo array_sum($totalmontantsHT) + array_sum($totalmontantsHT_TVA) + $timbre ;} ?> DH</td>
    <td></td>
   <td></td>
    <td class='right'>مجموع الكهرباء</td>
  </tr>
  </tbody>

    </table>

    </div>


    <input type="button" id="bt" onclick="createPDF()" value="Print PDF" />

<script src="scr.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php



// global $allTranche;  

// function test(){

//   global $allTranche;  

//   print $allTranche["Tranche1"];


// }

// test();



// if (isset($_POST["clicker"])) {
  
//     $old = $_POST["old"];
//     // print ("<br>");
//     $new = $_POST["new"];
//     $redio = $_POST["MyRadio"];


  
// class clcul {
//   public $old;
//   public $new;


//   function __construct($old, $new, $Tranche) {
//     $this->old = $old;
//     $this->new = $new;
//     $this->Tranche = $Tranche;


//   }
//   function totalNumber() {
    
//     return   $this->new - $this->old  ;
//   }
//   function secNumber() {
//     return $this->new;
//   }
//   function Tranche1() {
//     return $this->new - $this->old * $this->Tranche;
//   }
//   function Tranche2() {
//     return $this->new;
//   }
//   function Tranche3() {
//     return $this->new;
//   }
//   function Tranche4() {
//     return $this->new;
//   }
//   function Tranche5() {
//     return $this->new;
//   }
//   function Tranche6() {
//     return $this->new;
//   }
// }

// $appleS = new clcul($old, $new, $rowBillXy);
// $rowBill =  $appleS->totalNumber();


// $rowBillXy;
// if ($rowBill == $allTranche["Tranche1"]) {
//   $rowBillXy =  $allTranche["Tranche1"];

// }
// $rowBillXy = 0;
// $appleS = new clcul($old, $new, $rowBillXy);
// $rowBill =  $appleS->totalNumber();








  

// echo "
//   <table id='tab' class='table table-hover'>
//   <thead>
//     <tr>
//       <th scope='col'></th>
//       <th scope='col'>Old Bill: $old </th>
//       <th scope='col'></th>
//       <th scope='col'>New Bill: $new </th>
//       <th scope='col'></th>
//       <th scope='col'>Caliber : $rowBill </th>

//     </tr>
//   </thead>
//   <tbody>
//   <tr>
//   <th scope='row'>2</th>
//   <td>Jacob</td>
//   <td>Thornton</td>
//   <td>@fat</td>
//   <td>@mdo</td>
//   <td>@mdo</td>
// </tr>
//     <tr>
//       <th scope='row'>2</th>
//       <td>Jacob</td>
//       <td>Thornton</td>
//       <td>@fat</td>
//       <td>@mdo</td>
//       <td>@mdo</td>
//     </tr>
//     <tr>
//     <th scope='row'>2</th>
//     <td>Jacob</td>
//     <td>Thornton</td>
//     <td>@fat</td>
//     <td>@mdo</td>
//     <td>@mdo</td>
//   </tr>
//   <tr>
//   <th scope='row'>2</th>
//   <td>Jacob</td>
//   <td>Thornton</td>
//   <td>@fat</td>
//   <td>@mdo</td>
//   <td>@mdo</td>
// </tr>
//   </tbody>
// </table>
// <br>
// <input type='button' onclick='createPDF()' value='Export To PDF' />
// ";


//   }
  
  
?>