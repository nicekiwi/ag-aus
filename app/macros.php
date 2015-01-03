<?php

/*
|--------------------------------------------------------------------------
| Delete form macro
|--------------------------------------------------------------------------
|
| This macro creates a form with only a submit button. 
| We'll use it to generate forms that will post to a certain url with the DELETE method,
| following REST principles.
|
*/

Form::macro('delete',function($url, $button_label = 'Delete', $button_icon = 'fa-trash', $form_parameters = []){

    if(empty($form_parameters)){
        $form_parameters = array(
            'method'=>'DELETE',
            'class' =>'delete-form',
            'url'   =>$url
            );
    }else{
        $form_parameters['url'] = $url;
        $form_parameters['method'] = 'DELETE';
    };

    return Form::open($form_parameters)
            . '<i class="fa fa-lg ' . $button_icon . '"></i><button type="submit" class="btn btn-link">' . $button_label . '</button>'
            . Form::close();
});