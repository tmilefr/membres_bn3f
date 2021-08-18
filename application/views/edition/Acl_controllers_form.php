<div class="container-fluid">

<?php
echo form_open('Acl_controllers_controller/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

//champ obligatoire
foreach($required_field AS $name){
	echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
}
?>
<div class="form-row">
	<div class="form-group col-md-4">
		<?php 
			echo $this->bootstrap_tools->label('controller');
			echo $this->render_object->RenderFormElement('controller'); 
		?>
	</div>
	<div class="form-group col-md-8">
		<?php 
			echo $this->bootstrap_tools->label('actions');
			echo $this->render_object->RenderFormElement('actions');
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
