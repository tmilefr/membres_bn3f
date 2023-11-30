<div class="card" >
	<div class="card-header">
		<?php echo $this->lang->line($this->render_object->_getCi('_controller_name').'_'.$this->render_object->_get('form_mod'));?>
	</div>
	<div class="card-body">
		<?php
		echo form_open($this->render_object->_getCi('_controller_name').'/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

		//champ obligatoire
		foreach($required_field AS $name){
			echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
		}
		?>
		<div class="form-row">
			<div class="form-group col-md-4">
				<?php 
					echo $this->bootstrap_tools->label('action');
					echo $this->render_object->RenderFormElement('action'); 
				?>
			</div>
			<div class="form-group col-md-8">
				<?php 
					echo $this->bootstrap_tools->label('id_ctrl');
					echo $this->render_object->RenderFormElement('id_ctrl');
				?>
			</div>
		</div>
		<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
		<?php
		echo $this->render_object->RenderFormElement('created'); 
		echo $this->render_object->RenderFormElement('updated'); 
		echo form_close();
		?>
	</div>
</div>
