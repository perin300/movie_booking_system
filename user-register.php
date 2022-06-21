<?php
/*
 * Template Name: Registration
 */
get_header();

if(!is_user_logged_in()): ?>
<section class="main-content page-layout-<?php echo $page_layout; ?>">
    <div class="container">
        <div class="row">
        <?php echo do_shortcode('[wppb-login]'); 
		?>
        <p><a class="button button-primary" href="http://localhost/movie_ticket/recover password/" data-wplink-url-error="true" data-wplink-edit="true">Forgot Password? click here to recover it!</a></p><br>
        <p><a class="button button-primary" href="http://localhost/movie_ticket/register/" data-wplink-url-error="true" data-wplink-edit="true">Register</a></p>
		
        </div>
    </div>
</section>
<?php
else:
get_template_part('partials/page-header');
$m_id = $_REQUEST['m_id'];
$c_id = $_REQUEST['c_id'];
$no_of_seats = $_REQUEST['no_of_seats'];
$showtime = $_REQUEST['booking_time'];
$showdate = $_REQUEST['booking_date'];
$price = $_REQUEST['price'];
//print_r($price);
$id = get_current_user_id();
$user_info = get_userdata($id);

$first_name = $user_info->first_name;

$last_name = $user_info->last_name;

?>
<div class="form-horizontal">
        <div class='control-group'>
        <label class='control-label' for='input1'>Your Name</label>
            <div class='controls'>
            <input type='text' name='name' id='input1' class='span3' value="<?php echo $first_name.$last_name;?>" readonly />
           </div>
        </div>
    <div class='control-group'>		
        <label class='control-label' for='input1'>Seat Numbers</label>
        <div class='controls'>
        <?php 
            $count=0;
            for($i=1; $i<$no_of_seats; $i++)
            {
                $chparam = "ch" . strval($i);
                if(isset($_POST[$chparam]))
                {
                    echo "<input type='text' class='span3' name=ch".$i." value=".$i." readonly/><br>";
                    $count++;
                    $seats_array[] = $i;			
                }
                $booked_seats = implode(',',$seats_array);
            }
            $total = $price * $count;
            
            $insert = $wpdb->get_results("INSERT INTO `myuser` (`user_id`, `m_id`, `c_id`, `first_name`,`seat_no`,`price`, `date`, `time`,`last_name`) VALUES('".$id."','".$m_id."','" .$c_id ."','" .$first_name."','".$booked_seats."','".$total."','".$showdate."','".$showtime."','".$last_name."')");
        ?>
    	</div>
    </div>	
	<?php
    $mname = get_the_title($m_id);
        echo "<div class='control-group'>";
        echo "<label class='control-label' for='input1'>Movie Name</label>";
            echo "<div class='controls'>";
            echo "<input type='text' name='movie_name' id='input1' class='span3' value='$mname' readonly />";
            echo "</div>";
        echo "</div>";
    $cname = get_the_title($c_id);
        echo "<div class='control-group'>";
        echo "<label class='control-label' for='input1'>Cinema Name</label>";
            echo "<div class='controls'>";
            echo "<input type='text' name='movie_name' id='input1' class='span3' value='$cname' readonly />";
            echo "</div>";
        echo "</div>";
        echo "<div class='control-group'>";
        echo "<label class='control-label' for='input1'>Date of Show</label>";
            echo "<div class='controls'>";
            echo "<input type='text' name='show_date' id='input1' class='span3' value='$showdate' readonly />";
            echo "</div>";
        echo "</div>";
		session_start();
		$_SESSION['showdate']=$showdate;
       // echo "<input type='hidden' name='showdate' value='$showdate'/>";
        echo "<div class='control-group'>";
        echo "<label class='control-label' for='input1'>Time of Show</label>";
            echo "<div class='controls'>";
            echo "<input type='text' name='show_date' id='input1' class='span3' value='$showtime' readonly />";
            echo "</div>";
        echo "</div>";
    ?>		
    <div class="control-group">
        <label class="control-label" for="input5">Price</label>
        <div class="controls">
            <input type="text" class="span3" name="price" value= <?php
             echo $total;?> readonly />	
        </div>
    </div>
    <?php ?><form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type='hidden' name='save' value="contact" />
        <input type='hidden' name='business' value='dhaval.business@gmail.com'> 
        <input type='hidden' name='item_name' value='Movie_Ticket'>
        <input type='hidden' name='item_number' value='TICKET#'> 
        <input type='hidden' name='amount' value='<?php echo $total/73 ?>'>
        <input type='hidden' name='no_shipping' value='1'>        
        <input type='hidden'name='currency_code' value='USD'> 
        <input type='hidden' name='notify_url'value='http://localhost/movie_ticket/notify'>
        <input type='hidden' name='cancel_return' value='http://localhost/movie_ticket/cancel'>
        <input type='hidden' name='return' value='http://localhost/movie_ticket/return'>
        <input type="hidden" name="cmd" value="_xclick">
        <div class="btn-center">
            <input type="submit" name="pay_now" id="pay_now" Value="Pay Now" class="btn">
            <button type="reset" class="btn"><i class="icon-refresh icon-black"></i> Clear</button>
        </div>
    </form><?php ?>
    
</div>

<?php
endif;
get_footer();
?>