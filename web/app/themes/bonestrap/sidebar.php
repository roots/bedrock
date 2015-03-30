						<div id="sidebar1" class="sidebar clearfix" role="complementary">

							<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

								<?php dynamic_sidebar( 'sidebar1' ); ?>

							<?php else : ?>

								<?php // Put something here if you want to annoy the developer of your website. ?>

							<?php endif; ?>

						</div>