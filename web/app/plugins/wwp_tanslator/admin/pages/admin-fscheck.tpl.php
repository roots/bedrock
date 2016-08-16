<?php
/**
 * File system check screen - shows permission problems and gives advice on fixing
 * @var LocoPackage $package
 */

$name = $values['name'];
$package = $values['package'];
use \WonderWp\Plugin\Translator\Loco;
use \WonderWp\Plugin\Translator\LocoAdmin;

?>
    
    <h2>
        <?php Loco::h( sprintf( Loco::__('File system permissions for %s'), $name ) )?>
    </h2><?php

    /* @var $package LocoPackage */  
    foreach( $package->get_permission_errors() as $path => $error ):?> 
    <ul class="loco-list">
        <li>
            <code><?php Loco::h( LocoAdmin::trim_path($path) )?></code>
        </li><?php
        if( $error ):?>
        <li class="loco-warning">
            <span><?php Loco::h($error)?></span>
        </li><?php
        else:?> 
        <li class="loco-ok">
            <span>OK</span>
        </li><?php
        endif?> 
    </ul><?php 
    endforeach;


    if( $warnings = $package->get_author_warnings() ):?> 
    <h2>
        <?php Loco::h( sprintf( Loco::__('Other potential issues with %s'), $name ) ) ?> 
    </h2>
    
    <ul class="loco-list"><?php
        foreach( $warnings as $error ):?> 
        <li class="loco-warning">
            <span><?php Loco::h($error)?></span>
        </li><?php 
        endforeach;?> 
    </ul><?php 
    endif?> 
    
    
    <p class="submit">
        <a class="button-primary" href="<?php Loco::h( LocoAdmin::uri(array('tab'=>2)) )?>"><?php Loco::h( Loco::__('Back') )?></a>
    </p>

    
    
            
</div>