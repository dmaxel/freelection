        <div>
          <?
		  echo form_open('voter/showPage');
		  $form_options = 'onChange="this.form.submit()" style="margin-bottom:10px"';
		  $options = array();
		  $options[-1] = "Select a candidate";
		  foreach($candidates as $each)
		  {
			  $tempID = $each['candidate_id'];
			  $candidate_name = $each['first_name'] . " " . $each['last_name'];
			  $options[$tempID] = "$candidate_name";
		  }
		  echo form_dropdown('available_candidates', $options, $selected_candidate, $form_options);
		  echo form_close();
		   ?>
        </div>
        <div>
          <?
		  if($selected_candidate == -1)
		  {
			  echo "Please select a candidate from the drop-down menu.";
		  }
		  else
		  {
			  foreach($candidates as $each)
			  {
				  if($each['candidate_id'] == $selected_candidate)
				  {
					  echo $each['description'];
				  }
			  }
		  }
          ?>
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
          <a href="vote_now.html"><button class="btn btn-xs btn-default" id="vote_button">Vote Now</button></a>
        </div>