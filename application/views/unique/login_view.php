<div class="card" >
	<div class="card-body">
	  
<?php
echo form_open(base_url('/Home/login'), array('class' => 'login', 'id' => 'login-form') , array('form_mod'=>'') );


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

	<button class="g-recaptcha" data-sitekey="<?php echo SITE_CAPTCHA_KEY;?>" data-callback='onSubmit' data-action='submit'>Submit</button>
	
  <script src="https://www.google.com/recaptcha/api.js"></script>

  <script>
   function onSubmit(token) {
     document.getElementById("login-form").submit();
   }
 </script>

<?php
echo form_close();
?>
	</div>
</div>

