<script src="js/jquery-1.12.0.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.ui.timepicker.js"></script>	

<link rel="stylesheet" href="css/jquery-ui.css">				
<link rel="Stylesheet" type="text/css" href="css/jquery.ui.timepicker.css" />

<script>
	$(function() {
		$("#datepicker").datepicker();
		$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});

	$(function() {
		$('#timepicker').timepicker({
			hourText: 'Heures',
			minuteText: 'Minutes',
			amPmText: ['AM', 'PM'],
			timeSeparator: ':',
			nowButtonText: 'Maintenant',
			showNowButton: true,
			closeButtonText: 'Fermer',
			showCloseButton: true,
			deselectButtonText: 'Désélectionner',
			showDeselectButton: true
		});
	});
</script>