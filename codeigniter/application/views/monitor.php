        <form>
        <div class="row">
          <div class="col-sm-6">
            <select name="candidates">
              <option value="candidate1">Election 1</option>
              <option value="candidate2">Election 2</option>
              <option value="candidate3">Election 3</option>
            </select>
            <div style="margin-top:10px">Election Description</div>
          </div>
          <div class="col-sm-6">
            <select name="candidates">
              <option value="candidate1">Candidate 1</option>
              <option value="candidate2">Candidate 2</option>
              <option value="candidate3">Candidate 3</option>
            </select>
            <div style="margin-top:10px">Candidate Description</div>
          </div>
        </div>
        </form>
        <div class="row" style="margin-top:10px">
          <div class="col-sm-6">
            Election Window
          </div>
          <div class="col-sm-6">
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