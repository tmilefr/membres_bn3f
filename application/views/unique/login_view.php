<div class="card" >
	<div class="card-body">
	  
<?php
echo form_open(base_url('/Home/login'), array('class' => '', 'id' => 'login') , array('form_mod'=>'') );


echo $this->session->flashdata('message');
?>

  <div class="form-group">
	<?php echo form_label('Login', 'login'); ?>
	<?php echo form_input('login', '', 'class="form-control" aria-describedby="emailHelp" placeholder="Enter email"'); ?>
    <?php echo form_error('login', 	'<div class="alert alert-danger">', '</div>'); ?>
  </div>
  <div class="form-group">
	<?php echo form_label('Password', 'password'); ?>
	<?php echo form_password('password', 'password', 'class="form-control" aria-describedby="passwordHelp" placeholder="Password"'); ?>
    <?php echo form_error('password', 	'<div class="alert alert-danger">', '</div>'); ?>	  
  </div>

  <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('SUBMIT');?></button>
<?php
echo form_close();
?>
	</div>
</div>

