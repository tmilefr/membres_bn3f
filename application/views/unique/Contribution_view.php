
<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
			Appel à cotisation Année<?php echo $datas->year;?> Section <?php echo $datas->user->section?> 	<div class="float-right"><?php echo $url_pdf;?></div>
	  </div>
	  <div class="card-body">
	  
		<h5 class="card-title">
			<?php echo $datas->user->name.' '.$datas->user->surname;?><br/>
			<?php echo $datas->user->adresse?><br/>
			<?php echo $datas->user->cp.' '.$datas->user->ville;?>
		</h5>
		<table class="table">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">Designation</th>
			<th scope="col">Montant</th>
			<th scope="col">Taux</th>
			<th scope="col">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sum=0;
			foreach($datas->services AS $key=>$service) { 
			?>
			<tr>
				<th scope="row"><?php echo $key;?></th>
				<td><?php echo $service->name;?></td>
				<td><?php echo $service->amount;?></td>
				<td><?php echo $service->taux;?></td>
				<td><?php echo $service->total;?></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfooter>
			<th scope="row"></th>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo $datas->amount;?> / <?php echo $datas->real;?></td>	
		</tfooter>
		</table>
		<?php if ($datas->taux->code != 'C'){ ?>
			<?php if (isset($datas->check->todo)){ ?>
			<p class="card-text">Provisions journées de travail encaissées en 2020 <?php echo $datas->check->encaisse;?> €</p>
			<?php } ?>
			<p class="card-text">Provisions journées de travail 2021 : 
				<?php if (isset($datas->check->todo)){ ?>
				<?php echo $datas->check->todo;?> € (Chèque à réaliser)
				<?php } ?>
				<?php if (isset($datas->check->have)){ ?>
				<?php echo $datas->check->have;?> (Chèque en notre possession)
				<?php } ?>
			</p>
		<?php } else { ?>
			<p class="card-text"> exonéré </p>
			<?php } ?>
		<br/>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>


