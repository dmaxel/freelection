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
		echo '<div class="row" style="margin-top:10px"><div class="col-sm-2">';
		echo $each['uacc_firstname']." ".$each['uacc_lastname'];
		echo '</div><div class="col-sm-2">';
		echo $each['uacc_major'];
		echo '</div><div class="col-sm-2">';
		echo $each['election_title'];
		echo '</div><div class="col-sm-2">';
		echo $each['title'];
		echo '</div><div class="col-sm-2">';
		if($each['title'] != '')
		{
			echo '<a href="index.php/admin/approve/'.$each['uacc_id'].'/1">';
		}
		else
		{
			echo '<a href="index.php/admin/approve/'.$each['uacc_id'].'/0">';
		}
		echo '<button class="btn btn-success btn-xs" id="approve" style="font-size:15px !important; margin-top:5px">Approve</button>';
		echo '</a></div><div class="col-sm-2">';
		echo '<a href="index.php/admin/deny/'.$each['uacc_id'].'">';
		echo '<button class="btn btn-danger btn-xs" id="deny" style="font-size:15px !important; margin-top:5px">Deny</button></a></div></div>';
		}
		?>