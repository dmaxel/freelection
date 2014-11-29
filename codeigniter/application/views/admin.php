<div class="row" style="margin-top:-20px; margin-bottom:10px; font-size:10px">
          <div class="col-sm-3">
            <a href="index.php/admin/view_users"><button class="btn btn-xs btn-default" id="vote_button">Users</button></a>
          </div>
          <div class="col-sm-3">
            <a href="index.php/admin/view_pending"><button class="btn btn-xs btn-default" id="pending_button">Pending</button></a>
          </div>
          <div class="col-sm-3">
            <a href="index.html/admin/vote_search"><button class="btn btn-xs btn-default" id="search_button">Search</button></a>
          </div>
          <div class="col-sm-3">
            <a href="index.php/admin/view_elections"><button class="btn btn-xs btn-default" id="elections_button">Elections</button></a>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">

            <?php
              echo form_open('admin');
              $form_options = 'onChange="this.form.submit()" style="margin-bottom:10px"';
              
              echo form_dropdown('election_dropdown', $election_options, $selected_election_id, $form_options);
              echo form_close();
            ?>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?php
            if ($selected_election_id != -1)
            {
				echo "<strong>Description:</strong><br>";
				echo $election_description;
			}
            else
                echo "Pick an election to display its statistics";
            ?>
          </div>
          <div class="col-sm-6">
          <?php
            if ($selected_election_id != -1) {
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
            }
          ?>
          </div>
        </div>
          <?php
          if ($selected_election_id != -1):
          $i = 0;
          // display charts for each position in the election, two per row
          foreach ($election_positions as $position)
          {
              if ($i == 0)
                echo '<div class="row" style="margin-top:10px">';
          
              echo '<div class="col-sm-6">';
              echo '<div>' . $position['title'] . '</div>';
              echo '<canvas id="' . $position['position'] . '" height="125" width="125"></canvas>';
              echo '</div>';
              
              if ($i == 0)
                echo '</div">';
              
              $i = ($i + 1) % 2;
          }
          endif;
          ?>
        <div id="votes_graph" style="margin-top:20px">
          <canvas id="votes" height="200" width="400"></canvas>
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
          labels: ["12-1AM", "1-2AM", "2-3AM", "3-4AM", "4-5AM", "5-6AM", "6-7AM", "7-8AM", "8-9AM", "9-10AM", "10-11AM", "11-12PM", "12-1PM", "1-2PM", "2-3PM", "3-4PM", "4-5PM", "5-6PM", "6-7PM", "7-8PM", "8-9PM", "9-10PM", "10-11PM", "11-12PM"],
          datasets: [
              {
                  label: "Election 1",
                  fillColor: "rgba(255,51,51,1)",
                  strokeColor: "rgba(255,51,51,1)",
                  pointColor: "rgba(255,51,51,1)",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(255,51,51,1)",
                  data: [0,0,0,0,0,0,0,10, 33, 41, 57, 80, 90, 105, 3, 62, 76, 50, 43, 20, 21, 15, 10, 5]
              }
          ]
      };      


      // create chart for each position
      <?php if ($selected_election_id != -1): ?>
      <?php foreach ($election_positions as $position): ?>
        var ctx = document.getElementById("<? echo $position['position']; ?>").getContext("2d");
        var data = [];
        i = 0;
        <?php foreach ($position['votes'] as $vote): ?> 
            data.push({
              value: <?php echo $vote['sum(uacc_vote_weight)']; ?>, // number of votes for this candidate
              color: colors[i],
              highlight: "",
              label: "<?php echo $vote['first_name'] . ' ' . $vote['last_name']; ?>"
            });
            i = (i + 1) % colors.length;
        <?php endforeach; ?>
        <?php if ($position['writein_votes'] != NULL):?>
            data.push({
              value: <?php echo $position['writein_votes']; ?>, // number of votes for this candidate
              color: colors[i],
              highlight: "",
              label: "write-in votes"
            });
            i = (i + 1) % colors.length;
        <?php endif; ?>
        position_charts.push(new Chart(ctx).Pie(data,{height:125,width:125}));
      <?php endforeach; ?>
      <?php endif; ?>
      var votes = new Chart(ctx3).Bar(data3,{height:200,width:400});
    </script>
  </body>
</html>
