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

var date2 = new Date();
$('input[name="offer_dt"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: false,
    timePicker24Hour: true,
    timePickerIncrement: 1,
    autoApply: true,
    format: 'DD/MM/YYYY',
    minDate:date2,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'))
}, function(start, end, label) {

    var years = moment().diff(start, 'years');
    //alert("You are " + years + " years old!");
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
    
    var offer_nm = $('#offer_nm').val();
    var offer_dt = $('#offer_dt').val();
    var start_tm = $('#start_tm').val();
    var end_tm = $('#end_tm').val();
    var location = $('#location').val();
    var payment_type = $('#payment_type').val();
    var contract_type = $('#contract_type').val();
    var prompt_days = $('#prompt_days').val();
    var tea_place = $('#tea_place').val();
    var auct_type = $('#auct_type').val();
    var offer_excel = $('#offer_excel').val();

    if (offer_nm == "") {
        alert('Please input Offer Name');
        $('#offer_nm').focus();
        return false;
    }  
    if (offer_dt == "") {
        alert('Please input Offer Date');
        $('#offer_dt').focus();
        return false;
    }  
    if (start_tm == "") {
        alert('Please input Start Time');
        $('#start_tm').focus();
        return false;
    }  
    if (end_tm == "") {
        alert('Please input End Time');
        $('#end_tm').focus();
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
    if (prompt_days == "") {
        alert('Please input  Prompt Days');
        $('#prompt_days').focus();
        return false;
    }  
    if (tea_place == "") {
        alert('Please input Tea Place');
        $('#tea_place').focus();
        return false;
    }  
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