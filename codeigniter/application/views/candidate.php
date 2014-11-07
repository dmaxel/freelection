        <div>
            <? echo $candidate_info['first_name']. " " . $candidate_info['last_name']; ?>
        </div>
        <div class="row" style="margin-top:50px">
          <div class="col-sm-6">
            Candidate Description
          </div>
          <div class="col-sm-6">
			  <?
			  echo form_open('candidate/updateDescription');
			  $attributes = array(
								'name' => 'description_field',
								'value' => $candidate_info['description']
			  				);
			  echo form_input($attributes);
			  ?>
          </div>
        </div>
        <div class="row" style="margin-top: 50px">
          <div class="col-sm-6">
            <? 
			$start_time = strtotime($election_window['voting_window_start']);
			$formatted_start = date("M d, Y g:i A", $start_time);
			
			$end_time = strtotime($election_window['voting_window_end']);
			$formatted_end = date("M d, Y g:i A", $end_time);
			
			echo "<strong>Voting Window:</strong><br>";
			echo $formatted_start;
			echo "<br>";
			echo "until";
			echo "<br>";
			echo $formatted_end;
			?>
          </div>
          <div class="col-sm-6">
            <?
			echo "<strong>Election Description:</strong><br>";
			echo $election_description;
			?>
          </div>
        </div>
        <div id="vote_button_container" style="margin-left: auto; margin-right: auto; margin-top: 200px">
			<?
	 	   $attributes = array(
	           'name' => 'description_submit',
	           'value' => 'Update',
	           'class' => 'btn btn-xs btn-default',
			   'id' => 'vote_button'
	           ); 
			echo form_submit($attributes, 'Update');
			echo form_close();
			?>
        </div>