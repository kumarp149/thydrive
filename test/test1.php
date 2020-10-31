<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
          title : "Are you sure to delete files",
          text: "You cannot revert once done",
          //icon: "success",
          type: "warning",
          buttons: ["Cancel", "Delete"]
        })
      })
      $(".main-btn-1").click(function(){
        swal({
          title: "Rename",
          text: "Name cannot contain the word 'thydrive'",
          content: {
            element: "input",
            attributes: {
              placeholder: "Enter Here",
              type: "text",
            },
          },
        }),
        function(inputValue)
        {
          if (inputValue === false) return false;
          if (inputValue === '')
          {
            swal.showInputError("You need to write something!");
            return false;
          }
        }
      })
    })
  </script>
</body>
