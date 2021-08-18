<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<div class="accordion" id="accordionMembre">
			<?php
			foreach($list_membres AS $section => $membres){
				?>
				<div class="card">
					<div class="card-header" id="heading<?php echo $section;?>">
						<h2 class="mb-0">
							<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $section;?>" aria-expanded="true" aria-controls="collapse<?php echo $section;?>">
								<?php echo $section.' : '.$FieldSection[$section].'  <span class="badge badge-primary badge-pill">'.count($membres).'</span>';?>
							</button>
						</h2>
					</div>

					<div id="collapse<?php echo $section;?>" class="collapse" aria-labelledby="heading<?php echo $section;?>" data-parent="#accordionMembre">
						<div class="card-body">
							<div class="row row-cols-1 row-cols-md-3">
							<?php 
							foreach( $membres AS $membre){?>
								<div class="col mb-4">
									<div class="card">
									<div class="card-body">
										<h5 class="card-title"><?php echo $membre->name.' <small class="text-muted">'. $membre->surname;?></small></h5>
										<p class="card-text"><?php echo $membre->email.' <br/> '. $membre->mobile;?></p>
    									<a class="card-link oi " href="Users_controller/view/<?php echo $membre->id;?>" class="btn btn-primary"><span class="oi oi-magnifying-glass"></span></a>
										<a class="card-link oi " href="Users_controller/edit/<?php echo $membre->id;?>" class="btn btn-primary"><span class="oi oi-pencil"></span></a>
									</div>
									</div>
								</div>
					<?php	}	?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
	</div>
</div>