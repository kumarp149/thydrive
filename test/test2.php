<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
  <style>
    .firstdiv
    {
      text-align: center;
      margin-top: 5%;
    }
    .seconddiv
    {
      text-align: center;
      position: absolute;
      top: 1%;
      height: 30%;
    }
  </style>
</head>
<body>
  <div class="container firstdiv">
    <button class="btn btn-primary main-btn">Alert</button>
  </div>
  <div class="container firstdiv">
    <button class="btn btn-primary main-btn-1">Prompt</button>
  </div>
  <script>
    $(document).ready(function(){
      $(".main-btn").click(function(){
        swal({
          dangerMode: true,
          confirmButtonColor: "#DD6B55",
          showCancelButton: true,
          title : "10 files will be deleted",
          text: "You cannot revert once done",
          //icon: "success",
          type: "warning",
          confirmButtonText: "Delete"
        }),then(function(){
          alert('Hello');
        })
      })
      $(".main-btn-1").click(function(){
        swal({
          title: "Rename",
          type: "input",
          showCancelButton: true,
          closeOnConfirm: false,
          inputPlaceholder: "Enter",
          confirmButtonText: "Rename",
          closeOnCancel: true,
          inputValue: "Hello"
        },
      function(inputValue){
        if (inputValue === "")
        {
          swal.showInputError("File name is required");
        }
        else
        {
          swal.close();
        }
      })
      })
/*swal({
  title: "Rename",
  //text: "Write something interesting:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  inputPlaceholder: "Enter"
}, function (inputValue) {
  if (inputValue === false) return false;
  if (inputValue == "") {
    swal.showInputError("You need to write something!");
    //return false
  }
  swal("Nice!", "You wrote: " + inputValue, "success");
});


})*/
    })
  </script>
</body>
