var map;

function drawPins(data) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(10.1059814, 76.3192878)
    });

    var geocoder = new google.maps.Geocoder();
    google.maps.event.addListener(map, "click", function(event) {
        geocoder.geocode({
            'latLng': event.latLng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    //alert(event.latLng.lat() + " " + event.latLng.lng())                              
                    $("#user_input_autocomplete_address").val(results[0].formatted_address);
                    $("#lat").val(event.latLng.lat());
                    $("#lon").val(event.latLng.lng());
                    $("#add_button").trigger("click");
                }
            }
        });
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

        infoContent[i] = '<div id="content">' +
            '<div id="siteNotice">' +
            'Rescue Status:<h2>' + statusText + '</h2>' +
            '</div>' +
            '<div id="bodyContent">' +
            'Location: <b>' + data[i]['location_address'] + '</b><br />' +
            'Contact Person Name: <b>' + data[i]['contact_person_name'] + '</b><br />' +
            'Contact Person Phone: <b>' + data[i]['contact_person_mobile'] + '</b><br />' +
            'Issue reported on: <b>' + data[i]['reported_date'] + '</b><br />' +
            'Issue last updated on: <b>' + data[i]['updated_date'] + '</b><br /><br />' +
            'Additional Notes: <b>' + data[i]['additional_notes'] + '</b><br /><br />' +
            'Change Status: <select id=change_status_' + data[i]['issue_id'] + '><option ' + ((data[i]['issue_status'] == "0") ? 'selected' : '') + ' value=0>To be rescued</option>' +
            '<option ' + ((data[i]['issue_status'] == "1") ? 'selected' : '') + ' value=1>Rescue In Progress</option>' +
            '<option ' + ((data[i]['issue_status'] == "2") ? 'selected' : '') + ' value=2>Rescue completed</option></select>' +
            '<input type="button" class="changeStatus" onclick=changeStatus(' + data[i]['issue_id'] + ') value="Submit">' +
            '</div>' +
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


        var icon;
        d
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
        google.maps.event.addListener(marker, "click", function() {
            infowindow.open(map, marker);
        });
        //infowindow.open(map, marker);
    }
}

