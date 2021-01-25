<?php
/*
  Dupa lupte seculare cu Oracle Database 11g Express Edition, OracleInstantClient 11.2, si  php_oci8_11g.dll, am trecut la MySql.
    Oracle™, it just doesn't work ©
*/

error_reporting(-1);
$lk = mysqli_connect("localhost", "root", "root", "java");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit(); //echo mysqli_errno($lk)." : ".mysqli_error($lk);
}

echo "<html><head><style>
.tab{
  display:inline-block;
  padding:5px;
  width:130px;
  vertical-align: text-top;
  border:none;
}
.border{
  display:inline-block;
  border-style: solid;
  border-width: 1px;
  border-color: red;
}
:not(.border) > .tab {
  margin:5px;
}
</style></head><body>";

//var_dump($_GET);
//$_GET["name"]
echo '<a href="?">Clear</a></br/><br/>';


if(isset($_GET["action"])) {
  if ($_GET["action"]=="delete"){
    $sql = 'DELETE FROM '.$_GET["table"]
    .' WHERE '.$_GET["target"].'="'.$_GET["id"].'";';
    //echo $sql;
    $r = mysqli_query($lk, $sql);
    //echo mysqli_errno($lk)." : ".mysqli_error($lk);
  }
  if($_GET["action"]=="add"){

    $sql = 'INSERT INTO '.$_GET["table"].' VALUES (';
    foreach ($_GET as $n => $v){
      if($n[0]=="f")
        $sql .= '"'.$v.'", ';
    }
    $sql = substr($sql, 0, -2);
    $sql .= ');';
    //echo $sql;
    mysqli_query($lk, $sql);
  }

  if($_GET["action"]=="edit"){
    if($_GET["table"]=="persoana") {
      $sql = 'UPDATE `persoana` SET
      `nume`="'.$_GET["nume"].'",
      `prenume`="'.$_GET["prenume"].'",
      `carteidentitate`="'.$_GET["carteidentitate"].'",
      `cnp`="'.$_GET["cnp"].'",
      `adresa`="'.$_GET["adresa"].'"
       WHERE '.$_GET["target"].'="'.$_GET["id"].'";';
      mysqli_query($lk, $sql);
    }
    if($_GET["table"]=="proprietate") {
      $sql = 'UPDATE `proprietate` SET
      `cnp`="'.$_GET["cnp"].'",
      `nrvehicol`="'.$_GET["nrvehicol"].'",
      `datacumpararii`="'.$_GET["datacumpararii"].'",
      `pret`="'.$_GET["pret"].'"
       WHERE '.$_GET["target"].'="'.$_GET["id"].'";';
      mysqli_query($lk, $sql);
      ;
    }
    if($_GET["table"]=="vehicol") {
      $sql = 'UPDATE `vehicol` SET `nrvehicol`="'.$_GET["nrvehicol"].'",
      `marca`="'.$_GET["marca"].'",
      `tip`="'.$_GET["tip"].'",
      `seriemotor`="'.$_GET["seriemotor"].'",
      `seriecaroserie`="'.$_GET["seriecaroserie"].'",
      `carburant`="'.$_GET["carburant"].'",
      `culoare`="'.$_GET["culoare"].'",
      `culoare`="'.$_GET["culoare"].'",
      `capacitatecil`="'.$_GET["capacitatecil"].'"
       WHERE '.$_GET["target"].'="'.$_GET["id"].'";';
      mysqli_query($lk, $sql);
      ;
    }
  }
}


function table($table, $target){
  global $lk;
  if($r = mysqli_query($lk, "SELECT * FROM ".$table)){
  	while ($row = mysqli_fetch_assoc($r)){
      echo '<form id="'.$table.'" action="?" method="get">
      <input type="hidden" id="table" name="table" value="'.$table.'">
      <input type="hidden" id="target" name="target" value="'.$target.'">';
      $id="";
  		foreach($row as $a => $b){
    		echo '<input class="tab" id="'.$a.'" name="'.$a.'" value="'.$b.'" />';
        if($a===$target) $id=$b;
      }
    echo '<input type="hidden" id="id" name="id" value="'.$id.'">
    <div class="tab">
    <button  type="submit" id="action" name="action"  value="edit">Edit</button>
    <button  type="submit" id="action" name="action"  value="delete">Delete</button>
    </div><br/></form>';
  	}
  }
}
//table('persoana','cnp');

