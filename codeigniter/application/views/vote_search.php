<div class="row">
          <div class="col-xs-4">
            <a href="index.php/admin/"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-xs-8">
          </div>
        </div>
        <div>
        <?
        echo form_open('admin/searchVotes');
        $data = array(
            'name' => 'confirmation_field',
            'class' => 'form-control',
            'placeholder' => 'Confirmation Number',
            'required' => 'required',
            'autofocus' => 'autofocus',
            );
		echo form_input($data);
		$data = array(
			'name' => 'confirmation_submit',
			'value' => 'Search',
			'class' => 'btn btn-xs btn-default'
			); 
        echo form_submit($data, 'Search');
        echo form_close();
        </div>
		if($confirmation_value == NULL)
		{
		   echo '<div style="margin-top: 20px">';
		   echo 'Please enter a confirmation code.';
		   echo '</div>';
		}
		else
		{
		   echo '<div style="margin-top: 20px">';
		   echo $confirmation_value;
		   echo '</div>';
		   echo '<div style="margin-top: 20px">';
		   echo $user_name;
		   echo '</div>';
		   foreach($votes as $vote)
		   {
			   echo '<div class="row" style="margin-top:20px">';
			   echo '<div class="col-sm-6">'.$vote[candidate_name].'</div>';
			   echo '<div class="col-sm-6">'.$vote[position_name].'</div>';
			   echo '</div>';
		   }
		}
        ?>
