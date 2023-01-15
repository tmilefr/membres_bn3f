<div class="card" >
	<div class="card-header">
		<?php 
		
			if ($id_prec > 0)
				echo '<a class="float-left btn btn-info btn-sm" href="'.base_url('Contribution_controller/edit/'.$id_prec).'"><</a> ';
			echo $this->lang->line('Contribution_controller_'.$this->render_object->_get('form_mod'));
			echo ' '.$url_pdf;

			if ($id_suiv > 0)
				echo '<a class="float-right btn btn-info btn-sm" href="'.base_url('Contribution_controller/edit/'.$id_suiv).'">></a>';
		?>
		<?php ?>
	</div>
	<div class="card-body">
		<?php


		echo form_open(base_url('Contribution_controller/'.$this->render_object->_get('form_mod').'/'.$id), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );
		//champ obligatoire
		foreach($required_field AS $name){
			echo form_error($name, 	'<div class="alert alert-danger">', '</div>');
		}
		?>
		<div class="form-row">
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('user');
					echo $this->render_object->RenderFormElement('user'); 
				?>
			</div>
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('year');
					echo $this->render_object->RenderFormElement('year');
				?>
			</div>
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('amount');
					echo $this->render_object->RenderFormElement('amount'); 
				?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('taux');
					echo $this->render_object->RenderFormElement('taux');
				?>
			</div>	
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('presta');
					echo $this->render_object->RenderFormElement('presta'); 
				?>
			</div>
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('check');
					echo $this->render_object->RenderFormElement('check');
				?>
			</div>				
		</div>
		<?php echo $this->session->flashdata('state');?>
		<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
		
		<?php
		echo $this->render_object->RenderFormElement('created'); 
		echo $this->render_object->RenderFormElement('updated'); 		
		echo form_close();
		?>
	</div>
</div>