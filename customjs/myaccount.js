// JavaScript Document
function validateEmail(txtEmail)
{
   var a = document.getElementById(txtEmail).value;
   var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
	if(filter.test(a))
	{
        return true;
    }
	else
	{
        return false;
    }
}

$(document).ajaxStart(function ()
{
	$('body').addClass('wait');
	 
}).ajaxComplete(function () {

	$('body').removeClass('wait');

});


$( "#profile" ).click(function() 
{
       var hid_uid =$('#hid_uid').val();  
	   var user_nm =$('#user_nm').val();
	   var user_id =$('#user_id').val();
	   var password =$('#password').val();
       var csrftoken =$('#csrftoken').val();
       var hid_id =$('#hid_id').val();

	   if(user_nm=="")
	   {
		  alertify.error('Please input a Name');
		  $('#user_nm').focus();
		  return false;
	   }
       if(/^[/!<>]+$/.test(user_nm))
		{
		 alertify.error('Special Character not allowed in  Name');
		  $('#user_nm').focus();
		  return false;	
		}
	      
	   if(password=="")
	   {
		  alertify.error('Please input Password');
		  $('#password').focus();
		  return false;  
	   }
	   	 
	  var request = $.ajax({
	  url: "./back/myaccount_back.php",
	  method: "POST",
	  data: 
	  {
		  user_nm:user_nm, password:password,hid_uid:hid_uid
		 ,csrftoken:csrftoken,hid_id:hid_id
		  ,tag:'ACCOUNT-PROFILE'},
	  	dataType: "html",
	  	success:function( msg) 
	  	{
			//alert(msg);
			$( "#info" ).html( msg );			  
		}
	});
}); 
