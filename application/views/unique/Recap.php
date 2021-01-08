<div class="container-fluid">
	<table class="table table-striped table-sm">
		<thead>
			<tr>			
				<th scope="col"><?php echo $this->lang->line('Membre');?></th>
				<th scope="col"><?php echo $this->lang->line('E-mail');?></th>
				<th scope="col"><?php echo $this->lang->line('Mobile');?></th>
				<th scope="col"><?php echo $this->lang->line('Presations');?></th>
				<th scope="col"><?php echo $this->lang->line('Montants');?></th>
			</tr>
		</thead>
	  <tbody>
	<?php 
		$section = null;
		foreach($datas AS $key=>$cotisation){
			if (!$section OR $cotisation->user->section != $section){
				$section  = $cotisation->user->section;
				echo '<tr><td colspan="5">'.$section.'</td></tr>';
			}
			echo '<tr><td>'.$cotisation->user->name.' '.$cotisation->user->surname.'</td>';
			echo  '<td>'.$cotisation->user->email.'</td>';
			echo  '<td>'.$cotisation->user->mobile.'</td>';
			echo '<td>';
			foreach($cotisation->services AS $key=>$service) { 
				echo '<p>'.$service->taux.' x '.$service->name.' =  '.$service->total.'</p>';
			}
			echo '</td>';
			echo  '<td>'.$cotisation->real.'</td></tr>';
		}
	?>
	</tbody>
	</table>
</div>