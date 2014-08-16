@extends('layouts.master')

@section('content')

    <h1>Wall of Shame <small>Banned Users</small></h1>

    <ul class="bans">
        @foreach($bans as $ban)
            <li>{{ substr($ban,8) }}</li>
        @endforeach
    </ul>


@stop

@section('footer')

<script>
$(document).ready(function() 
{
    $( ".bans li" ).each(function( index ) 
    {
        var banLine = $(this);

        $.ajax({
          type: "POST",
          url: '/admin/store-player',
          data: {
            id: banLine.text()
          }
        });

        // $.getJSON( "/admin/store-player/"+banLine.text(), function( json ) 
        // {
        //     //banLine.append( '<img src="'+ json.steam_image +'"><strong>'+ json.steam_nickname +'</strong><br>' + json.steam_64id  );
        // });
    });
});
    

    //     if(typeof(json.steam_url) != "undefined")
    //     {
    //         steam_id_valid = true;
    //         steam_input.css('background-color', 'green');

    //         $( "#steam_id_valid" ).append( '<img src="'+ json.steam_image +'"><strong>'+ json.steam_nickname +'</strong><br>' + json.steam_id  );

    //         $('<input>', {
    //             type: 'hidden',
    //             name: 'steam_image',
    //             value: json.steam_image
    //         }).appendTo(this_form);

    //         $('<input>', {
    //             type: 'hidden',
    //             name: 'steam_nickname',
    //             value: json.steam_nickname
    //         }).appendTo(this_form);

    //         $('<input>', {
    //             type: 'hidden',
    //             name: 'steam_id',
    //             value: json.steam_id
    //         }).appendTo(this_form);

    //         $('<input>', {
    //             type: 'hidden',
    //             name: 'steam_64id',
    //             value: json.steam_64id
    //         }).appendTo(this_form);

    //         $('<input>', {
    //             type: 'hidden',
    //             name: 'steam_url',
    //             value: json.steam_url
    //         }).appendTo(this_form);
    //     }
    //     else
    //     {
    //         steam_input.css('background-color', 'yellow');
    //     }
    // });

    
</script>

@stop