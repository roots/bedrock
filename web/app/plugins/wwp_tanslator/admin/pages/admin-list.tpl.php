<?php

use WonderWp\Plugin\Translator\Loco;
use WonderWp\Plugin\Translator\LocoAdmin;

/**
 * List of either plugins or themes that are translatable
 */
?> 

        <table class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">
                        <?php Loco::h( Loco::_x('Package details','Table header') )?> 
                    </th>
                    <th scope="col">
                        <?php Loco::h( Loco::_x('Traductions','Table header') )?>
                    </th>    
                    <th scope="col">
                        <?php Loco::h( Loco::_x('File permissions','Table header') )?> 
                    </th>    
                </tr>
            </thead>
            <tbody><?php 
            /* @var $package LocoPackage */
            foreach( $items as $package ): 
                unset($parent);
                extract( $package->meta() );
                $mtime = $package->get_modified();
                $n = count( $po );
                ?> 
                <tr class="inactive">
                    <td>
                        <ul class="loco-details">
                            <li title="<?php Loco::h($domain)?>">
                                <strong><?php Loco::h($package->get_name())?></strong>
                            </li><?php
                            if( isset($parent) ):?> 
                            <li>
                                <?php Loco::h( Loco::__('Extends: %s'), $parent ) ?> 
                            </li><?php 
                            endif?> 
                            <?php
                            if( $mtime ):?> 
                            <li class="loco-mtime">
                                <small>
                                    <?php Loco::h( Loco::_x('Updated','Modified time') )?> 
                                    <?php Loco::h( LocoAdmin::format_datetime($mtime) )?> 
                                </small>
                            </li><?php
                            endif?> 
                        </ul>
                    </td>
                    <td>
                        <ul><?php // show POT files (should be no more than one)
                        if( $pot ):
                            foreach( $pot as $pot_data ):
                                extract( $pot_data, EXTR_PREFIX_ALL, 'pot' );
                            ?> 
                            <li class="loco-edit-pot">
                                <a href="<?php echo LocoAdmin::edit_uri( $package, $pot_path ).'&tab=2&action=editTrads'; ?>"><?php Loco::h( Loco::_x('Edit') )?></a>
                            </li><?php
                            endforeach;
                         else:?> 
                            <li class="loco-add">
                                <?php echo LocoAdmin::xgettext_link( $package )?> 
                            </li><?php 
                         endif?> 
                        </ul>
                    </td>
                    <td>
                        <ul><?php 
                        try {
                            $package->check_permissions();?> 
                            <li class="loco-ok">
                                <?php echo LocoAdmin::fscheck_link( $package, $domain, Loco::_x('OK','Message label') )?> 
                            </li><?php
                        }
                        catch( Exception $Ex ){?> 
                            <li class="loco-warning">
                                <?php echo LocoAdmin::fscheck_link( $package, $domain, $Ex->getMessage() )?> 
                            </li><?php
                        }?> 
                        </ul>
                    </td>
                </tr><?php 
                endforeach?> 
            </tbody>
        </table>
