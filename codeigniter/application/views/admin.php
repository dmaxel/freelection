<div class="row" style="margin-top:-20px; margin-bottom:10px; font-size:10px">
          <div class="col-sm-4">
            <a href="index.php/admin/view_users"><button class="btn btn-xs btn-default" id="vote_button">View Users</button></a>
          </div>
          <div class="col-sm-4">
            <a href="index.php/admin/view_pending"><button class="btn btn-xs btn-default" id="vote_button">View Pending</button></a>
          </div>
          <div class="col-sm-4">
            <a href="index.php/admin/view_elections"><button class="btn btn-xs btn-default" id="vote_button">View Elections</button></a>
          </div>
        </div>
        <form>
        <div class="row">
          <div class="col-sm-6">
            <?php echo form_open('admin'); ?>
              <select name="elections" style="margin-bottom:10px" onChange="this.form.submit()">
                <option value="-1">Select an Election</option>
              <?php
                foreach ($elections as $election)
                    echo '<option value="'.$election['election_id'].'">'.$election['election_title'].'</option>';
              ?>
              </select>
            </form>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </form>
        <div class="row">
          <div class="col-sm-6">
            <?php
            if ($selected_election != -1)
                echo $election_description;
            else
                echo 'Election Description';
                //echo $selected_election;
            ?>
          </div>
          <div class="col-sm-6">
            Election Window
          </div>
        </div>
        <div class="row" style="margin-top:10px">
          <div class="col-sm-6">
            <div>Position</div>
            <canvas id="position1" height="100" width="100"></canvas>
          </div>
          <div class="col-sm-6">
            <div>Position</div>
            <canvas id="position2" height="100" width="100"></canvas>
          </div>
        </div>
        <div id="votes_graph" style="margin-top:10px">
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
      var ctx1 = document.getElementById("position1").getContext("2d");
      var ctx2 = document.getElementById("position2").getContext("2d");
      var ctx3 = document.getElementById("votes").getContext("2d");
      var data1 = [
          {
              value: 300,
              color:"#F7464A",
              highlight: "#FF5A5E",
              label: "Candidate 1"
          },
          {
              value: 50,
              color: "#46BFBD",
              highlight: "#5AD3D1",
              label: "Candidate 2"
          },
          {
              value: 100,
              color: "#FDB45C",
              highlight: "#FFC870",
              label: "Candidate 3"
          }
      ]
      var data2 = [
          {
              value: 200,
              color:"#F7464A",
              highlight: "#FF5A5E",
              label: "Candidate 1"
          },
          {
              value: 100,
              color: "#46BFBD",
              highlight: "#5AD3D1",
              label: "Candidate 2"
          },
          {
              value: 80,
              color: "#FDB45C",
              highlight: "#FFC870",
              label: "Candidate 3"
          }
      ]
      var data3 = {
          labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
          datasets: [
              {
                  label: "Election 1",
                  fillColor: "rgba(220,220,220,0.2)",
                  strokeColor: "rgba(220,220,220,1)",
                  pointColor: "rgba(220,220,220,1)",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(220,220,220,1)",
                  data: [10, 33, 41, 57, 80, 90, 105]
              },
              {
                  label: "Election 2",
                  fillColor: "rgba(151,187,205,0.2)",
                  strokeColor: "rgba(151,187,205,1)",
                  pointColor: "rgba(151,187,205,1)",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(151,187,205,1)",
                  data: [5, 12, 26, 40, 57, 80, 97]
              }
          ]
      };
      var position1 = new Chart(ctx1).Doughnut(data1,{height:100,width:100});
      var position2 = new Chart(ctx2).Doughnut(data2,{height:100,width:100});
      var votes = new Chart(ctx3).Line(data3,{height:200,width:400});
    </script>
  </body>
</html>