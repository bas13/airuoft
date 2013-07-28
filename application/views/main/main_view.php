<div id="mainpage">
	<h1>Welcome to AirUofT</h1>
	<br/>
	<h4>Please fill out the info. below: </h4>
	<?php echo form_open('flights_controller');?>
		<select name="campus">
			<option value="1" selected>St.George</option>
			<option value="2">UTM</option>
		</select>
		<select id="dates" name="date">
			<option id="0" selected></option>
		</select>
		<br/><br/>
		<input type="submit" name="submit" value="submit">
	<?php echo form_close();?>
</div>	