<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title"><?php echo Lang('RECAP_BY_SECTION');?></h5>
		</div>
		<div class="card-body">	
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
				<?php 
					foreach($datas AS $section => $datalist){ 
						echo '<a class="nav-link '.(($section == 1) ? 'active':'').'" id="nav-'.$section.'-tab" data-toggle="tab" href="#nav-'.$section.'" role="tab" aria-controls="nav-'.$section.'" aria-selected="true">'.$FieldSection[$section].'</a>';
					}
				?>
				</div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
            <?php 
                foreach($datas AS $section => $datalist){
                    ?>
                    <div class="tab-pane fade show <?php echo (($section == 1) ? 'active':''); ?>" id="nav-<?php echo $section;?>" role="tabpanel" aria-labelledby="nav-home-tab">
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
							foreach($datalist AS $key=>$cotisation){
								if (isset($cotisation->user) && isset($cotisation->services)){
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
							}
						?>
						</tbody>
						</table>
					</div>
		<?php   } ?>
		</div>
		</div>
</div>