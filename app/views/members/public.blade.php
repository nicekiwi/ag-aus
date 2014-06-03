@extends('layouts.master')

@section('content')


    <h1>Alternaitive Gaming Members <small>Sexy Bunch</small></h1>

    <ul class="members">
        
    </ul>

    <div class="row">
        @foreach($members->member as $member)
        <div class="col-xs-6 col-md-1">
            <a class="thumbnail" href="#">
                <img class="img-responsive" src="{{ $member }}" />
            </a>
        </div>
        @endforeach
    </div>


@stop

@section('footer')

<script>
$(document).ready(function() 
{
    $( ".row div img" ).each(function( index ) 
    {
        var banLine = $(this);

        $.getJSON( "/check-steamid/"+banLine.attr('src'), function( json ) 
        {
            //banLine.append( '<img src="'+ json.steam_image +'"><strong>'+ json.steam_nickname +'</strong><br>' + json.steam_id  );
            banLine.attr('src', json.steam_image);
        });
    });
});

</script>

@stop