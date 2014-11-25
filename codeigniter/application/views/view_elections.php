        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
            <a href="index.php/admin/new_election"><button class="btn btn-default btn-xs" id="back">New Election</button></a>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4" style="margin-top:10px">
              <?php
              $form_options = 'style="margin-bottom:10px" onChange="this.form.submit()"';
              echo form_open('view_elections');
              echo form_dropdown('election_dropdown', $election_options, $selected_election_id, $form_options);
              echo form_close();
              ?>
          </div>
          <div class="col-sm-4">
          </div>
        </div>
        <form id="update" method="post" accept-charset="utf-8 action="http://giogottardi.me/freelection/index.php/view_elections">
        <input name="current_election" type="hidden" value="<?php echo $selected_election_id ?>"></input>
        <div id="email_button_container" class="row">
          <div class="col-sm-4">
            ## voters haven't voted yet
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
            <button class="btn btn-default btn-xs" id="send_email">Send Reminders</button>
          </div>
        </div>
        <div id="election_description_container">
          <textarea name="election_description" style="width:300px; height:70px; margin-bottom: 10px"><?php echo $selected_elec_desc; ?></textarea>
        </div>
        <div style="margin-top:20px">Registration Window</div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <label for="registration_start">Start</label>
			<input style="width: 80px" type="text" class="datepicker" name="registration_start" value="<?php echo $reg_start_day_selected ?>" readonly>
            <?php
            echo form_dropdown('reg_hour_start_dropdown', $hour_options, $reg_start_hour_selected);
            ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
          <label for="registration_end">End</label>
            <input style="width: 80px" type="text" class="datepicker" name="registration_end" value="<?php echo $reg_end_day_selected; ?>" readonly>
            <?php
            echo form_dropdown('reg_hour_end_dropdown', $hour_options, $reg_end_hour_selected);
            ?>
          </div>
        </div>
        <div style="margin-top:20px">Voting Window</div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <label for="election_start">Start</label>
            <input style="width: 80px" type="text" class="datepicker" name="election_start" value="<?php echo $vote_start_day_selected; ?>" readonly>
            <?php
            echo form_dropdown('vote_hour_start_dropdown', $hour_options, $vote_start_hour_selected);
            ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <label for="election_end">End</label>
            <input style="width: 80px" type="text" class="datepicker" name="election_end" value="<?php echo $vote_end_day_selected; ?>" readonly>
            <?php
            echo form_dropdown('vote_hour_end_dropdown', $hour_options, $vote_end_hour_selected);
            ?>
          </div>
        </div>
        </form>
        <div class="row" style="margin-top:10px">
          <?php
            // create positon + candidates dropdown rows
            if ($selected_election_id != -1)
                foreach ($election_positions as $position)
                {
                    echo '<div class="row" style="margin-top:10px">';
                    
                    echo '<div class="col-sm-6">';
                    echo $position['title'];
                    echo '</div>';
                    
                    echo '<div class="col-sm-6">';
                    // candidates in this position dropdown
                    echo '<select name="candidates" style="margin-bottom:10px">';
                    foreach ($position['candidates_list'] as $candidate)
                    {
                        echo '<option value="">'. $candidate['first_name'] . ' ' . $candidate['last_name'] . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                    
                    echo '</div>';
                }
          ?>
        </div>
        <div class="row" style="margin-top:20px">
          <div class="col-sm-6" style="margin-top:20px">
            <?php if ($selected_election_id != -1): ?>
            <a href="http://giogottardi.me/freelection/index.php/view_elections/delete_election/<?php echo $selected_election_id ?>">
            <?php endif; ?>
            <button class="btn btn-xs btn-danger" id="delete_button">Delete</button>
            <?php //if ($selected_election_id != -1): ?>
            </a>
            <?php //endif; ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <button class="btn btn-xs btn-default" id="update_button" onClick="document.forms['update'].submit();">Update</button>
          </div>
          
        </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $(function() {
      $( ".datepicker" ).datepicker({ 
		  dateFormat: 'yy-mm-dd',
		});
  });
  </script>
  </body>
</html>