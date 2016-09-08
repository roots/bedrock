<!--components/components/modal_video.php-->
<a href="https://www.youtube.com/embed/69UJVSE3Srs" class="btn btn-primary modaal-video-story" data-modaal-overlay-opacity="0">Show video</a>


<script>
	$(document).ready(function(){
	  $(".modaal-video-story").modaal({
	  	type: 'video',
	  	custom_class: 'modaal-video-story'
	  });
	});
</script>