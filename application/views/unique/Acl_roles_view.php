<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('role_name'); ?>
	  </div>
	  <div class="card-body">
		
		<p class="card-text">
			<?php 
				echo $this->bootstrap_tools->label('role_description').' : '.$this->render_object->RenderElement('role_description').'<br/>'; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>
