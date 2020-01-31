<!-- components/components/progress_bar.php -->
<?php

$progress = new \WonderWp\Theme\Child\Components\ProgressBar\ProgressBarComponent();

$progress->setValue('50');

echo $progress->getMarkup();
