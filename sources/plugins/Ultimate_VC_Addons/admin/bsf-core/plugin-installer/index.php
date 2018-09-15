<?php
    $action = (isset($_GET['action']) && $_GET['action']==='install') ? $_GET['action'] : '';
    if($action === 'install')
    {
        $request_product_id = (isset($_GET['id'])) ? $_GET['id'] : '';
        if($request_product_id !== '')
        {
            ?>
                <div class="clear"></div>
                <div class="wrap">
                <h2><?php echo __('Installing Extension','bsf') ?></h2>
                <?php
                    $installed = install_bsf_product($request_product_id);
                ?>
                <?php if(isset($installed['status']) && $installed['status'] === true) : ?>
                    <?php $current_name = strtolower(bsf_get_current_name($installed['init'], $installed['type'])); ?>
                    <?php $current_name = preg_replace("![^a-z0-9]+!i", "-", $current_name); ?>
                    <a href="<?php echo (is_multisite()) ? network_admin_url('plugins.php#'.$current_name) : admin_url('plugins.php#'.$current_name) ?>"><?php echo __('Manage plugin here','bsf') ?></a>
                <?php endif; ?>
                </div>
            <?php
            require_once(ABSPATH . 'wp-admin/admin-footer.php');
            exit;
        }
    }
    global $bsf_theme_template;
    if(is_multisite())
        $template = $bsf_theme_template;
    else
        $template = get_template();

    $current_page = '';

    if ( isset( $_GET['page'] ) ) {
        $current_page   = $_GET['page'];

        $arr = explode('bsf-extensions-', $current_page);
        $product_id = $arr[1];
    }

    $extensions_installer_heading = apply_filters( "bsf_extinstaller_heading_{$product_id}", 'iMedica Extensions' );

    $extensions_installer_subheading = apply_filters( "bsf_extinstaller_subheading_{$product_id}", 'iMedica is already very flexible & feature rich theme. It further aims to be all-in-one solution for your WordPress needs. Install any necessary extensions you like from below and take it on the steroids.' );

    $status = check_bsf_product_status( $product_id );

    if ( is_multisite() ) {
        $redirect =  network_admin_url( 'admin.php?page=' . $current_page );
    } else {
        $redirect =  admin_url( 'admin.php?page=' . $current_page );    
    }
    
    $reset_bundled_url =  $redirect . '&remove-bundled-products';


    if( isset( $_GET['remove-bundled-products'] ) )  {
        delete_option('brainstrom_bundled_products');
        global $ultimate_referer;
        $ultimate_referer = 'on-refresh-bundled-products-extensions-page';
        get_bundled_plugins();
        set_site_transient( 'bsf_get_bundled_products', true, 7*24*60*60 );
        update_option('bsf_local_transient_bundled', current_time( 'timestamp' ));

        echo '<script type="text/javascript">window.location = "'.$redirect.'";</script>';
    }


