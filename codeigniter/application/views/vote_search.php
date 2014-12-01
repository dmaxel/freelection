		<div class="row">
          <div class="col-sm-4">
            <a href="index.php/admin/"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-8">
          </div>
        </div>
        <div class="row">
        	<div class="col-sm-9" style="margin-top:10px">
        <?
        echo form_open('admin/searchVotes');
        $data = array(
            'name' => 'confirmation_field',
            'class' => 'form-control',
            'placeholder' => 'Confirmation Number',
            'required' => 'required',
            'autofocus' => 'autofocus',
            'style' => 'width: '
            );
		echo form_input($data);
		echo '</div>';
		echo '<div class="col-sm-3" style="margin-top:10px">';
		$data = array(
			'name' => 'confirmation_submit',
			'value' => 'Search',
			'class' => 'btn btn-xs btn-default'
			); 
        echo form_submit($data, 'Search');
        echo form_close();
        echo '</div></div>';
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
			   echo '<div class="col-sm-6">'.$vote['candidate_name'].'</div>';
			   echo '<div class="col-sm-6">'.$vote['position_name'].'</div>';
			   echo '</div>';
		   }
		}
        ?>
