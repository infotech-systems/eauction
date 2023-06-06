function ValidateSize(file) {
      console.log(file.files[0]);
      var FileName=file.files[0].name;
      var FileSize = file.files[0].size // 500; // in MiB
      var maxsize=(1024*1024)*10;
      var parts = FileName.split('.');
      var extn=parts[parts.length-1].toLowerCase();

      console.log(extn);

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
