<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('name').' ['.$this->render_object->RenderElement('code');?> ]
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('taux'); 
			?>
		</h5>
		<p class="card-text">

		</p>		
		<?php
			echo $this->render_object->render_element_menu();
		?>
	  </div>
	</div>	
</div>

