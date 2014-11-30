        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin/view_elections"><button class="btn btn-default btn-xs" id="back">Back</button></a>
            </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
        </div>
        <form id="election_form" method="post" accept-charset="utf-8 action="http://giogottardi.me/freelection/index.php/new_election">
        <div id="election_title_container" style="margin-top:20px">
          <input type="text" name="election_title" placeholder="Election Title">
        </div>
        <div id="election_description_container" style="margin-top:20px">
          <textarea name="election_description" style="width:300px; height:70px; margin-bottom: 10px" placeholder="Election Description"></textarea>
        </div>
        <div style="margin-top:20px">Registration Window</div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <label for="registration_start">Start</label>
            <input style="width: 80px" type="text" class="datepicker" name="registration_start" placeholder="Start" readonly>
            <?php
              echo form_dropdown('reg_hour_start_dropdown', $hour_options);
            ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
          <label for="registration_end">End</label>
            <input style="width: 80px" type="text" class="datepicker" name="registration_end" placeholder="End" readonly>
            <?php
              echo form_dropdown('reg_hour_end_dropdown', $hour_options);
            ?>
          </div>
        </div>
        <div style="margin-top:20px">Voting Window</div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
          <label for="election_start">Start</label>
            <input style="width: 80px" type="text" class="datepicker" name="election_start" placeholder="Start" readonly>
            <?php
              echo form_dropdown('vote_hour_start_dropdown', $hour_options);
            ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <label for="election_end">End</label>
            <input style="width: 80px" type="text" class="datepicker" name="election_end" placeholder="End" readonly>
            <?php
              echo form_dropdown('vote_hour_end_dropdown', $hour_options);
            ?>
          </div>
        </div>
		<?php $i = 0 ?>
        <div class="input_fields_wrap" style="margin-top:10px">
            <button class="add_field_button btn btn-xs btn-default">Add A Position</button>
        </div>
        </form>
        <div id="create_button_container" style="margin-left: auto; margin-right: auto; margin-top: 20px">
          <button class="btn btn-xs btn-default" id="create_election" onClick="document.forms['election_form'].submit();">Create</button>
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
      $( ".datepicker" ).datepicker({ 
		  dateFormat: 'yy-mm-dd',
		});

      $(document).ready(function() {
          var max_fields      = 30; //maximum input boxes allowed
          var wrapper         = $(".input_fields_wrap"); //Fields wrapper
          var add_button      = $(".add_field_button"); //Add button ID
          
          var x = 1; //initlal text box count
		  var i = 0;
          $(add_button).click(function(e){ //on add input button click
              e.preventDefault();
              if(x < max_fields){ //max input box allowed
                  x++; //text box increment
                  $(wrapper).append('<div class="row"><div class="col-sm-4" style="margin-top:20px"><input type="text" placeholder="Position" name="pos[]"></div><div class="col-sm-3" style="margin-top:20px">Allow Write-In <input type="checkbox" name="writein[]" value="'+i+'"></div><div class="col-sm-3" style="margin-top:20px"></div><div class="col-sm-2" style="margin-top:6px"><button class="remove_field"><span class="fa fa-times"></span></button></div></div>'); //add input box
				  i++;
              }
          });
		  
          $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
              e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
          })
      });
  });
  </script>
  </body>
</html>