<div class="row">
          <div class="col-xs-4">
            <a href="index.php/voter/showPage"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-xs-8">
          </div>
        </div>
			<?
			echo form_open('voter/processBallot');
			$form_options = 'style="margin-bottom:10px"';
			foreach($positions as $position)
			{
				echo '<div class="row"><div class="col-sm-4" style="margin-top:10px;">';
				echo $position['title'];
				echo '</div><div class="col-sm-4" style="margin-top:10px;">';
				$options = array();
				if($position['type'] == 0)
				{
					foreach($list[$position['position']] as $each)
					{
		  			  $tempID = $each['candidate_id'];
		  			  $candidate_name = $each['first_name'] . " " . $each['last_name'];
		  			  $options[$tempID] = $candidate_name;
					}
					if($position['write_ins'] == 1)
					{
					  $options[-1] = "Write-In Candidate";
					}
					echo form_dropdown('choices'.$position['position'], $options, 0, $form_options);
					echo "</div>";
				}
				else if($position['type'] == 1)
				{
					$options = $list[$position['position']];
				}
				else if($position['type'] == 2)
				{
					foreach($list[$position] as $each)
					{
		  			  $tempID = $each['proposition_id'];
		  			  $options[$tempID] = $each['proposition_description'];
					}
					echo form_dropdown('choices'.$position['position'], $options, 0, $form_options);
					echo "</div>";
				}
				if($position['write_ins'] == 1 && $position['type'] == 0)
				{
					echo '<div class="col-sm-4" style="margin-top:10px;">';
	                $parameters = array(
	   						'name' => $position['position'].'_first_name',
	   						'placeholder' => 'First Name'
	   						);
	   			 	echo form_input($parameters);
	            	$parameters = array(
							'name' => $position['position'].'_last_name',
							'placeholder' => 'Last Name'
							);
					echo form_input($parameters);
				 	echo "</div></div>";
				}
				else if($position['write_ins'] == 1 && $position['type'] == 2)
				{
					echo '<div class="col-sm-4" style="margin-top:10px;">';
	                $parameters = array(
	   						'name' => $position['position'].'_description',
	   						'placeholder' => 'Proposition Description'
	   						);
	   				echo form_input($parameters);
					echo "</div>";
				}
				else
				{
					echo '<div class="col-sm-4" style="margin-top:10px;">';
					//echo ' ';
					echo "</div></div>";
				}
			}
			echo '<div id="vote_button_container" style="margin-left: auto; margin-right: auto; margin-top: 100px">';
			$data = array(
						'name' => 'submitballot',
						'value' => 'Submit Ballot',
						'class' => 'btn btn-xs btn-default'
						);	
			echo form_submit($data, 'Submit Ballot');
			echo '</div>';
			echo form_close();
		
			?>