?>
<div class="clear"></div>
<div class="wrap about-wrap bsf-sp-screen bend <?php echo 'extension-installer-'. $product_id ?>">

    <div class="bend-heading-section extension-about-header">

        <h1><?php _e( $extensions_installer_heading, 'bsf' ); ?></h1>
        <h3><?php _e( $extensions_installer_subheading, 'bsf' ); ?></h3>

        <div class="bend-head-logo">
            <?php /*<img src="<?php echo get_template_directory_uri().'/css/img/brainstorm-logo.png' ?>" /> */ ?>
            <div class="bend-product-ver"><?php _e( 'Extensions ', 'bsf' );?></div>
        </div>
    </div>  <!--heading section-->

    <div class="bend-content-wrap">
    <hr class="bsf-extensions-lists-separator">
    <h3 class="bf-ext-sub-title"><?php echo __('Available Extensions','bsf'); ?></h3>

    <?php

        // update_option( 'brainstrom_bundled_products', '' );
       $brainstrom_bundled_products = ( get_option('brainstrom_bundled_products') ) ? (array)get_option('brainstrom_bundled_products') : array();

        if ( isset( $brainstrom_bundled_products[$product_id] ) ) {
            $brainstrom_bundled_products = $brainstrom_bundled_products[$product_id];
        }

        usort( $brainstrom_bundled_products, "bsf_sort" );

        if( !empty( $brainstrom_bundled_products ) ) :
            $global_plugin_installed = $global_plugin_activated = 0;
            $total_bundled_plugins = count($brainstrom_bundled_products);
            foreach( $brainstrom_bundled_products as $key => $plugin ) {
                if(!isset($plugin->id) || $plugin->id == '')
                    continue;
                if( isset( $request_product_id ) && $request_product_id !== $plugin->id ){
                    continue;
                }
                $plugin_abs_path = WP_PLUGIN_DIR.'/'.$plugin->init;
                if(is_file($plugin_abs_path)) {
                    $global_plugin_installed++;

                    if(is_plugin_active($plugin->init)) {
                        $global_plugin_activated++;
                    }
                }
            }
    ?>

        <ul class="bsf-extensions-list">
            <?php
                //if($global_plugin_activated != 0) :
                    foreach($brainstrom_bundled_products as $key => $plugin) :

                        if(!isset($plugin->id) || $plugin->id == '')
                            continue;

                        if(isset($request_product_id) && $request_product_id !== $plugin->id)
                            continue;

                        $is_plugin_installed = false;
                        $is_plugin_activated = false;

                        $plugin_abs_path = WP_PLUGIN_DIR.'/'.$plugin->init;
                        if(is_file($plugin_abs_path))
                        {
                            $is_plugin_installed = true;

                            if(is_plugin_active($plugin->init))
                                $is_plugin_activated = true;
                        }

                        if($is_plugin_installed)
                            continue;

                        if($is_plugin_installed && $is_plugin_activated)
                            $class = 'active-plugin';
                        elseif($is_plugin_installed && !$is_plugin_activated)
                            $class = 'inactive-plugin';
                        else
                            $class = 'plugin-not-installed';
                    ?>
                        <li id="ext-<?php echo $key ?>" class="bsf-extension <?php echo $class ?>">
                            <?php if(!$is_plugin_installed) : ?>
                                <div class="bsf-extension-start-install">
                                    <div class="bsf-extension-start-install-content">
                                        <h2><?php echo __('Downloading','bsf') ?><div class="bsf-css-loader"></div></h2>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="top-section">
                                <?php if(!empty($plugin->product_image)) : ?>
                                    <div class="bsf-extension-product-image">
                                        <div class="bsf-extension-product-image-stick">
                                            <img src="<?php echo $plugin->product_image; ?>" class="img" alt="image"/>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="bsf-extension-info">
                                    <?php $name = (isset($plugin->short_name)) ? $plugin->short_name : $plugin->name ?>
                                    <h4 class="title"><?php echo $name; ?></h4>
                                    <?php /*
                                    <span class="status">
                                        <?php if($is_plugin_installed) : ?>
                                            <?php //$is_plugin_installed = true; ?>
                                            <?php if($is_plugin_activated) : ?>
                                                <?php echo __('Active','bsf'); ?>
                                            <?php else : ?>
                                                <?php echo __('Not Active','bsf'); ?>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php echo __('Not Installed','bsf'); ?>
                                        <?php endif; ?>
                                    </span>
                                    */
                                    ?>
                                    <p class="desc"><?php echo $plugin->description; ?><span class="author"><cite>By <?php echo $plugin->author ?></cite></span></p>
                                </div>
                            </div>
                            <div class="bottom-section">
                                <?php
                                    $button_class = '';
                                    if(!$is_plugin_installed)
                                    {
                                        if((!$plugin->licence_require || $plugin->licence_require === 'false') || $status === 'registered') {
                                            if(is_multisite())
                                                $link = network_admin_url('admin.php?page=bsf-extensions-'.$product_id.'&action=install&id='.$plugin->id.'&bundled=true');
                                            else
                                                $link = admin_url('admin.php?page=bsf-extensions-'.$product_id.'&action=install&id='.$plugin->id.'&bundled=true');
                                            $button = __('Install','bsf');
                                            $button_class = 'bsf-install-button';
                                        }
                                        elseif(($plugin->licence_require || $plugin->licence_require === 'true') && $status !== 'registered') {
                                            if(is_multisite())
                                                $link = network_admin_url('index.php?page=bsf-registration&id='.$product_id);
                                            else {
                                                if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
                                                    $link = admin_url('options-general.php?page=bsf-registration&id='.$product_id);
                                                }
                                                else {
                                                    $link = admin_url('index.php?page=bsf-registration&id='.$product_id);
                                                }
                                            }
                                            $button = __('Validate Purchase','bsf');
                                            $button_class = 'bsf-validate-licence-button';
                                        }
                                    }
                                    else
                                    {
                                        $current_name = strtolower(bsf_get_current_name($plugin->init, $plugin->type));
                                        $current_name = preg_replace("![^a-z0-9]+!i", "-", $current_name);
                                        if(is_multisite())
                                            $link = network_admin_url('plugins.php#'.$current_name);
                                        else
                                            $link = admin_url('plugins.php#'.$current_name);
                                        $button = __('Installed','bsf');
                                    }

                                ?>
                                <a class="button button-primary extension-button <?php echo $button_class; ?>" href="<?php echo $link ?>" data-ext="<?php echo $key ?>" data-pid="<?php echo $plugin->id ?>" data-bundled="true" data-action="install"><?php echo $button ?></a>
                            </div>
                        </li>
                <?php endforeach; ?>
                <?php
                    if($total_bundled_plugins === $global_plugin_installed) : ?>
                    <div class="bsf-extensions-no-active">
                        <div class="bsf-extensions-title-icon"><span class="dashicons dashicons-smiley"></span></div>
                        <p class="bsf-text-light"><em><?php echo __('All available extensions have been installed!', 'bsf'); ?></em></p>
                    </div>
                <?php endif; ?>
        </ul>


        <!-- Stat - Just Design Purpose -->
        <hr class="bsf-extensions-lists-separator">
        <h3 class="bf-ext-sub-title"><?php echo __('Installed Extensions', 'bsf'); ?></h3>
        <ul class="bsf-extensions-list">
            <?php
            if($global_plugin_installed != 0) :
                foreach($brainstrom_bundled_products as $key => $plugin) :
                        if(!isset($plugin->id) || $plugin->id == '')
                            continue;

                        if(isset($request_product_id) && $request_product_id !== $plugin->id)
                            continue;

                        $is_plugin_installed = false;
                        $is_plugin_activated = false;

                        $plugin_abs_path = WP_PLUGIN_DIR.'/'.$plugin->init;
                        if(is_file($plugin_abs_path))
                        {
                            $is_plugin_installed = true;

                            if(is_plugin_active($plugin->init))
                                $is_plugin_activated = true;
                        }

                        if(!$is_plugin_installed)
                            continue;

                        if($is_plugin_installed && $is_plugin_activated)
                            $class = 'active-plugin';
                        elseif($is_plugin_installed && !$is_plugin_activated)
                            $class = 'inactive-plugin';
                        else
                            $class = 'plugin-not-installed';
                    ?>
                        <li id="ext-<?php echo $key ?>" class="bsf-extension <?php echo $class ?>">
                            <?php if(!$is_plugin_installed) : ?>
                                <div class="bsf-extension-start-install">
                                    <div class="bsf-extension-start-install-content">
                                        <h2><?php echo __('Downloading','bsf') ?><div class="bsf-css-loader"></div></h2>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="top-section">
                                <?php if(!empty($plugin->product_image)) : ?>
                                    <div class="bsf-extension-product-image">
                                        <div class="bsf-extension-product-image-stick">
                                            <img src="<?php echo $plugin->product_image; ?>" class="img" alt="image"/>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="bsf-extension-info">
                                    <?php $name = (isset($plugin->short_name)) ? $plugin->short_name : $plugin->name ?>
                                    <h4 class="title"><?php echo $name; ?></h4>
                                    <?php /*
                                    <span class="status">
                                        <?php if($is_plugin_installed) : ?>
                                            <?php //$is_plugin_installed = true; ?>
                                            <?php if($is_plugin_activated) : ?>
                                                <?php echo __('Active','bsf'); ?>
                                            <?php else : ?>
                                                <?php echo __('Not Active','bsf'); ?>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php echo __('Not Installed','bsf'); ?>
                                        <?php endif; ?>
                                    </span>
                                    */
                                    ?>
                                    <p class="desc"><?php echo $plugin->description; ?><span class="author"><cite>By <?php echo $plugin->author ?></cite></span></p>
                                </div>
                            </div>
                            <div class="bottom-section">
                                <?php
                                    $button_class = '';
                                    if(!$is_plugin_installed)
                                    {
                                        if((!$plugin->licence_require || $plugin->licence_require === 'false') || $status === 'registered') {
                                            if(is_multisite())
                                                $link = network_admin_url('admin.php?page=bsf-extensions-'.$product_id.'&action=install&id='.$plugin->id.'&bundled=true');
                                            else
                                                $link = admin_url('admin.php?page=bsf-extensions-'.$product_id.'&action=install&id='.$plugin->id.'&bundled=true');
                                            $button = __('Install','bsf');
                                            $button_class = 'bsf-install-button';
                                        }
                                        elseif(($plugin->licence_require || $plugin->licence_require === 'true') && $status !== 'registered') {
                                            if(is_multisite())
                                                $link = network_admin_url('index.php?page=bsf-registration&id='.$product_id);
                                            else {
                                                if(defined('BSF_REG_MENU_TO_SETTINGS') && (BSF_REG_MENU_TO_SETTINGS == true || BSF_REG_MENU_TO_SETTINGS == 'true')) {
                                                    $link = admin_url('options-general.php?page=bsf-registration&id='.$product_id);
                                                }
                                                else {
                                                    $link = admin_url('index.php?page=bsf-registration&id='.$product_id);
                                                }
                                            }
                                            $button = __('Validate Purchase','bsf');
                                            $button_class = 'bsf-validate-licence-button';
                                        }
                                    }
                                    else
                                    {
                                        $current_name = strtolower(bsf_get_current_name($plugin->init, $plugin->type));
                                        $current_name = preg_replace("![^a-z0-9]+!i", "-", $current_name);
                                        if(is_multisite())
                                            $link = network_admin_url('plugins.php#'.$current_name);
                                        else
                                            $link = admin_url('plugins.php#'.$current_name);
                                        $button = __('Installed','bsf');
                                    }

                                ?>
                                <a class="button button-primary extension-button <?php echo $button_class; ?>" href="<?php echo $link ?>" data-ext="<?php echo $key ?>"><?php echo $button ?></a>
                            </div>
                        </li>
                    <?php
                    endforeach;
                else: ?>
                    <div class="bsf-extensions-no-active">
                        <div class="bsf-extensions-title-icon"><span class="dashicons dashicons-download"></span></div>
                        <p class="bsf-text-light"><em><?php echo __('No extensions installed yet!', 'bsf'); ?></em></p>
                    </div>
                <?php endif; ?>
        </ul>

        <!-- End - Just Design Purpose -->
    <?php else : ?>
        <div class="bsf-extensions-no-active">
            <div class="bsf-extensions-title-icon"><span class="dashicons dashicons-download"></span></div>
            <p class="bsf-text-light"><em><?php echo __('No extensions available yet!', 'bsf'); ?></em></p>

            <div class="bsf-cp-rem-bundle" style="margin-top: 30px;">
                <a class="button-primary" href="<?php echo $reset_bundled_url; ?>">Refresh Bundled Products</a>
            </div>
        </div>

    <?php endif; ?>


