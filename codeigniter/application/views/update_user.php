        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin/view_users"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
            <a href="index.php/admin/deny/<? echo $user['uacc_id']; ?>"><button class="btn btn-danger btn-xs" id="delete">Delete</button></a>
          </div>
        </div>
        <? echo form_open('admin/update_user'); ?>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <?
			//echo $user['uacc_firname']." ".$user['uacc_lastname'];
	        $data = array(
	             'name' => 'firstname_field',
	             'placeholder' => 'First Name',
	       	  	 'value' => $user['uacc_firstname']
	             );
	        echo form_input($data);
	        $data = array(
	             'name' => 'lastname_field',
	             'placeholder' => 'Last Name',
	       	  	 'value' => $user['uacc_lastname']
	             );
	        echo form_input($data);
			?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <? echo $user['election_title']; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px">
            <? echo $user['uacc_username']; ?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
            <?
			if($user['uacc_group_fk'] == 1)
			{
				echo "Admin";
			}
			else if($user['uacc_group_fk'] == 2)
			{
				echo "Election Monitor";
			}
			else if($user['uacc_group_fk'] == 3)
			{
				echo "Candidate";
			}
			else if($user['uacc_group_fk'] == 4)
			{
				echo "Voter";
			}
			?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" style="margin-top:20px"> 
			<?
			$data = array(
	             'name' => 'major_field',
	             'placeholder' => 'Major',
	       	  	 'value' => $user['uacc_major']
	             );
	        echo form_input($data);
			?>
          </div>
          <div class="col-sm-6" style="margin-top:20px">
			<?
			$data = array(
	             'name' => 'email_field',
	             'placeholder' => 'Email',
	       	  	 'value' => $user['uacc_email']
	             );
	        echo form_input($data);
			?>
          </div>
        </div>
		<?
		if($user['uacc_group_fk'] == 3)
		{
			echo '<div id="candidate_position_container" style="margin-top:20px">';
			foreach($positions as $position)
			{
	        	$options[$position['position']] = $position['title'];
			}
			echo form_dropdown('available_positions', $options, $candidate['position'], 'style="margin-bottom:10px"');
			echo '</div>
        <div id="candidate_description_container" style="margin-top:20px">';
			$data = array(
	             'name' => 'description_field',
	             'placeholder' => 'Candidate Description',
	       	  	 'value' => $candidate['description']
	             );
	        echo form_textarea($data);	
		}
			?>
          <!-- <input type="textarea" name="candidate_description" value="description" style="height:70px; width:200px"> -->
        </div>
        <div id="update_button_container" style="margin-left: auto; margin-right: auto; margin-top: 60px">
	      <?
	      $data = array(
	           'name' => 'updateuser',
	           'value' => 'Update User',
	           'class' => 'btn btn-xs btn-default'
	           ); 
	           echo form_submit($data, 'Update User');?>
		   <? echo form_close(); ?>
        </div>
 