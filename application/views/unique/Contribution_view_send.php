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
            <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>			
                    <?php
                    echo '<th scope="col">'.$this->lang->line('user').'</a></th>';
                    ?>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach($datas AS $key => $data){
                echo '<tr>';
                echo '<td>'. $data->name.' '.$data->surname.'</td>';
                echo '<td>'. $data->email.'</td>';
                echo '<td>';
                foreach($data->log AS $log){
                    echo '<span class="oi oi-envelope-closed" title="'.urlencode($log->log).'"></span> '.$log->status.' '.$log->date."<br/>";
                }
                echo '</td>';
                echo '<td><input type="checkbox" '.(($data->email) ? '':'disabled="disabled"').'name="ids[]" value="'.$data->id.'|'.$data->email.'" /></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
            </table>

			<div class="form-group text-right">
				<button type="submit" class="btn btn-primary"><?php echo Lang('sendmail');?></button>
			</div>	
		</div>
	</div>
</div>


<?php
echo form_close();
?>	
