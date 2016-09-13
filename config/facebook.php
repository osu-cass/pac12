<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Facebook App ID
    |--------------------------------------------------------------------------
     */

    'app_id' => '23450983475',

    /*
    |--------------------------------------------------------------------------
    | Facebook App Secret
    |--------------------------------------------------------------------------
     */

    'app_secret' => 'asdf',

    /*
    |--------------------------------------------------------------------------
    | File Uploads
    |--------------------------------------------------------------------------
    |
    | The optional fileUpload parameter tells the SDK whether or not file 
    | uploads are enabled on your server. See the setFileUploadSupport 
    | documentation for more details: 
    | https://developers.facebook.com/docs/reference/php/facebook-setFileUploadSupport/
    |
     */

    'fileUpload' => false,

    /*
    |--------------------------------------------------------------------------
    | Allow Signed Request
    |--------------------------------------------------------------------------
    |
    | The optional allowSignedRequest parameter tells the SDK whether or not to 
    | use signed_request data from query parameters or the POST body. For 
    | security purposes, this should be set to false for non-canvas apps.
    |
     */

    'allowSignedRequest' => false,
);
