        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin/view_users"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
        </div>
        <? echo form_open('admin/insert_user'); ?>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <?
	        $data = array(
	             'name' => 'firstname_field',
	             'placeholder' => 'First Name',
				 'value' => $saved_firstname
	             );
	        echo form_input($data);
	        $data = array(
	             'name' => 'lastname_field',
	             'placeholder' => 'Last Name',
				 'value' => $saved_lastname
	             );
	        echo form_input($data);
			?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
			<?
			foreach($elections as $election)
			{
		       	$options[$election['election_id']] = $election['election_title'];
			}
			echo form_dropdown('elections', $options, $saved_election, 'onChange="this.form.submit()" style="margin-bottom:10px"');
			?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <?
            $options[1] = "Admin";
			$options[2] = "Election Monitor";
			$options[3] = "Candidate";
			$options[4] = "Voter";
			echo form_dropdown('user_type', $options, $saved_type, 'onChange="this.form.submit()" style="margin-bottom:10px"');
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <?
	        $data = array(
	             'name' => 'major_field',
	             'placeholder' => 'Major',
				 'value' => $saved_major
	             );
	        echo form_input($data);
            ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <?
	        $data = array(
	             'name' => 'email_field',
	             'placeholder' => 'Email',
				 'value' => $saved_email
	             );
	        echo form_input($data);
            ?>
          </div>
        </div>
        <div id="candidate_position_container" style="margin-top:20px">
          <?
          if($saved_type == 3)
		  {
			  $options = array();
			  foreach($positions as $position)
			  {
				  $options[$position['position']] = $position['title'];
			  }
			  echo form_dropdown('positions', $options, 0, 'style="margin-bottom:10px"');
		  }
          ?>
        </div>
        <div id="candidate_description_container" style="margin-top:20px">
        </div>
        <div id="create_button_container" style="margin-left: auto; margin-right: auto; margin-top: 60px">
		<?
     	 $data = array(
     		  	'name' => 'createuser',
     			'value' => 'Create',
     		   	'class' => 'btn btn-xs btn-default'
     			); 
         echo form_submit($data, 'Create');
	 	 echo form_close();		
		?>
        </div>