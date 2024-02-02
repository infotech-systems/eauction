function ValidateSize(file) {
    //  console.log(file.files[0]);
      var FileName=file.files[0].name;
      var FileSize = file.files[0].size // 500; // in MiB
      var maxsize=(1024*1024)*10;
      var parts = FileName.split('.');
      var extn=parts[parts.length-1].toLowerCase();

    //  console.log(extn);

      if(FileName.includes(","))
      {
          alert('File Name "," not allowed');
          $(file).val(''); //for clearing with Jquery
      }
     /* if (FileSize > maxsize) {
          alert('File size exceeds 1 MB');
          $(file).val(''); //for clearing with Jquery
      } 
      */
      var allowedExtensions = ["xlsx"];
      if (FileName.length > 0) {
          if (allowedExtensions.indexOf(extn) === -1) {
              alert('Invalid file Format. Only ' + allowedExtensions.join(', ') + ' are allowed.');
              $(file).val('');
              return false;
          }
      }
}

$("#place").change(function() 
{
    var place =$('#place').val();  
	var request = $.ajax({
	  url: "./back/excel-upload-back.php",
	  method: "POST",
	  data: 
	  {
        place:place,tag:'CHANGE-PLACE'},
	  	dataType: "html",
	  	success:function( msg) 
	  	{
            var str=msg.trim();
            var st_arr=str.split("~");
			$("#srl_no").val(st_arr[0]);			  
			$("#hid_place").val(st_arr[1]);	
			$("#offer_srl_no").val(st_arr[2]);	
            	  
		}
	});
});


$( "#auct_type" ).change(function() 
{
       var auct_type =$('#auct_type').val();  
	  var request = $.ajax({
	  url: "./back/excel-upload-back.php",
	  method: "POST",
	  data: 
	  {
        auct_type:auct_type,tag:'AUCT-TYPE'},
	  	dataType: "html",
	  	success:function( msg) 
	  	{
			$( "#auct_type_div" ).html( msg );			  
		}
	});
}); 

$("#update").click(function() 
{
    
    var place = $('#place').val();
    var offer_period = $('#offer_period').val();
    var location = $('#location').val();
    var payment_type = $('#payment_type').val();
    var contract_type = $('#contract_type').val();
    var knockdown_period = $('#knockdown_period').val();
    var offer_excel = $('#offer_excel').val();

    if (place == "") {
        alert('Please select Offer Place');
        $('#place').focus();
        return false;
    }  
    if (offer_period == "") {
        alert('Please input Offer Period');
        $('#offer_period').focus();
        return false;
    }  
    if (location == "") {
        alert('Please input Location');
        $('#location').focus();
        return false;
    }  
    if (payment_type == "") {
        alert('Please input Payment Type');
        $('#payment_type').focus();
        return false;
    }  
    if (contract_type == "") {
        alert('Please input  Contract Type');
        $('#contract_type').focus();
        return false;
    } 
    if (knockdown_period == "") {
        alert('Please input  Knock Down Period');
        $('#knockdown_period').focus();
        return false;
    } 
    if (knockdown_period != "") {
        var offer=offer_period.split(' - ');
        var knockdown=knockdown_period.split(' - ');
        var offer_end_date=new Date(offer[1]+':00');
        var knockdown_start_date=new Date(knockdown[1]+':00');
        if (offer_end_date> knockdown_start_date) 
        {
            alert('Please check Offer Period and Knock down period');
            $('#knockdown_period').focus();
            return false;
        }
    }  

     var auct_type='E';
    if (auct_type == "J") {
        var frequently = $('#frequently').val();
        var duration = $('#duration').val();

        if (frequently == "") {
            alert('Please input  Frequently');
            $('#frequently').focus();
            return false;
        } 
        if (duration == "") {
            alert('Please input  Duration (Minute)');
            $('#duration').focus();
            return false;
        } 
    }  
    if (offer_excel == "") {
        alert('Please select Excel File');
        $('#offer_excel').focus();
        return false;
    } 
    $("#preloder").fadeIn();

});