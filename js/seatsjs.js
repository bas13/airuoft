// The following jquery functions are binded to the seat
// displays and set their accordingly:
// - currently selected seat = green
// - unoccupied seat = white
// - occupied seat = yellow

$('#seat1').bind({
	click: function() {
		var seat1color = $('#seat1').attr('class');
		var seat2color = $('#seat2').attr('class');
		var seat3color = $('#seat3').attr('class');
		
		if (seat1color !== 'yellow') {
			
			$('#seat1').attr('class', 'green');
			$('#seat1').css('background-color', $('#seat1').attr('class'));
			$('#seatnumber').val('1');
			
			if (seat2color == 'green') {
				$("#seat2").attr('class', 'white');
				$('#seat2').css('background-color', $('#seat2').attr('class'));
			}
			else if (seat3color == 'green') {
				$("#seat3").attr('class', 'white');
				$('#seat3').css('background-color', $('#seat3').attr('class'));
			}
		}
	}
});

$('#seat2').bind({
	click: function() {
		var seat1color = $('#seat1').attr('class');
		var seat2color = $('#seat2').attr('class');
		var seat3color = $('#seat3').attr('class');
		
		if (seat2color !== 'yellow') {
			
			$('#seat2').attr('class', 'green');
			$('#seat2').css('background-color', $('#seat2').attr('class'));
			$('#seatnumber').val('2');

			if (seat1color == 'green') {
				$("#seat1").attr('class', 'white');
				$('#seat1').css('background-color', $('#seat1').attr('class'));
			}
			else if (seat3color == 'green') {
				$("#seat3").attr('class', 'white');
				$('#seat3').css('background-color', $('#seat3').attr('class'));
			}
		}
	}
});

$('#seat3').bind({
	click: function() {
		var seat1color = $('#seat1').attr('class');
		var seat2color = $('#seat2').attr('class');
		var seat3color = $('#seat3').attr('class');
		
		if (seat3color !== 'yellow') {
			
			$('#seat3').attr('class', 'green');
			$('#seat3').css('background-color', $('#seat3').attr('class'));
			$('#seatnumber').val('3');

			if (seat1color == 'green') {
				$("#seat1").attr('class', 'white');
				$('#seat1').css('background-color', $('#seat1').attr('class'));
			}
			else if (seat2color == 'green') {
				$("#seat2").attr('class', 'white');
				$('#seat2').css('background-color', $('#seat2').attr('class'));
			}
		}
	}
});
