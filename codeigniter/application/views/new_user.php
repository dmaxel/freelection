        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin/view_users"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
        </div>
        <form>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <input type="text" name="first_name" placeholder="First Name">
            <input type="text" name="last_name" placeholder="Last Name">
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <select name="election">
              <option value="candidate1">Election 1</option>
              <option value="candidate2">Election 2</option>
              <option value="candidate3">Election 3</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <input type="text" name="username" placeholder="Username">
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <select name="role">
              <option value="voter">Voter</option>
              <option value="candidate">Candidate</option>
              <option value="monitor">Monitor</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        </form>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <input type="text" name="major" placeholder="Major">
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <input type="text" name="email" placeholder="Email">
          </div>
        </div>
        <div id="candidate_position_container" style="margin-top:20px">
          <select name="role">
            <option value="position1">Position 1</option>
            <option value="position2">Position 2</option>
            <option value="position3">Position 3</option>
            <option value="position4">Position 4</option>
          </select>
        </div>
        <div id="candidate_description_container" style="margin-top:20px">
          <input type="text" name="candidate_description" placeholder="Candidate Description" style="height:70px; width:200px">
        </div>
        <div id="create_button_container" style="margin-left: auto; margin-right: auto; margin-top: 60px">
          <a href="view_users.html"><button class="btn btn-xs btn-default" id="create_user">Create</button></a>
        </div>