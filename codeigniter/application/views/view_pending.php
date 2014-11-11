        <div class="row" style="margin-top:-20px">
          <div class="col-sm-4">
            <a href="index.php/admin"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
        </div>
		<?
		foreach($p_user as $each)
		{
		echo '<div class="row" style="margin-top:10px"><div class="col-sm-3">';
		echo $each['firstname']." ".$each['lastname'];
		echo '</div><div class="col-sm-3">';
		echo $each['major'];
		echo '</div><div class="col-sm-3">';
		echo $each['election'];
		echo '</div><div class="col-sm-3">';
		echo $each['position'];
		echo '</div><div class="col-sm-3">';
		echo '<a href="index.php/admin/approve/$each[\'userID\']">';
		echo '<button class="btn btn-success btn-xs" id="approve" style="font-size:15px !important; margin-top:5px">Approve</button>';
		echo '</a></div><div class="col-sm-3">';
		echo '<a href="index.php/admin/deny/$each[\'userID\']">';
		echo '<button class="btn btn-danger btn-xs" id="deny" style="font-size:15px !important; margin-top:5px">Deny</button></div></div>';
		}
		?>