<script>
	$(document).ready(function() {

		toastr.<?php echo h($type); ?>('<?php echo h($message); ?>');
	});
</script>