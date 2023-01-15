<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	font-family: Arial, Verdana, Geneva, Sans-serif;
	font-size: 14px;
	color: #4F5155;
}

@page { margin: 90px 10px 0px 20px; }

#header { position: fixed; left: 0px; top: -80px; right: 0px; height: 50px; text-align: center; }
#footer { position: fixed; left: 0px; bottom: 0px; right: 0px; height: 100px; text-align: center;  }
#footer .page:after { content: counter(page, upper-roman); }
#content {text-align:left; padding-bottom:40px; }


table{
	width:100%;
	background-color:#FFF;
	margin: auto;
}

.table_page{
	width:80%;
}

.table_border{
	border: 0.5px solid #000000;
}

table td{
	padding: 2px;
	margin : 0px;
	font-family: Arial, Verdana, Geneva, Sans-serif;
	font-size: 14px;
	vertical-align: top;
}

.nowrap{
	white-space:nowrap;
}

table .small{
	font-size: 10px;
}

.souligne{
	border-top: 0.5px solid #000000;
}

.sep_dashed{
	border-top: 1px dotted #000000;
	padding-top:5px;
}

.text-right{
	text-align:	right;
}

.text-center{
	text-align:	center;
}


table th {
	font-weight: bold;
	font-size: 14px;
	background-color: #666;
	color: #fff;
	padding: 0px 2px 0px 2px;
	white-space:nowrap;
	vertical-align: top;
}


h1{
	color: #444;
	font-size: 22px;
	margin:0;
	padding:0;
}

h2{
	color: #444;
	font-size: 16px;
	margin:0;
	padding:0;
}


h3{
	color: #444;
	font-size: 14px;
	margin:0;
	padding:0;
}

h4{
	color: #444;
	font-size: 12px;
	margin:0;
	padding:0;
}

p{
	font-size: 11px;
	margin:0;
	padding:0;
}

#footer {

}

#footer p{
	font-size:10px;
	text-align:left;
	padding-left:100px;
}


.pair{
	background-color:#F4FAFF;
	color:#515252;
}

.red{
	color:#E0212F;
}
.blue{
	color:#72B1D7;
}
.violet{
	color:#AF5C91;
}

.underline{
	text-decoration:underline;
}

.nowrap{
	white-space:nowrap;
}
</style>
</head>
<body>
<div id="header">
	
</div>
<div id="footer">
		<p>Base Nautique des 3 frontières</p>
		<table class="table_page">
		<tr><td>
		<p>RIB </p>
		<table class="small">
		<tr>
		<td>Banque</td><td>Guichet</td><td>N° Compte</td><td>Clé</td><td>DEV</td></tr>
		<td>10278</td><td>03050</td><td>00021587145</td><td>35</td><td>EUR</td></tr>
		</table>
		</td><td> </td><td>
		<p>IBAN</p>
		<table class="small">
		<tr><td>FR76</td><td>1027</td><td>8030</td><td>5000</td><td>0215</td><td>8714</td><td>535</td></tr>
		</table>
		</td></tr>
		</table>
 </div>
<div id="content">
	<table class="table_page">
	<tr><td rowspan ="2">
		<?php echo $logo;?>
	</td><td class="nowrap">
		<h1>Base Nautique des 3 frontières</h1>
		<h2>Appel à cotisation Année <?php echo $datas->year;?></h2>
		<br />
	</td><td class="text-right">
		Section <br/><?php echo $datas->user->section?>
	</td>
	</tr>		
	<tr>
		<td>
			<h2>
				<?php echo $datas->user->name.' '.$datas->user->surname;?><br/>
				<?php echo $datas->user->adresse?><br/>
				<?php echo $datas->user->cp.' '.$datas->user->ville;?>
			</h2>
			<br /><br />		
		</td>
	</tr>
	</table>
	<table  class="table_page table_border">
	<thead>
		<tr>
		<th>Designation</th>
		<th class="text-center">Montant</th>
		<th class="text-center">Nb</th>
		<th class="text-center">Taux</th>
		<th class="text-center">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($datas->services AS $key=>$service) { 
		?>
		<tr>
			<td><?php echo $service->name;?></td>
			<td class="text-center"><?php echo $service->amount;?></td>
			<td class="text-center">1</td>
			<td class="text-center"><?php echo $service->taux;?></td>
			<td class="text-right"><?php echo $service->total;?></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfooter>
		<td class="text-right sep_dashed" colspan="4"><p>Montant à payer ( provisions jounrées de travail NON incluses)</p></td>
		<td class="text-right sep_dashed"><?php echo $datas->real;?> €</td>	
	</tfooter>
	</table>
	<table  class="table_page">
	<tr><td>
		<p>Si vous désirez changer de type de cotisation (familliale, individuelle, jeune) merci d'en avertir le comité</p>
		<br/><br/>
		<h3>Payement par chèque, liquide ou virement bancaire. (RIB ci-joint)</h3>
		<br/><br/>
	</td></tr>
	</table>

	<?php if ($datas->taux->code != 'C' && $datas->taux->code != 'D'){ ?>
	<table  class="table_page table_border ">
	<tr><td class="nowrap">
		<h3>Provisions journées de travail encaissées en 2022</h3>
	</td><td>
		<?php 
		if (isset($datas->check->encaisse)){
		 	echo $datas->check->encaisse.' €';
		} 
		?>
	</td></tr>
	<tr><td>
		<h3>Provisions journées de travail à régler pour 2023 </h3>
	</td><td>
		<?php if (isset($datas->check->todo) AND $datas->check->todo){ ?>
		<?php echo $datas->check->todo;?> €
		<?php } ?>
	</td></tr>
	</tr>
	<tr><td>
		<?php if (isset($datas->check->have) AND $datas->check->have){ ?>
		Chèque en notre possession 
		<?php } ?>
	</td><td>
		<?php if (isset($datas->check->have) AND $datas->check->have){ ?>
		<?php echo $datas->check->have;?> € 
		<?php } ?>
	</td></tr>	
	</table>
	<?php } else { ?>
		<table  class="table_page table_border ">
		<tr><td class="nowrap">
			<h3>Provisions journées de travail : </h3>
		</td><td>
			Exonéré
		</td></tr>
		</table>
	<?php } ?>		 
	<br />
	<table  class="table_page">	
	<tr><td colspan="2">
		<p>
		<b><u>Provisions journées de travail</u></b> : Merci de joindre  des chèques séparés pour les journées de travail (Que nous n'encaisserons pas)
		En cas de payement en liquide ou par virement, (ceux qui ne disposent pas d'un chéquier) merci d'ajouter le montant des provisions à votre montant total.
		P.S. Mettez impérativement l'ordre (BN3F) sur vos chèques de provisions. Si vous ne mettez pas de date, cela vous évitera d'en refaire l'année prochaine ...
		</p>
		
	</td></tr>
	</table>		 
	<br /><br/>
	<table  class="table_page table_border">
	<tr><td>
		Date limite de payement
	</td><td>
		28 février 2023
	</td></tr>
	<tr><td>
		Majoration pour payement ultérieur
	</td><td>
		50 € par mois entamé
	</td></tr>
	</table>
	<table  class="table_page">
	<tr><td colspan="2">
		<b>Au 1er avril, l’accès sera bloqué pour les membres non à jour de cotisation</b><br/>
		Après cette date, vous devrez re-payer les droits d'entrée comme un nouveau membre

		<br/><br />
		<h3>Pour le comité</h3>
	</td></tr>
	</table>	


</div>

</body>
</html>

