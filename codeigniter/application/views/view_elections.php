        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="admin.html"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
            <a href="new_election.html"><button class="btn btn-default btn-xs" id="back">New Election</button></a>
          </div>
        </div>
        <div class="row">
          <form>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4" style="margin-top:10px">
            <select name="election" style="margin-bottom:10px">
              <option value="candidate1">Election 1</option>
              <option value="candidate2">Election 2</option>
              <option value="candidate3">Election 3</option>
            </select>
          </div>
          <div class="col-sm-4">
          </div>
        </div>
        <div id="election_description_container">
          <input type="text" name="election_description" placeholder="Election Description" style="width:300px; height:70px; margin-bottom: 10px">
        </div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:10px">
            <input type="text" name="election_window" placeholder="Election Window">
          </div>
          <div class="col-sm-6" style="margin-top:10px">
            <input type="text" name="registration_window" placeholder="Registration Window">
          </div>
        </div>
        <div class="row" style="margin-top:10px">
          <div class="col-sm-6">
            Position
          </div>
          <div class="col-sm-6">
            <select name="candidates" style="margin-bottom:10px">
              <option value="candidate1">Candidate 1</option>
              <option value="candidate2">Candidate 2</option>
              <option value="candidate3">Candidate 3</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            Position
          </div>
          <div class="col-sm-6">
            <select name="candidates2" style="margin-bottom:10px">
              <option value="candidate1">Candidate 1</option>
              <option value="candidate2">Candidate 2</option>
              <option value="candidate3">Candidate 3</option>
            </select>
          </div>
        </div>
        </form>
        <div class="row" style="margin-top:20px">
          <div class="col-sm-6" style="margin-top:20px">
            <a href="admin.html"><button class="btn btn-xs btn-danger" id="delete_button">Delete</button></a>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <a href="admin.html"><button class="btn btn-xs btn-default" id="update_button">Update</button></a>
          </div>
        </div>