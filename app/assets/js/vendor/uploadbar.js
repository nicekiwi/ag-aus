/**
 * @category       PHP5.4 Progress Bar
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012, Pierre-Henry Soria. All Rights Reserved.
 * @license        CC-BY License - http://creativecommons.org/licenses/by/3.0/
 * @version        1.0.0
 */

function UploadBar()
{

    var oMe = this; // Self Object

    this.upload = function()
    {
        this.resetProgressBar();

        // Submit the form
        $('#upload_form').submit();

        //$.get('/maps/upload-progress');

        //alert('sumitted.');

        setTimeout(function() {oMe.progress()}, 1500);
    };

    this.cancel = function()
    {
        $.get('/maps/upload-progress',  {param : 'cancel'}, function(oData)
        {
            console.log('Upload cancelled');
        });

        this.resetProgressBar();
        $('#upload_progress').delay(2000).fadeOut();
    };

    this.progress = function()
    {
        //alert('tigger');

        $.get('/maps/upload-progress',  {param : 'progress'}, function(iPercentage)
        {
            var sPercentage = iPercentage + '%';

            $('#upload_progress').show();
            $('#upload_progress .bar').html(sPercentage);
            $('#upload_progress .bar').width(sPercentage);

            if(iPercentage < 100)
                setTimeout(function() {oMe.progress()}, 500);
        });

        //alert('tigger2');
    };

    this.resetProgressBar = function()
    {
        $('#upload_progress .bar').html('0%');
        $('#upload_progress .bar').width('0%');
    };

}
