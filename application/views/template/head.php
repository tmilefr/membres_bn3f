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
	<header class="border-bottom">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#"><?php echo $app_name;?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav mr-auto">
					<?php echo $this->render_menu->Get('leftmenu',  $app_name );?>
				</ul>
				<?php
					if ($search_object->autorize){
						$attributes = array('class' => 'form-inline col-md-4', 'id' => 'myform');
						echo form_open($search_object->url, $attributes);?>
						<input class="form-control col-md-11" type="search" name='global_search' id='global_search' placeholder="Search" aria-label="Search" value="<?php echo $search_object->global_search;?>">
						<?php if ($search_object->global_search){ ?>
							<a href='<?php echo base_url($search_object->url);?>/search/reset' class='btn btn-warning btn-sm'><span class="oi oi-circle-x"></span></a>
						<?php } ?>
						</form>
						<?php
					}
					?>
			</div>
			<?php  
			if ($this->render_object->_get('_ui_rules') ){  
				foreach($this->render_object->_get('_ui_rules') AS $rule){
					if (in_array($rule->term , $this->render_object->_get('_not_link_list')) AND $rule->autorize ){
						echo '<a class="btn btn-sm '.$this->lang->line($rule->term.'_class').'" href="'.$rule->url.'"><span class="'.$rule->icon.'"></span> '.$rule->name.'</a>&nbsp;';
					}
				}
			} 
			?>	

			<div class="d-flex align-items-center">
				<ul class="navbar-nav col-auto">
					<li class="nav-item">
						<?php echo $this->render_menu->Get('optionmenu');?>
					</li>
					<li class="nav-item">
						<?php echo $this->render_menu->Get('sysmenu');?>
					</li>
					<li class="nav-item">
						<?php echo $this->render_menu->Get('usermenu',  $this->acl->GetUserName() );?>
					</li>
				</ul>
			</div>			
		</nav>

	</header>
    
    <div class="container-fluid">
		<?php /*<blockquote class="blockquote">
			<p class="mb-0"><?php echo $title;?></p>
			<footer class="blockquote-footer"><?php echo $subtitle;?></footer>
		</blockquote>*/ ?>