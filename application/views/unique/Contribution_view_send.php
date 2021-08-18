<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
echo form_open('Contribution_controller/SendByMail', array('class' => '', 'id' => 'senmail') , array() );
?>

<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title"><?php echo Lang('SEND_BY_MAIL');?></h5>
		</div>
		<div class="card-body">	
        
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <?php 
                    foreach($datas AS $section => $datalist){ 
                        echo '<a class="nav-link '.(($section == 1) ? 'active':'').'" id="nav-'.$section.'-tab" data-toggle="tab" href="#nav-'.$section.'" role="tab" aria-controls="nav-'.$section.'" aria-selected="true">'.$FieldSection[$section].'</a>';
                    }
                ?>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <?php 
                foreach($datas AS $section => $datalist){
                    ?>
                    <div class="tab-pane fade show <?php echo (($section == 1) ? 'active':''); ?>" id="nav-<?php echo $section;?>" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>			
                                <?php
                                echo '<th scope="col">'.$this->lang->line('user').'</a></th>';
                                echo '<th scope="col">'.$this->lang->line('email').'</a></th>';
                                echo '<th scope="col">'.$this->lang->line('statut').'</a></th>';
                                ?>
                                <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($datalist AS $data){
                            echo '<tr>';
                            echo '<td>'. $data->name.' '.$data->surname.'</td>';
                            echo '<td>'. $data->email.'</td>';
                            echo '<td>';
                            foreach($data->log AS $log){
                                echo '<span class="badge badge-pill '.(($log->status == 'not-sended') ? 'badge-danger':'badge-success').'"> <span class="oi oi-envelope-closed"></span>  '.$log->status.' '.$log->date."</span><br/>";
                            }
                            echo '</td>';
                            echo '<td><input type="checkbox" '.(($data->email) ? '':'disabled="disabled"').'name="ids[]" value="'.$data->id.'|'.$data->email.'" /></td>';
                            echo '</tr>';
                        } ?>
                        </tbody>
                        </table>
                    </div>
        <?php   }  ?>
            </div>     
            <div class="form-group text-right">
				<button type="submit" class="btn btn-primary"><?php echo Lang('sendmail');?></button>
			</div>	
		</div>
	</div>
</div>


<?php
echo form_close();
?>	
