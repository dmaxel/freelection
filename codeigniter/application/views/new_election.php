        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="view_elections.html"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
        </div>
        <form>
        <div id="election_title_container" style="margin-top:20px">
          <input type="text" name="election_title" placeholder="Election Title">
        </div>
        <div id="election_description_container" style="margin-top:20px">
          <input type="text" name="election_description" placeholder="Election Description" style="height:100px; width:200px">
        </div>
        <div style="margin-top:20px">Registration</div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <input style="width: 80px" type="text" class="datepicker" name="registration_start" placeholder="Start" readonly>
            <select>
              <option value="1">01:00</option>
              <option value="2">02:00</option>
              <option value="2">03:00</option>
              <option value="2">04:00</option>
              <option value="2">05:00</option>
              <option value="2">06:00</option>
              <option value="2">07:00</option>
              <option value="2">08:00</option>
              <option value="2">09:00</option>
              <option value="2">10:00</option>
              <option value="2">11:00</option>
              <option value="2">12:00</option>
            </select>
            <select>
              <option value="am">AM</option>
              <option value="pm">PM</option>
            </select>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <input style="width: 80px" type="text" class="datepicker" name="registration_end" placeholder="End" readonly>
            <select>
              <option value="1">01:00</option>
              <option value="2">02:00</option>
              <option value="2">03:00</option>
              <option value="2">04:00</option>
              <option value="2">05:00</option>
              <option value="2">06:00</option>
              <option value="2">07:00</option>
              <option value="2">08:00</option>
              <option value="2">09:00</option>
              <option value="2">10:00</option>
              <option value="2">11:00</option>
              <option value="2">12:00</option>
            </select>
            <select>
              <option value="am">AM</option>
              <option value="pm">PM</option>
            </select>
          </div>
        </div>
        <div style="margin-top:20px">Election</div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <input style="width: 80px" type="text" class="datepicker" name="election_start" placeholder="Start" readonly>
            <select>
              <option value="1">01:00</option>
              <option value="2">02:00</option>
              <option value="2">03:00</option>
              <option value="2">04:00</option>
              <option value="2">05:00</option>
              <option value="2">06:00</option>
              <option value="2">07:00</option>
              <option value="2">08:00</option>
              <option value="2">09:00</option>
              <option value="2">10:00</option>
              <option value="2">11:00</option>
              <option value="2">12:00</option>
            </select>
            <select>
              <option value="am">AM</option>
              <option value="pm">PM</option>
            </select>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <input style="width: 80px" type="text" class="datepicker" name="election_end" placeholder="End" readonly>
            <select>
              <option value="1">01:00</option>
              <option value="2">02:00</option>
              <option value="2">03:00</option>
              <option value="2">04:00</option>
              <option value="2">05:00</option>
              <option value="2">06:00</option>
              <option value="2">07:00</option>
              <option value="2">08:00</option>
              <option value="2">09:00</option>
              <option value="2">10:00</option>
              <option value="2">11:00</option>
              <option value="2">12:00</option>
            </select>
            <select>
              <option value="am">AM</option>
              <option value="pm">PM</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" style="margin-top:20px">
            <input type="text" name="position1" placeholder="Position 1">
          </div>
          <div class="col-sm-4" style="margin-top:20px">
            Allow Write-In <input type="checkbox">
          </div>
          <div class="col-sm-4" style="margin-top:20px">
            Proposition <input type="checkbox">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" style="margin-top:20px">
            <input type="text" name="position2" placeholder="Position 2">
          </div>
          <div class="col-sm-4" style="margin-top:20px">
            Allow Write-In <input type="checkbox">
          </div>
          <div class="col-sm-4" style="margin-top:20px">
            Proposition <input type="checkbox">
          </div>
        </div>
        </form>
        <div id="create_button_container" style="margin-left: auto; margin-right: auto; margin-top: 40px">
          <a href="view_elections.html"><button class="btn btn-xs btn-default" id="create_election">Create</button></a>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="container">
      </div>
    </div>
    <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $(function() {
      $( ".datepicker" ).datepicker();
  });
  </script>
  </body>
</html>