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
      var allowedExtensions = ["xls", "xlsx"];
      if (FileName.length > 0) {
          if (allowedExtensions.indexOf(extn) === -1) {
              alert('Invalid file Format. Only ' + allowedExtensions.join(', ') + ' are allowed.');
              $(file).val('');
              return false;
          }
      }
}