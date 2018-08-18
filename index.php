<!DOCTYPE html>
<html>
  <head>
    <title>SOSKerala: Kerala Flood Rescue</title>
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
      function getData() {
        $.ajax({
          url: "map_api_wrapper.php?getData",
          async: true,
          dataType: 'json',
          success: function (data) {
            console.log(data);
            // $.each(data, function(index, value){
            drawPins(data);
            // })
            
          }
        });  
      }
    </script>
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"> -->
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyC5c7RVG5abNguKbkJbKobTKhOu_pEtk4s&callback=getData" async defer></script>
    
   
    <?php if ($ret == 1) { 
      echo "<script>"
    ?> 
    alert("Issue added successfully.");  
    <?php
    echo "</script>";
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
    ?>    
    </script>
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-size: 12px;
      }
      #issue_table_wrapper {
        margin: 20px;
      }
      .changeStatus {
        margin-left:10px;
      }

      #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        /* .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        } */

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        /* #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        } */

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            resize: none;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        .heading {
            margin-bottom: 0px;
            font-size: 14px;
            color: #4e4e4e;
            font-family: 'Montserrat', sans-serif;
        }

         input[type=submit] {
            width: 30%;
            /* float:right !important; */
            background-color: #14bdef;
            color: white;
            padding: 14px 20px;
            margin: 2% 0 0 10%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=button] {
            width: 30%;
            /* float:left; */
            padding: 14px 20px;
            margin: 2% 0 0 15%;
            border-radius: 4px;
            border:none;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #61cdee;
        }

        .float-button {
          position: fixed;
          bottom: 60px;
          right: 44px;
          width: 54px;
          height: 53px;
          z-index: 1001;
          color: #ffffff;
          background-color: #14bdef;
          border-radius: 50%;
          border: 1px solid #14bdef;
          text-align: center;
          color: #ffffff;
          font-size: 30px;
          padding-top: 3px;
          text-decoration: none;
        }

        .float-button:hover {
            position: fixed;
            bottom: 60px;
            right: 44px;
            width: 54px;
            height: 53px;
            text-align: center;
            z-index: 1001;
            color: #14bdef;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 50%;
            border: 2px solid rgb(255, 255, 255);
            font-size: 30px;
            padding-top: 3px;
            text-decoration: none;

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
                <p class="heading">Location</p>
                    <input id="location" type="text" placeholder="Enter a location" name="location" required>                    
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

    <script type="text/javascript">
  var map;
  
  
  
  function drawPins(data) {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(10.1059814, 76.3192878)
    });
    
   
    //var marker, i;
    var infoContent = []

    for (i = 0; i < data.length; i++) { 
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data[i]['latitude'], data[i]['longitude']),
        map: map,
        icon: getIcon(data[i]['issue_status'])
      });

     var statusText; 
     if (data[i]['issue_status'] == 2) {
       statusText = "Rescue completed"
     } else if (data[i]['issue_status'] == 1) {
       statusText = "Rescue In Progress"
     } else {
       statusText = "To be rescued"
     }
      console.log(data[i]['issue_status']);

      var infowindow = new google.maps.InfoWindow();

      infoContent[i] = '<div id="content">'+
        '<div id="siteNotice">'+
        'Rescue Status:<h2>'+statusText+'</h2>'+
        '</div>'+
        '<div id="bodyContent">'+
        'Location: <b>'+data[i]['location_address']+'</b><br />'+
        'Contact Person Name: <b>'+data[i]['contact_person_name']+'</b><br />'+
        'Contact Person Phone: <b>'+data[i]['contact_person_mobile']+'</b><br />'+
        'Issue reported on: <b>'+data[i]['reported_date']+'</b><br />'+
        'Issue last updated on: <b>'+data[i]['updated_date']+'</b><br /><br />'+
        'Additional Notes: <b>'+data[i]['additional_notes']+'</b><br /><br />'+
        'Change Status: <select id=change_status_'+data[i]['issue_id']+'><option '+((data[i]['issue_status'] == "0")? 'selected':'')+' value=0>To be rescued</option>'+ 
        '<option '+((data[i]['issue_status'] == "1")? 'selected':'')+' value=1>Rescue In Progress</option>'+
        '<option '+((data[i]['issue_status'] == "2")? 'selected':'')+' value=2>Rescue completed</option></select>'+
        '<input type="button" class="changeStatus" onclick=changeStatus('+data[i]['issue_id']+') value="Submit">'+
        '</div>'+
        '</div>';
     
      console.log(infoContent[i]);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(infoContent[i]);
          infowindow.open(map, marker);
        }
      })(marker, i));
  }

  function getIcon(issue_status) {
    var icon;
    if (issue_status == 0) {
      icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
    } else if (issue_status == 1) {
      icon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
    } else if (issue_status == 2) {
      icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
    }
    console.log(icon)
    return icon;
  }


  function init_map(data) {
        if (data['id'] == 1) {
          var map_options = {
            zoom: 14,
            center: new google.maps.LatLng(data['latitude'], data['longitude'])
          }
          var map = new google.maps.Map(document.getElementById("map"), map_options);
        }
        

        var icon;d
        console.log(data);
          
        
        var marker;
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(data['latitude'], data['longitude']),
            icon: icon
        });
        infowindow = new google.maps.InfoWindow({
            content: data['location_address']
        });
        google.maps.event.addListener(marker, "click", function () {
            infowindow.open(map, marker);
        });
        //infowindow.open(map, marker);
    }
  }  

  function saveEntry(event) {
      
        event.preventDefault();
        var location=$('#location').val();
        var noPersons=$('#no_persons').val();
        var contactName=$('#contact_name').val();
        var contactMobile=$('#contact_mobile').val();
        var notes=$('#notes').val();
        $.post("save_entry.php",'location='+location+'&noPersons='+noPersons+'&contactName='+contactName+'&contactMobile='+contactMobile+'&notes='+notes,function(result,status,xhr) {
                if( status.toLowerCase()=="error".toLowerCase() )
                { 
                    alert("An Error Occurred.."); 
                }
                else { 
                    alert(result);
                    $("#entryForm")[0].reset();
                    window.location.reload();
                }
            })
            .fail(function(){ alert("something went wrong. Please try again") });
    }
    </script>

    
  
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


  <script>
    $(document).ready(function() {
      $('#issue_table').DataTable( {
          "ajax": "data_table.php",
          "order": [[ 4, "desc" ]],
          "columns": [
            { "data": "location_address", "width":"100px" },
            { "data": "no_of_persons" },
            { "data": "contact_person_name" },
            { "data": "contact_person_mobile" },
            { "data": "reported_date" },
            { "data": "updated_date" },
            { "data": "issue_status" }],
          "columnDefs": [ {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
                    
                  if (row.issue_status == 2) {
                    return "Rescue Completed";
                  } else if (row.issue_status == 1) {
                    return "Rescue In Progress";
                  } else {
                    return "Yet to rescue";
                  }
                  
                },
                "targets": 6
            }]

      });

      

    });

    function changeStatus(issue_id) {
      var issue_status = $('#change_status_'+issue_id+' option:selected').val();
      $.ajax({
        url: "./map_api_wrapper.php?changeStatus&issue_id="+issue_id+"&newStatus="+issue_status+"",
        async: true,
        dataType: 'json',
        success: function (data) {
          if (data == 1) {
            alert("Rescue status saved succesfully");
            location.reload();
          } else {
            alert("Temporarily unable to save the changes. Please try again later.");
          }
        
        }
      }); 
    }
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
