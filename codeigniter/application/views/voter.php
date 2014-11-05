        <div>
          <?
		  $options = array();
		  $i = 1;
		  foreach($candidates as $each)
		  {
			  $candidate_name = $each['first_name'] . " " . $each['last_name'];
			  $options[] = "$candidate_name";
			  $i = $i + 1;
		  }
		  echo form_dropdown('candidates', $options, 0, 'style="margin-bottom:10px"');
		   ?>
        </div>
        <div>
          Candidate Description Candidate Description Candidate Description Candidate Description
          Candidate Description Candidate Description Candidate Description Candidate Description
        </div>
        <div class="row" style="margin-top: 50px">
          <div class="col-sm-6">
            <? 
			$start_time = strtotime($election_window['voting_window_start']);
			$formatted_start = date("M d, Y g:i A", $start_time);
			
			$end_time = strtotime($election_window['voting_window_end']);
			$formatted_end = date("M d, Y g:i A", $end_time);
			
			echo $formatted_start;
			echo "<br>";
			echo "until";
			echo "<br>";
			echo $formatted_end;
			?>
          </div>
          <div class="col-sm-6">
            <? echo $election_description; ?>
          </div>
        </div>
        <div id="vote_button_container" style="margin-left: auto; margin-right: auto; margin-top: 200px">
          <a href="vote_now.html"><button class="btn btn-xs btn-default" id="vote_button">Vote Now</button></a>
        </div>