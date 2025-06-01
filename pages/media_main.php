<div id="media">
     <div class="clearfix"></div>
     <div id="col1">
          <h2>Archived Services</h2>
          <p style="width:500px;">Download and listen to archived services from our anointed ministry team!</p>
          
          <table width="580px" id="mediatbl" class="tablesorter">
               <thead>
                   <tr>
                        <th class="header">Sermon Title</th>
                        <!--<td class="dl"></td>-->
                        <th class="header speakertitle">Speaker</th>
                        <th class="header datetitle">Date</th>
                   </tr>
               </thead>
               <tbody>
               	   <?php include("./media/filelist.php");  ?>
               </tbody>
          </table>
          
          <?php
			// Formula to calculate the absolute total number of sermon downloads
			
			$result = mysqli_query($db, 'SELECT downloads FROM dl_manager');
			$total = 0;
			
			if(mysqli_num_rows($result)){
				while($row = mysqli_fetch_assoc($result)){
					foreach($row as $download){
						$total = $total + $download;
					}
				}
			}
			echo '<div id="TOTAL" style="color:white; font-size:18px; text-align:right; width:590px">Total-<span style="font-size:26px">' . $total . '</span></div>';
			?>
     </div>
</div>
</div>
<div class="clearfix"></div>
<div id="sub"></div>