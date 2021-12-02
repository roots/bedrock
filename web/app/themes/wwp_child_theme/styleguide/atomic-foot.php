<!-- Place any footer info you would like shared between the styleguide and the root of your project. Eg. Links to js scripts etc.. -->


<script src="js/min/main.js"></script>
<!-- Place any footer info you would like shared between the styleguide and the root of your project. Eg. Links to js scripts etc.. -->

<script>
    window.wonderwp = window.wonderwp || {};
    window.document.documentElement.className += ' js-enabled';
    window.document.documentElement.classList.remove('no-js');
</script>

<?php
do_action('wwp.styleguide.footer');
?>
