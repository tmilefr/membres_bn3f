<?php
error_reporting(0);
/*
Colonne I = type de cotisation
F=familiale, I= individuelle, J=jeune (220, 140 ou 100 €)
Colonne J = Section
M= motonautiste, S=ski, V=voile, W=wake
Colonne L = Taux à appliquer (11)
C=comité (0.5) , N=normal (1), D=demi-cotisation (anciens président+Fritz+Franck Girard)
Colonne M = Caravane (12)
0=non  1=oui
Colonne N = Emplacement bateau (13)
N=non AM=parc amont AV=parc aval
(cette distinction n’a plus vraiment lieu d’être vu que les deux sont à 60 Euros)
Colonne O = Hivernage sous chapiteau (14)
(50 € , gratuit pour les membres du comité)
Colonne P = cotisation totale (hors journées de travail) (15)
Colonne Z = Provision encaissées en 2020 
Colonne AA = Provision à fournir pour 2021
*/

$subscriptionMap = ['F'=>['name' => 'familiale', 'amount'=>220] , 'I'=>['name'=>'individuelle','amount'=>110] , 'J'=>['name'=>'jeune','amount'=>100]];

$subscriptionMapVoile = ['J'=>['name' => 'Licence club jeune', 'amount'=>29.50] , 'I'=>['name'=>'Licence club adulte','amount'=>58.50],'F'=>['name'=>'Licence club adulte','amount'=>58.50]];

$sectionMap = ['M'=>'motonautiste','S'=>'ski', 'V'=>'voile', 'W'=>'wake'];
$TauxMap = ['C'=>['name' => 'comité', 'taux'=>0.5] , 'N'=>['name'=>'normal','taux'=>1] , 'D'=>['name'=>'demi-cotisation','taux'=>0.5]];
$PlaceMap = ['N'=>['name' => 'non','amount'=>0] , 'AM'=>['name'=>'parc amont','amount'=>60] , 'AV'=>['name'=>'parc aval','amount'=>60],'V'=>['name'=>'voile','amount'=>0]];
$WinterPLace = ['0'=>['name' => 'non','amount'=>0],'1'=>['name' => 'Hivernage sous chapiteau','amount'=>50] ];
$caravane = [0=>['name' => 'non','amount'=>0],1=>['name' => 'oui','amount'=>250]];

$members = file('./membres.csv');
$member_list = array();
foreach($members AS $key => $value)
{
  $val = str_getcsv ( $value, ";");
  $membre = new StdClass();
  switch($key){
    case 0:
      //echo '<pre>'.print_r( $val ,true).'</pre>';
    break;
    default:
      if (isset($val[1])){
        $name = preg_replace("/\s+/", " ",$val[1]);
        list($membre->nom,$membre->prenom) = explode(" ", $name); //nom prénom
        $membre->adresse = $val[2];
        if ( preg_match('/([0-9]{5})(.*)/',$val[3], $res )){
          $membre->cp = $res[1];
          $membre->ville = trim($res[2]);
        } else {
          $membre->cp = '';
          $membre->ville = $val[3];        
        }
        $membre->fixe = str_replace(['.',','],['',''],$val[4]);
        $membre->mobile = str_replace(['.',','],['',''],$val[5]);
        $membre->mail = $val[6];
        $membre->year =  $val[7];
        $membre->subscription =  $subscriptionMap[$val[8]];
        $membre->section = $sectionMap[$val[9]];
        $membre->licence = 'non';
        if ($val[9] == 'V'){
          $membre->licence = $subscriptionMapVoile[$val[8]];
        }
        $membre->tarif = $TauxMap[$val[11]];
        $membre->caravane = $caravane[$val[12]];
        $membre->place =  $PlaceMap[$val[13]];
        $membre->winterpLace = $WinterPLace[$val[14]];
        $membre->price = $val[15];
        $membre->check = ['todo'=>trim($val[26]),'have'=>trim($val[27])];

        //echo $key.' <pre>'.print_r( $membre ,true).'</pre>';
        $member_list[ $membre->section][] = $membre;
      }
  }
}

echo '<pre>'.print_r( $member_list ,true).'</pre>';

?>