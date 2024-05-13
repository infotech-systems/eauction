$("#user_name").focusout(function() 
{
    var user_name = $('#user_name').val();
    if(user_name.length>0)
    {
        var request = $.ajax({
            url: "./back/login-back.php",
            method: "POST",
            data: {
                user_name: user_name,
                tag: 'CHANGEUSER'
            },
            dataType: "html",
            success: function(msg) {
                $("#div_bider").html(msg);           
            }
        });
    }
            
}); 