</div>

</div>

<?php if(isset($_GET['noajax'])) : ?>
    <script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('.bsf-install-button').on('click',function(e){
                if((typeof $(this).attr('disabled') !== 'undefined' && $(this).attr('disabled') === 'disabled'))
                    return false;
                $('.bsf-install-button').attr('disabled',true);
                var ext = $(this).attr('data-ext');
                var $ext = $('#ext-'+ext);
                $ext.find('.bsf-extension-start-install').addClass('show-install');
            });
        });
    })(jQuery);
    </script>
<?php else : ?>
    <script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('.bsf-install-button').on('click',function(e){
                e.preventDefault();

                var is_plugin_installed = is_plugin_activated = false;

                if((typeof $(this).attr('disabled') !== 'undefined' && $(this).attr('disabled') === 'disabled'))
                    return false;
                $(this).attr('disabled',true);
                var ext = $(this).attr('data-ext');
                var product_id = $(this).attr('data-pid');
                var action = 'bsf_'+$(this).attr('data-action');
                var bundled = $(this).attr('data-bundled');
                var $ext = $('#ext-'+ext);
                $ext.find('.bsf-extension-start-install').addClass('show-install');
                var data = {
                    'action': action,
                    'product_id': product_id,
                    'bundled' : bundled
                };

                var $link = $(this).attr('href');

                // We can also pass the url value separately from ajaxurl for front end AJAX implementations
                jQuery.post(ajaxurl, data, function(response) {
                    console.log(response);
                    var blank_response = true;
                    var plugin_status = response.split('|');
                    var is_ftp = false;
                    $.each(plugin_status, function(i,res){
                        if(res === 'bsf-plugin-installed') {
                            is_plugin_installed = true;
                            blank_response = false;
                        }
                        if(res === 'bsf-plugin-activated') {
                            is_plugin_activated = true;
                            blank_response = false;
                        }
                        if(/Connection Type/i.test(response)) {
                            is_ftp = true;
                        }
                    });
                    if(is_plugin_installed) {
                        $ext.addClass('bsf-plugin-installed');
                        $ext.find('.bsf-install-button').addClass('bsf-plugin-installed-button').html('Installed <i class="dashicons dashicons-yes"></i>');
                        $ext.find('.bsf-extension-start-install').removeClass('show-install');
                    }
                    if(is_plugin_activated) {
                        $ext.addClass('bsf-plugin-activated');
                    }
                    if(blank_response) {
                        //$ext.find('.bsf-extension-start-install').find('.bsf-extension-start-install-content').html(response);
                        if(is_ftp == true) {
                            $ext.find('.bsf-extension-start-install').find('.bsf-extension-start-install-content').html('<h3>FTP protected, <br/>redirecting to traditional installer.</h3>');
                            $('.bsf-install-button').attr('disabled',true);
                            setTimeout(function(){
                                window.location = $link;
                            },2000);
                        } else {
                            $ext.find('.bsf-extension-start-install').find('.bsf-extension-start-install-content').html('<h3>Something went wrong! Contact plugin author.</h3>');
                        }
                    }
                });
            });
        });
    })(jQuery);
    </script>
<?php endif; ?>
