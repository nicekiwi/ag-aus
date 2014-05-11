@extends('layouts.master')

@section('content')

<div class="col-sm-12 col-md-3" style="float:right;">
    <ul>
        @foreach($bans as $ban)
            {{ $ban }} <br>
        @endforeach
    </ul>
</div>

@stop

@section('footer')

<script>

$( "#steam_id" ).blur(function() 
{
    var this_form = $('#donation_form');

    if(steam_id_valid) return false;
    var steam_input = $( this );

    if(steam_input.val() == '') return false;

    $.getJSON( "/check-steamid/"+$(this).val(), function( json ) {

        if(typeof(json.steam_url) != "undefined")
        {
            steam_id_valid = true;
            steam_input.css('background-color', 'green');

            $( "#steam_id_valid" ).append( '<img src="'+ json.steam_image +'"><strong>'+ json.steam_nickname +'</strong><br>' + json.steam_id  );

            $('<input>', {
                type: 'hidden',
                name: 'steam_image',
                value: json.steam_image
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_nickname',
                value: json.steam_nickname
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_id',
                value: json.steam_id
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_64id',
                value: json.steam_64id
            }).appendTo(this_form);

            $('<input>', {
                type: 'hidden',
                name: 'steam_url',
                value: json.steam_url
            }).appendTo(this_form);
        }
        else
        {
            steam_input.css('background-color', 'yellow');
        }
    });
});
    
</script>

@stop