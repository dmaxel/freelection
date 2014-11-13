        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
            <a href="index.php/admin/new_user"><button class="btn btn-default btn-xs" id="back">New User</button></a>
          </div>
        </div>
		<?
			foreach($users as $user)
			{
				echo '<div class="row" style="margin-top:10px"><div class="col-sm-3">';
				echo $user['uacc_firstname']." ".$user['uacc_lastname'];
				echo '</div><div class="col-sm-3">';
				echo $user['election_title'];
				echo '</div><div class="col-sm-3">';
				if($user['uacc_group_fk'] == 1)
				{
					echo 'Admin';
				}
				else if($user['uacc_group_fk'] == 2)
				{
					echo 'Election Monitor';
				}
				else if($user['uacc_group_fk'] == 3)
				{
					echo 'Candidate';
				}
				else if($user['uacc_group_fk'] == 4)
				{
					echo 'Voter';
				}
				echo '</div><div class="col-sm-3">';
				echo '<a href="index.php/admin/update_user/'.$user['uacc_id'].'"><button class="btn btn-default btn-xs" style="font-size:12px !important">Edit</button></a></div></div>';
			}
		?>