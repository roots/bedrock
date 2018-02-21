<?php

if ( !class_exists( 'VineApp' ) ) {

  class VineApp {

    private $base_url = "https://api.vineapp.com";
    private $vine_session = null;
    private $vine_id = null;
    private $is_logged = false;

    public function __construct ( $username , $password ) {

      $url = $this->base_url . "/users/authenticate";

      $args = array (
          'method' => 'POST' ,
          'body' => array ( 'username' => $username , 'password' => $password ) ,
          'user-agent' => 'iphone/110 (iPhone; iOS 7.0.4; Scale/2.00)' ,
      );

      $request = @wp_remote_post( $url , $args );

      if ( $request ) {

        $response = @json_decode( @wp_remote_retrieve_body( $request ) );

        if ( isset( $response->success ) && $response->success ) {
          $this->vine_session = $response->data->key;
          $this->vine_id = $response->data->key;

          $this->is_logged = true;
        }
      }
    }

    public function userinfo () {

      if ( !$this->is_logged )
        return;
      $url = $this->base_url . '/users/me';

      $request = wp_remote_get( $url , array ( 'headers' => array ( 'vine-session-id' => $this->vine_session ) ) );
      if ( !$request )
        return;

      $response = @json_decode( @wp_remote_retrieve_body( $request ) , true );

      if ( !$response ) {
        return;
      }

      if ( !is_array( $response ) || !isset( $response['success'] ) || $response['success'] != 1 )
        return;

     return $response;
    }
  }

}
