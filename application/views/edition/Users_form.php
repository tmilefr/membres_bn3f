<?php
echo form_open('Users_controller/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

//champ obligatoire
foreach($required_field AS $name){
	echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
}
?>


<div class="card" >
	<div class="card-header">
		<?php echo $this->lang->line('Users_controller_'.$this->render_object->_get('form_mod'));?>
	</div>	
  <div class="card-body">
	<div class="form-row">
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('name');
				echo $this->render_object->RenderFormElement('name'); 
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('surname');
				echo $this->render_object->RenderFormElement('surname');
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('section');
				echo $this->render_object->RenderFormElement('section'); 
			?>
		</div>		
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('email');
				echo $this->render_object->RenderFormElement('email'); 
			?>
		</div>
		<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('emails');
					echo $this->render_object->RenderFormElement('emails'); 
				?>
			</div>		
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('fixe');
				echo $this->render_object->RenderFormElement('fixe');
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('mobile');
				echo $this->render_object->RenderFormElement('mobile'); 
			?>
		</div>		
	</div>	
	<div class="form-row">
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('adresse');
				echo $this->render_object->RenderFormElement('adresse'); 
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('cp');
				echo $this->render_object->RenderFormElement('cp');
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('ville');
				echo $this->render_object->RenderFormElement('ville'); 
			?>
		</div>		
	</div>	
	<div class="form-row">
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('year');
				echo $this->render_object->RenderFormElement('year'); 
			?>
		</div>		
	</div>		
	<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
</div>
<?php
	echo $this->render_object->RenderFormElement('created'); 
	echo $this->render_object->RenderFormElement('updated'); 
echo form_close();
?>
</div>
