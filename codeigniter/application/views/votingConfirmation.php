<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-546b7b6c0898f4a6" async="async"></script>

  <div class="row">
          <div class="col-xs-4">
            <a href="index.php/voter/"><button class="btn btn-default btn-xs" id="back">Back</button></a>
          </div>
          <div class="col-xs-8">
          </div>
        </div>
        <div>
          <p>Thanks for voting!</p>
        </div>
        <div>
          <p>Your confirmation code is:</p>
          <p><? echo $confirmation; ?></p>
        </div>
        <?
        foreach($chosen_candidates[$positions] as $each)
        {
			echo '<div class="row" style="margin-top:20px">';
			echo '<div class="col-sm-6">'.$each['candidate_name'].'</div>';
			echo '<div class="col-sm-6">'.$each['position_name'].'</div>';
			echo '</div>';
		}
        ?>