function saveEntry(event) {

    event.preventDefault();
    var location = $('#user_input_autocomplete_address').val();
    var noPersons = $('#no_persons').val();
    var contactName = $('#contact_name').val();
    var contactMobile = $('#contact_mobile').val();
    var latitude = $("#lat").val();
    var longitude = $("#lon").val();
    var notes = $('#notes').val();
    $.post("./ajax/add_issue.php", 'location=' + location + '&noPersons=' + noPersons + '&contactName=' + contactName + '&contactMobile=' + contactMobile + '&notes=' + notes + '&latitude='+latitude+ '&longitude='+ longitude, function(result, status, xhr) {
            if (status.toLowerCase() == "error".toLowerCase()) {
                alert("An Error Occurred..");
            } else {
                alert(result);
                $("#entryForm")[0].reset();
                window.location.reload();
            }
        })
        .fail(function() {
            alert("something went wrong. Please try again")
        });
}
function editEntry(event) {

    event.preventDefault();
    var location=$('#locationedit').val();
    var noPersons=$('#no_personsedit').val();
    var contactName=$('#contact_nameedit').val();
    var contactMobile=$('#contact_mobileedit').val();
    var notes = $('#notesedit').val();
    var status = $('#mySatus').val();
    var issueId = $('#issueId').val();
    $.post("./ajax/edit_issue.php",'location='+location+'&noPersons='+noPersons+'&contactName='+contactName+'&contactMobile='+contactMobile+'&notes='+notes+'&status='+status+'&issueId='+issueId,function(result,status,xhr) {
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



$(document).ready(function() {
    
    $("#user_input_autocomplete_address").change(function(){
        $("#lat").val('');
        $("#lon").val('');
    })

     var table =$('#issue_table').DataTable({
        "ajax": "./ajax/data_table.php",
        "order": [
            [4, "desc"]
        ],
        "columns": [{
                "data": "location_address",
                "width": "100px"
            },
            {
                "data": "no_of_persons"
            },
            {
                "data": "contact_person_name"
            },
            {
                "data": "contact_person_mobile"
            },
            {
                "data": "reported_date"
            },
            {
                "data": "updated_date"
            },
            {
                "data": "issue_status"
            },
            { 
                "defaultContent": "<button>Edit</button>"
            }
        ],
        "columnDefs": [{
            // The `data` parameter refers to the data for the cell (defined by the
            // `data` option, which defaults to the column being worked with, in
            // this case `data: 0`.
            "render": function(data, type, row) {

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
     $('#issue_table tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var id = data.issue_id;
        $.post("./ajax/get_issue_details.php",'id='+id,function(result,status,xhr) {
            if( status.toLowerCase()=="error".toLowerCase() )
            { 
                alert("An Error Occurred.."); 
            }
            else { 
                //event.preventDefault();
                $("#formEdit").modal('show');
                var data =$.parseJSON(result);
                $('#locationedit').val(data.location_address);
                $('#no_personsedit').val(data.no_of_persons);
                $('#contact_nameedit').val(data.contact_person_name);
                $('#contact_mobileedit').val(data.contact_person_mobile);
                $('#notesedit').val(data.additional_notes);
                $('#statusedit').val(data.issue_status);
                $('#issueId').val(data.issue_id);
                $('#mySatus').val(data.issue_status);   

            }
        })
        .fail(function(){ alert("something went wrong. Please try again") });


    } );
});

function changeStatus(issue_id) {
    var issue_status = $('#change_status_' + issue_id + ' option:selected').val();
    $.ajax({
        url: "./ajax/change_status.php&issue_id=" + issue_id + "&newStatus=" + issue_status + "",
        async: true,
        dataType: 'json',
        success: function(data) {
            if (data == 1) {
                alert("Rescue status saved succesfully");
                location.reload();
            } else {
                alert("Temporarily unable to save the changes. Please try again later.");
            }

        }
    });    
}

function userChange(){
    var userType = $("#user_type :selected").val();
    if(userType != 1){
      $("#login_div").show();
    }
    else{
      $("#login_div").hide();        
    }
}
function modalClose(){
    var userType = $("#user_type :selected").val();
    if(userType == 1){
        $("#loggedin_user").text('Victim/Guest');
        $('#loginModal').modal('hide');
    }
    else if($("#loggedin_user").text() == ''){
        alert("Please select any user");
        return;
    }
    else{
        $('#loginModal').modal('hide');
        return;
    }
}
function login(){
    var userType = $("#user_type :selected").val();    
    if(userType == 1){
        $("#loggedin_user").text('Victim/Guest');
        localStorage.setItem("user_type", userType);
        localStorage.setItem("user_name", 'Victim/Guest');
        $('#loginModal').modal('hide');
    }    
    else{
        var userName = $("#user_name").val();
        var password = $("#password").val();
        if(!userName || !password){
            alert("Incorrect user name and password");
            return;
        }
        $.post("./ajax/login.php",
        {
            user_name : userName,
            password : password,
            user_type : userType
        },
        function(result,status){
            if( status.toLowerCase()=="error".toLowerCase() )
            { 
                alert("An Error Occurred.."); 
            }
            else { 
                if(result == 'Success'){
                    $("#loggedin_user").text(userName);
                    $("#login_div").hide();
                    $('#loginModal').modal('hide');
                    localStorage.setItem("user_type", userType);
                    localStorage.setItem("user_name", userName);
                    return;
                }
                else{
                    alert("Incorrect login");
                    return;
                }                
            }
        })
        .fail(function(){ 
            alert("something went wrong. Please try again");
            return;
        });        
    }        
}
function changeUser(){
    $('#loginModal').modal('show');

}