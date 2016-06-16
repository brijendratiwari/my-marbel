<script>
	$(document).ready(function() {
		$('.summernote').summernote({
			height: "250px"
		});
		var postForm = function() {
			var content = $('textarea[name="content"]').html($('.summernote').code());
		}
	});
</script>