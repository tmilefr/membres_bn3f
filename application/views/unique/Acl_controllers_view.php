<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('controller'); ?>
	  </div>
	  <div class="card-body">
		
		<p class="card-text">
			<?php 
				echo $this->bootstrap_tools->label('actions').' : '.$this->render_object->RenderElement('actions').'<br/>'; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>
