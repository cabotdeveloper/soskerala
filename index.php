<!DOCTYPE html>
<html>
  <head>
    <title>SOSKerala: Kerala Flood Rescue</title>
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
      function getData() {
        $.ajax({
          url: "./ajax/get_all_issues.php",
          async: true,
          dataType: 'json',
          success: function (data) {
            console.log(data);
            // $.each(data, function(index, value){
            drawPins(data);
            // })
            
          }
        }); 
        var input = document.getElementById('user_input_autocomplete_address');                 
        new google.maps.places.Autocomplete(input); 

      }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5c7RVG5abNguKbkJbKobTKhOu_pEtk4s&callback=getData&libraries=places" async defer></script>
    
   
    <?php if (isset($ret) && $ret == 1) { 
      echo "<script>"
    ?> 
    alert("Issue added successfully.");  yyyy
    <?php
    echo "</script>";
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    ?>    
    </script>
    <meta charset="utf-8">
    <script>
        $(function () {
            var input = document.getElementById("keyword");
            var autocomplete = new google.maps.places.Autocomplete(input);

            $('#my-modal').modal('show');

        });

    </script>
    <style>
        .pac-container {
            z-index: 10000 !important;
        }
    </style>
  </head>
  <body>
    <div id="map" style="height:50%; vertical-align:bottom"></div>

    <div id="infowindow-content">
          <img src="" width="16" height="16" id="place-icon">
          <span id="place-name" class="title"></span>
          <br>
          <span id="place-address"></span>
        </div>
        <div>
          <a data-toggle="modal" data-target="#form" class="float-button" style="cursor:pointer">+</a>
        </div>
        <div id="form" class="modal fade">
          <div class="modal-dialog">
          <div class="modal-content">
          
            <div  class="modal-body" style="height:100%">
                <form action="" id="entryForm" method="post">
                  <p class="heading">Location Address</p>
 
                      <input type="text" id="user_input_autocomplete_address" name="user_input_autocomplete_address"
                             placeholder="Start typing your address...">
                  
                    <p class="heading">Number of persons</p>
                    <input type="text" id="no_persons" name="no_persons">
                    <p class="heading">Contact Person Name</p>
                    <input type="text" id="contact_name" name="contact_name">
                    <p class="heading">Contact Number</p>
                    <input type="text" id="contact_mobile" name="contact_mobile">
                    <p class="heading">Notes</p>
                    <textarea id = "notes" name="notes"></textarea>
                    <input type="button"  value="Cancel" class="btn-secondary" data-dismiss="modal">
                    <input type="submit" onclick="saveEntry(event)" value="Submit" class="btn-primary">
                    
                </form>            
            
            
            </div>
        </div>
    </div>
    </div>

   

    
  
    <table id="issue_table" class="display" style="width:100%; font-size:12px; margin-top:20px;">
      <thead>
          <tr>
              <th>Location</th>
              <th>No of persons</th>
              <th>Contact Name</th>
              <th>Contact Number</th>
              <th>Reported date</th>
              <th>Updated Date</th>
              <th>Status</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
              <th>Location</th>
              <th>No of persons</th>
              <th>Contact Name</th>
              <th>Contact Number</th>
              <th>Reported date</th>
              <th>Updated Date</th>
              <th>Status</th>
          </tr>
      </tfoot>
  </table>


  <script src="./js/main.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./js/autocomplete.js"></script>
  </body>
</html>
