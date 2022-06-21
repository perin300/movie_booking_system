<?php
	/*
	*Template Name: Booking
	*/
get_header();


$m_id = $_REQUEST['movie_id'];
$c_id = $_REQUEST['cinema_id'];
$showtime = $_REQUEST['time'];
$showdate = $_REQUEST['date'];
$no_of_seats = $_REQUEST['no_of_seats'];
$cinema_details = get_post_meta($c_id, '_cinema_block_options');

$movie_details = get_post_meta($m_id, '_movie_block_cinema');
//print_r($c_id);
$amy_movie_cinema = $movie_details[0]['amy_movie_cinema'];
//print_r($amy_movie_cinema);
$q=$amy_movie_cinema[1]['select_cinema'];
//print_r($q);

foreach($amy_movie_cinema as $key=>$value):
	
	$q=$amy_movie_cinema[$key]['select_cinema'];
	
	if(!in_array($c_id,$q)):
		$price=$amy_movie_cinema[$key]['cinema_price'];
	endif;
	
endforeach;


//$price = $det[0]['cinema_price'];
$cnm=get_the_title($c_id);

$bookingArray = $wpdb->get_results("SELECT `seat_no` FROM `myuser` WHERE `date`='".$showdate."' AND `time` = '" . $showtime . "' AND `is_paid`= '1'");

foreach($bookingArray as $booking):
	$bookedSeats[] = $booking->seat_no;
endforeach;

?>

<center>
  <font size='6px'><b>
  <?php
echo $cnm;
?> 
  </b>
</center>
</font>
<p class="movie-details"><b><font size='5px'> Movie Name : <?php echo get_the_title($m_id); ?><br>
  Ticket Price per Seat : <?php echo $price; ?></p>
<form class="seat-arrangement" action="<?php echo site_url('registration');?>" method="POST" onsubmit="return validateCheckBox();">
  <ul class="thumbnails">
    <?php
	echo "\t\t\t\tSeat Arrangements \n\n";?>
    <br>
    </font></b>
    <?php 
	if ( count($bookedSeats) == 0 )
	{
		for($i=1; $i<=$no_of_seats; $i++)
		{
		?>
    	<li>
        	<a title="Available" class="seat-arrange">
            	<img src="<?php echo get_template_directory_uri(); 	?>/images/available.png" alt="Available Seat"/>
      			<label class="checkbox seat-checkbox">
        		<input type="checkbox" class="checkbox-middle" name="ch<?php echo $i; ?>"/>Seat<?php echo $i; ?> </label>
      		</a>
        </li>
    <?php	
		}
	}else{
		$seats = implode(",",$bookedSeats);	
		$peats = explode(",",$seats);
		for($i=1; $i<=$no_of_seats; $i++)
		{
			if(in_array($i,$peats)){
				
			?>
            <li> 
            	<a title='Booked' class="seat-arrange"> 
                	<img src="<?php echo get_template_directory_uri();?>/images/occupied.png" alt='Booked Seat'/>
                    <label class='checkbox seat-checkbox'>
                	<input type='checkbox' class="checkbox-middle" name='ch<?php echo $i; ?>' disabled/>Seat<?php echo $i; ?> </label>
              	</a>
            </li>
            <?php
			}else{
				echo "<li>";
				echo "<a title='Available' class='seat-arrange'>";
					echo "<img src='".get_template_directory_uri()."/images/available.png' alt='Available Seat'/>";
					echo "<label class='checkbox seat-checkbox'>";
						echo "<input type='checkbox' class='checkbox-middle' name='ch".$i."'/>Seat".$i;
					echo "</label>";
				echo "</a>";
				echo "</li>";
			}
		}									
	}
?>
  </ul>
  <input type='hidden' name='no_of_seats' value="<?php echo $no_of_seats; ?>"/>
  <input type='hidden' name='price' value="<?php echo $price; ?>"/>
  <input type='hidden' name='booking_date' value="<?php echo $showdate; ?>"/>
  <input type='hidden' name='m_id' value="<?php echo $m_id; ?>"/>
  <input type='hidden' name='c_id' value="<?php echo $c_id; ?>"/>
  <input type='hidden' name='booking_time' value="<?php echo $showtime; ?>"/>
  <br>
  <br>
  <button type="submit" class="btn btn-info"> <i class="icon-ok icon-white"></i>Proceed </button>
  <button type="reset" class="btn btn-info"> <i class="icon-refresh icon-black"></i> Clear </button>
</form>
<?php
get_footer();
?>
