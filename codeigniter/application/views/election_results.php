<h2>Election Results</h2>
		<?
		foreach($positions as $position)
		{
			echo '<div class="row" style="margin-top:20px"><div class="col-sm-6">';
			echo $position['title'];
			echo '</div><div class="col-sm-6">';
			echo $list[$position['position']]['first_name']." ".$list[$position['position']]['last_name'];
			echo '</div></div>';
		}
		?>