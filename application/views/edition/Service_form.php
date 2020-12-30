
	  
<?php
echo form_open(base_url('Service_controller/'.$this->render_object->_get('form_mod')), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );
//champ obligatoire
foreach($required_field AS $name){
	echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
}
?>
<div class="card" >
	<div class="card-header">
		<?php echo $this->lang->line('Service_controller_'.$this->render_object->_get('form_mod'));?>
	</div>	
  	<div class="card-body">
		<div class="form-row">
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('name');
					echo $this->render_object->RenderFormElement('name'); 
				?>
			</div>
			<div class="form-group col-md-2">
				<?php 
					echo $this->render_object->label('code');
					echo $this->render_object->RenderFormElement('code');
				?>
			</div>
			<div class="form-group col-md-2">
				<?php 
					echo $this->render_object->label('type');
					echo $this->render_object->RenderFormElement('type');
				?>
			</div>			
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('amount');
					echo $this->render_object->RenderFormElement('amount'); 
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
