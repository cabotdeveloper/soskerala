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
      $(window).on('load',function(){
        if(!localStorage.getItem("user_type")){
          $('#loginModal').modal({backdrop: 'static', keyboard: false});
          $('#loginModal').modal('show');
        }
        else
          $("#loggedin_user").text(localStorage.getItem("user_name"));        
      });       
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
        //Location autocomplete
        var input = document.getElementById('user_input_autocomplete_address');                 
        new google.maps.places.Autocomplete(input); 

        //Open pop-up on map click
        

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
    <style>
        .pac-container {
            z-index: 10000 !important;
        }
    </style>
  </head>
  <body>
    <div id="loginModal" class="modal fade" role="dialog">
      <div class="modal-dialog">    
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" onclick="modalClose()">&times;</button>
            <h4 class="modal-title">Login</h4>
          </div>
          <div class="modal-body">
            <label for="user_type">Select user type :</label>
            <select class="form-control" id="user_type" onchange="userChange()">
              <option value=1 selected>Victim/Guest</option>
              <option value=2>Rescuer</option>
              <option value=3>Moderator</option>            
            </select><br>
            <div id="login_div" style="display:none;">
              User Name :<input type="text" id="user_name"> 
              Password :<input type="password" id="password"> 
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="login()">Login</button>
            <button type="button" class="btn btn-secondary" onclick="modalClose()">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div id="map" style="height:50%; vertical-align:bottom"></div>
    <div id="logged_dt">
      Logged in as : <span id="loggedin_user"></span> 
      &nbsp;&nbsp;<a id="change_btn" onclick="changeUser()">Change user role</a>
      
    </div>
    <div id="infowindow-content">
          <img src="" width="16" height="16" id="place-icon">
          <span id="place-name" class="title"></span>
          <br>
          <span id="place-address"></span>
        </div>
        <div>
          <a data-toggle="modal" id="add_button" data-target="#form" class="float-button" style="cursor:pointer">+</a>
        </div>
        <div id="form" class="modal fade">
          <div class="modal-dialog">
          <div class="modal-content">
          
            <div  class="modal-body" style="height:100%">
                <form action="" id="entryForm" method="post" onsubmit="event.preventDefault()">
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
                    <input type="button"  value="Cancel" class="btn-secondary add_btns" data-dismiss="modal">
                    <input type="hidden" id="lat" name="lat">
                    <input type="hidden" id="lon" name="lon">
                    <input type="submit" onclick="saveEntry(event)" value="Submit" class="btn-primary add_btns">
                    
                </form>            
            
            
            </div>
        </div>
    </div>
    </div>

   <div>
          <a data-toggle="modal" data-target="#form" class="float-button" style="cursor:pointer">+</a>
        </div>
        <div id="formEdit" class="modal fade">
          <div class="modal-dialog">
          <div class="modal-content">
          
            <div  class="modal-body" style="height:100%">
                <form action="" id="entryForm" method="post">
                <p class="heading">Location</p>
                    <input id="locationedit" type="text" value="" placeholder="Enter a location" name="location" required>                    
                    <p class="heading">Number of persons</p>
                    <input type="text" id="no_personsedit" name="no_persons">
                    <p class="heading">Contact Person Name</p>
                    <input type="text" id="contact_nameedit" name="contact_name">
                    <p class="heading">Contact Number</p>
                    <input type="text" id="contact_mobileedit" name="contact_mobile">
                    <p class="heading">Notes</p>
                    <textarea id = "notesedit" name="notes"></textarea>
                    <p class="heading">Status</p>    
                      <select id="mySatus" style="width: 100%;padding: 12px 20px;margin: 8px 0;box-sizing: border-box;" >
                        <option value="0">To be rescued</option>
                        <option value="1">Rescue In Progress</option>
                        <option value="2">Rescue completed</option>                   
                      </select> 
                    <input type="hidden" id="issueId" name="issueId">
                    <input type="button"  value="Cancel" class="btn-secondary" data-dismiss="modal">
                    <input type="button" id="delete_btn" class="btn btn-danger" onclick="deleteIssueId()" value="Delete">
                    <input type="submit" onclick="editEntry(event)" value="Save" class="btn-primary">
                </form>            
            
            
            </div>
        </div>
    </div>
    </div>


    
  
    <table id="issue_table" class="display dataTable table-bordered" style="width:100%; font-size:12px; margin-top:20px;">
      <thead>
          <tr>
              <th>Location</th>
              <th>No of persons</th>
              <th>Contact Name</th>
              <th>Contact Number</th>
              <th>Reported date</th>
              <th>Updated Date</th>
              <th>Status</th>
               <th>Action</th>
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
               <th>Action</th>
          </tr>
      </tfoot>
  </table>


  <script src="./js/main.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
