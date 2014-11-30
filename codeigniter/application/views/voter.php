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
		<div style="margin-top: 20px">Votes per Hour (Past 24 Hours)</div>
        <div id="votes_graph" style="margin-top:20px">
          <canvas id="votes" height="200" width="400"></canvas>
        </div>
        <div id="vote_button_container" style="margin-left: auto; margin-right: auto; margin-top: 20px">
          <a href="index.php/voter/voteNow"><button class="btn btn-xs btn-default" id="vote_button">Vote Now</button></a>
        </div>
              </div>
    </div>
    <div class="footer">
      <div class="container">
      </div>
           <!--<p><span class="glyphicon glyphicon-copyright-mark"></span> Adam Hair</p>-->
    </div>
    <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart/Chart.js"></script>
    <script>
      var i = 0;
      var colors = ["#FF001A", "#005AFF", "#9AFF00", "#00FF35", "#FFA500", "#6500FF", "#FF00D9", "#9AFF00" ];
      var position_charts = [];
      
var data3 = {
		  labels:
			[
			<?php foreach ($vote_count_labels as $label)
				    echo '"' . $label . '", ';
			?>
		    ],
          datasets: [
              {
                  label: "Election 1",
                  fillColor: "rgba(255,51,51,1)",
                  strokeColor: "rgba(255,51,51,1)",
                  pointColor: "rgba(255,51,51,1)",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(255,51,51,1)",
                  data: 
				    [
					<?php foreach ($votes_by_hour as $votes)
						echo $votes . ',';
					?>
				    ]
              }
          ],
      };
	  
	  
       var ctx3 = document.getElementById("votes").getContext("2d");
      var votes = new Chart(ctx3).Bar(data3,{height:200,width:400});
    </script>
  </body>
</html>