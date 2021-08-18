<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="fr">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php $this->bootstrap_tools->RenderAttachFiles('css');?>
		<title><?php echo $app_name;?></title>
	</head>
	<body>
	<div class="wrapper">
		<!-- top menu -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark ml-auto">
			<a href="#menu-toggle" id="menu-toggle"><span class="navbar-toggler-icon"></span></a>
			<a title="<?php echo $slogan;?>" class="navbar-brand" href="<?php echo base_url();?>Home"><?php echo $app_name;?> <small class="text-muted"></small></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		  
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="oi oi-key"></span></a>
					<div class="dropdown-menu">
						<span class="dropdown-item-text"><?php echo $this->session->userdata('usercheck')->name; ?></span>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url('Home/logout');?>"><?php echo Lang('Login_out');?></a>
						<a class="dropdown-item" href="<?php echo base_url('Home/account');?>"><?php echo Lang('Login_account');?></a>
						<div class="dropdown-divider"></div>
						<?php if ($this->acl->hasAccess('acl_users_controller/list')){ ?>
							<a class="dropdown-item" href="<?php echo base_url('Acl_users_controller/list');?>"><?php echo Lang('Acl_users_controller');?></a>
						<?php } ?>						
						<?php if ($this->acl->hasAccess('acl_roles_controller/list')){ ?>
							<a class="dropdown-item" href="<?php echo base_url('Acl_roles_controller');?>"><?php echo Lang('Acl_roles_controller');?></a>
						<?php } ?>
						<?php if ($this->acl->hasAccess('acl_controllers_controller/list')){ ?>
							<a class="dropdown-item" href="<?php echo base_url('Acl_controllers_controller');?>"><?php echo Lang('Acl_controllers_controller');?></a>
						<?php } ?>						
					</div>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="oi oi-cog"></span></a>
					<div class="dropdown-menu">
						<?php if ($this->acl->hasAccess('service_controller/list')){ ?>
							<a class="dropdown-item" href="<?php echo base_url('Service_controller/list');?>"><?php echo Lang('Service_controller');?></a>
						<?php } ?>
						<?php if ($this->acl->hasAccess('taux_controller/list')){ ?>
							<a class="dropdown-item" href="<?php echo base_url('Taux_controller/list');?>"><?php echo Lang('Taux_controller');?></span></a>
						<?php } ?>
						<div class="dropdown-divider"></div>
						<?php if ($this->acl->hasAccess('parameters/view')){ ?>
							<a class="dropdown-item" href="<?php echo base_url('Parameters');?>"><?php echo Lang('Parameters');?></a>
						<?php } ?>
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#AboutModal"><?php echo Lang('About');?></a>
					</div>
				</li>					
				<li class="nav-item"> 
					<span class="title"><?php echo $title;?></span>
				</li>
				<?php  
				if ($this->render_object->_get('_ui_rules') AND !$this->render_object->_get('form_mod')){  

					foreach($this->render_object->_get('_ui_rules') AS $rule){
						if (in_array($rule->term , $this->render_object->_get('_not_link_list')) AND $rule->autorize ){
							echo '<li class="nav-item '.(($this->render_object->_getCi('_action') == $rule->term) ? 'active':'').'"><a class="nav-link " href="'.$rule->url.'"><span class="'.$rule->icon.'"></span> '.$rule->name.'</a></li>';
						}
					}
				} 
				?> 
			
			</ul>
			<ul class="ml-auto navbar-nav nav nav-pills navbar-dark bg-dark">


			</ul>
			<?php
			if ($search_object->autorize){
				$attributes = array('class' => 'form-inline', 'id' => 'myform');
				echo form_open($search_object->url, $attributes);?>
				<input class="form-control mr-sm-2" type="search" name='global_search' id='global_search' placeholder="Search" aria-label="Search" value="<?php echo $search_object->global_search;?>">
				<button class="btn btn-success btn-sm" type="submit"><span class="oi oi-magnifying-glass"></span></button>&nbsp;
				<?php if ($search_object->global_search){ ?>
					<a href='<?php echo base_url($search_object->url);?>/search/reset' class='btn btn-warning btn-sm'><span class="oi oi-circle-x"></span></a>
				<?php } ?>
				</form>
				<?php
			}
			?>
		  </div>
		</nav>	
		
		<!-- Sidebar  -->
		<div id="sidebar" class="bg-dark">
			<?php if ($this->acl->hasAccess('users_controller/list')){ ?>
				<nav class="navbar navbar-dark bg-dark">
					<ul class="navbar-nav mr-auto flex-column">
						<li class="nav-item">
							<a class="nav-link <?php echo (($this->render_object->_getCi('_controller_name') == 'Users_controller') ? 'active':'');?>" href="<?php echo base_url('Users_controller/list');?>">
								<span class="oi oi-person "></span> <?php echo Lang('Users_controller');?></span>
							</a>
						</li>	
					</ul>
				</nav>
			<?php } ?>
			<?php if ($this->acl->hasAccess('contribution_controller/list')){ ?>
			<nav class="navbar navbar-dark bg-dark">
				<ul class="navbar-nav mr-auto flex-column">
					<li class="nav-item">
						<a class="nav-link <?php echo (($this->render_object->_getCi('_controller_name') == 'Contribution_controller') ? 'active':'');?>" href="<?php echo base_url('Contribution_controller/list');?>">
							<span class="oi oi-browser"></span> <?php echo Lang('Contribution_controller');?></span>
						</a>
					</li>	
				</ul>
			</nav>	
			<?php } ?>			
		</div>

		<!-- Page Content  -->
		<div id="content">	
			<nav class="navbar navbar-expand-lg navbar-light bg-light"> 
				<ul class="navbar-nav mr-auto">
					<li class="nav-item"> 
						<h2><?php echo $title;?></h2> 
					</li> 
				</ul>
				<ul class="nav justify-content-end">
				<?php  
				/*if ($this->render_object->_get('_ui_rules') AND !$this->render_object->_get('form_mod')){  
					if ($this->render_object->_get('_ui_rules')['add']->autorize)
						echo '<li class="nav-item"><a class="btn btn-success" href="'.$this->render_object->_get('_ui_rules')['add']->url.'"><span class="oi oi-plus"></span> '.$this->render_object->_get('_ui_rules')['add']->name.'</a></li>'; 
					if (isset($this->render_object->_get('_ui_rules')['sendbymail']) AND $this->render_object->_get('_ui_rules')['sendbymail']->autorize)
						echo '<li class="nav-item"><a class="btn btn-warning" href="'.$this->render_object->_get('_ui_rules')['sendbymail']->url.'"><span class="oi oi-envelope-closed"></span> '.$this->render_object->_get('_ui_rules')['sendbymail']->name.'</a></li>'; 

				} */
				?> 
				</ul> 
			</nav> 	
		

