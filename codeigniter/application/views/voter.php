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
            Election Window
          </div>
          <div class="col-sm-6">
            Election Description
          </div>
        </div>
        <div id="vote_button_container" style="margin-left: auto; margin-right: auto; margin-top: 200px">
          <a href="vote_now.html"><button class="btn btn-xs btn-default" id="vote_button">Vote Now</button></a>
        </div>