function head($table, $text, $arr){
  echo '<br/>'.$text.': <br/>
  <div class="border">';
  foreach($arr as $nume)
    echo '<div class="tab">'.$nume.'</div>';
  echo '<div class="tab">Action</div>
  </div><br/>';
}
//header('persoana','Persoane',["","","",""]);

$list['persoana'] = ["Nume","Prenume","Carte Identitate","CNP","Adresa"];
$list['proprietate'] = ["CNP","NR Vehicol","Data Cumpararii","Pret"];
$list['vehicol'] = ["NR Vehicol", "Marca","Tip","Serie Motor","Serie Caroserie","carburant","Culoare","Capacitate Cilindrica"];

function form($name, $arr){
  echo '<form id="'.$name.'" action="?" method="get">
  <input type="hidden" id="table" name="table" value="'.$name.'">
  <input type="hidden" id="action" name="action" value="add">';
  foreach($arr as $i => $name)
    echo '<input class="tab" type="text" id="f'.($i+1).'" name="f'.($i+1).'" placeholder="'.$name.'" >';
  echo '<button  type="submit" value="add">Add</button>
  <div class="tab">
  <!--<a href="" onclick="this.parentNode.submit();">Add</a>-->
  </div>
  </form>';
}
//form($name, $list['persoana']);


head('persoana','Persoane',$list['persoana']);
table('persoana','cnp');
form("persoana", $list['persoana']);

head('proprietate','Proprietati',$list['proprietate']);
table('proprietate','nrvehicol');
form("proprietate", $list['proprietate']);

head('vehicol','Vehicul',$list['vehicol']);
table('vehicol','nrvehicol');
form("vehicol", $list['vehicol']);



$sql = 'SELECT DISTINCT marca FROM vehicol;';
$r = mysqli_query($lk, $sql);
$total=0;
while($marca = mysqli_fetch_row($r)) {
  $sql = 'SELECT count(*) FROM vehicol WHERE marca = "'.$marca[0].'";';
  $r2 = mysqli_query($lk, $sql);
  $count = mysqli_fetch_row($r2);
  echo $count[0].' masina marca '.$marca[0].', ';

  $sql = 'SELECT nrvehicol FROM vehicol WHERE marca = "'.$marca[0].'";';
  $r2 = mysqli_query($lk, $sql);
  $sum=0;
  while($nrvehicol = mysqli_fetch_row($r2)) {
    $sql = 'SELECT pret FROM proprietate WHERE nrvehicol = "'.$nrvehicol[0].'";';
    $r3 = mysqli_query($lk, $sql);
    $pret = mysqli_fetch_row($r3);
    $sum += $pret[0];
  }
  echo 'costing a total of '.$sum.'.<br/>';
  $total += $sum;
}
echo 'The cars were sold for a total amount of '.$total.'.<br/>';






/*
Proiect2
- baza de date se compune din următoarele tabele:
(a) vehicol(nrvehicol,marca, tip, seriemotor, seriecaroserie, carburant,culoare,
capacitatecil)
(b) persoana(nume,prenume, carteidentitate, cno, adresa)
(c) proprietate(cnp,nrvehicol, datacumpararii, pret)
Și are următoarele cerințe:
(a) Creati baza de date
(b) Instantiati baza de date
(c) Determinati numarul de marci si numarul de masini din fiecare marca
(d) Determinati cu functii marcile si valoarea totala a masinilor cumparate



Cerințe proiect

1.Proiectul este individual. Structurile propuse ale bazelor de date sunt orientative,
ele pot fi modificate
2. Limbajul de programare pentru dezvoltarea aplicației este la alegere (ex. Java,
PHP, Python, Visual Studio C# etc.).
3. Sistemul de Gestiune a Bazei de Date (SGBD) va fi relațional in ORACLE și va
trebui să suporte un limbaj de programare procedural.
4. Se vor defini constrângeri de integritate pe structurile tabelare.
5. Pentru a putea fi acceptată prezentarea proiectului, aplicația trebuie să conțină o
interfață grafică ce permite introducerea de date, modificarea lor si afisarea lor
si eventualal cerinte suplimentare, precum și descrierea aplicației separat.
6. Aplicatia se trimite sub forma de arhiva. Arhiva va avea
numele GrupaSeriaAnNumePrenume. 223
8. Se depunctează nefuncționarea corectă a aplicației.
Documentația
Documentația va fi structurată astfel:
(a) Descrierea bazei de date:
i. Diagrama bazei de date
ii. Structura tabelelor
(b) Descrierea aplicației:
i. Prezentarea modului în care se face conexiunea cu baza de date
ii. Diagrama de clase
(c) Capturi de ecran.
(d) Concluzii

*/
