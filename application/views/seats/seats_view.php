<div id="planeseat" >
<input type="button" id="seat1" class="<?= $seat1 ?>"/>
<input type="button" id="seat2" class="<?= $seat2 ?>"/>
<input type="button" id="seat3" class="<?= $seat3 ?>"/>
</div>
<?php
echo form_open('seats_controller/selectseats');


$data = array(
		'id'          => 'seatnumber',
		'name'        => 'seatnumber',
		'value'       => '0',
		'type'       => 'hidden',
);

echo form_input($data);

echo "<br />";

if (isset($seatChose) && $seatChose = true) {
	echo "Please select a seat.";
}

echo "<br />";
echo "<br />";

echo form_submit('submitseat',"Proceed");

echo form_close();
?>