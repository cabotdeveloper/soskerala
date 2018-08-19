var map;
var geocoder;

function getLocationFromLatLng() {
    var lat = $("#lat").val();
    var lng = $("#lon").val();
    var location_address;
    var latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
    }; 

    geocoder.geocode({
        'location': latlng
    }, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                location_address = results[0].formatted_address;
                $("#user_input_autocomplete_address").val(location_address);
            } else {
                window.alert('No results found');
            }
        } else {
            //window.alert('Geocoder failed to get Location. Please try entering the latitude & longitude again. \nSytem message: ' + status);
        }
    });
}
// function getLatLngFromLocation(){
//     var location = $("#user_input_autocomplete_address").val();
//     geocoder.geocode({
//         'address': location
//     }, function(results, status) {
//         if (status === 'OK') {
//             if (results[0]) {
//                 lat = results[0].geometry.location.lat;
//                 long = results[0].geometry.location.lng;
//                 $("#lat").val(lat);
//                 $("#lon").val(long);                
//             } else {
//                 window.alert('No results found');
//             }
//         } else {
//             window.alert('Geocoder failed to get Location. Please try entering the location again. \nSytem message: ' + status);
//         }
//     });
// }
function drawPins(data) {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(10.1059814, 76.3192878),
        fullscreenControl: true
    });

    geocoder = new google.maps.Geocoder();
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
    var markerArray = []
    for (i = 0; i < data.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(data[i]['latitude'], data[i]['longitude']),
            map: map,
            icon: getIcon(data[i]['issue_status'])
        });
        markerArray.push(marker);
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
            'Rescue Status:<h5>' + statusText + '</h5>' +
            '</div>' +
            '<div id="bodyContent">' +
            'Location: <b>' + data[i]['location_address'] + '</b><br /><br />' +
            'Contact Person Name: <b>' + data[i]['contact_person_name'] + '</b><br /><br />' +
            'Contact Person Phone: <b>' + data[i]['contact_person_mobile'] + '</b><br /><br />' +
            'Issue reported on: <b>' + data[i]['reported_date'] + '</b><br /><br />' +
            'Issue last updated on: <b>' + data[i]['updated_date'] + '</b><br /><br />' +
            'Reported by: <b>' + data[i]['reported_by'] + '</b><br /><br />' +
            'Additional Notes: <b>' + data[i]['additional_notes'] + '</b><br /><br />' +
            'Change Status: <select ' + ((data[i]['issue_status'] == "0") ? 'disabled' : '') + ' id=change_status_' + data[i]['issue_id'] + '><option ' + ((data[i]['issue_status'] == "0") ? 'selected' : '') + ' value=0>To be rescued</option>' +
            '<option ' + ((data[i]['issue_status'] == "1") ? 'selected' : '') + ' value=1>Rescue In Progress</option>' +
            '<option ' + ((data[i]['issue_status'] == "2") ? 'selected' : '') + ' value=2>Rescue completed</option></select>' + '</b><br /><br />' +
            '<input type="button" class="btn btn-danger pin_popup_btn" onclick=deleteIssue(' + data[i]['issue_id'] + ') value="Delete">'+
            '<input type="button" class="btn btn-info pin_popup_btn" onclick=editClick(' + data[i]['issue_id'] + ') value="Edit">'+ 
            '<input type="button" class="btn btn-info pin_popup_btn" onclick=changeStatus(' + data[i]['issue_id'] + ') value="Submit">' + 
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
}

function saveEntry(event) {

    event.preventDefault();
    var location = $('#user_input_autocomplete_address').val();
    var latitude = $("#lat").val();
    var longitude = $("#lon").val();
    
    if (location == ''){
        if(latitude == '' || longitude =='') {
            alert("Please enter location address before you submit.");
            return;
        }
    } 
    $("#save_modal_btn_id").prop('disabled', true);
    var noPersons = $('#no_persons').val();
    var contactName = $('#contact_name').val();
    var contactMobile = $('#contact_mobile').val();    
    var notes = $('#notes').val();

    $.post("./ajax/add_issue.php", 'location=' + location + '&noPersons=' + noPersons + '&contactName=' + contactName + '&contactMobile=' + contactMobile + '&notes=' + notes + '&latitude='+latitude+ '&longitude='+ longitude, function(result, status, xhr) {
           
            if (status.toLowerCase() == "error".toLowerCase()) {
                alert("An Error Occurred..");
            } else {
                //$("#wait").css("display", "none");
                alert(result);
                $("#save_modal_btn_id").prop('disabled', false);
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
    // var location=$('#locationedit').val();    
    var noPersons=$('#no_personsedit').val();
    var contactName=$('#contact_nameedit').val();
    var contactMobile=$('#contact_mobileedit').val();
    var notes = $('#notesedit').val();
    var status = $('#mySatus').val();
    var issueId = $('#issueId').val();
    $.post("./ajax/edit_issue.php",'noPersons='+noPersons+'&contactName='+contactName+'&contactMobile='+contactMobile+'&notes='+notes+'&status='+status+'&issueId='+issueId,function(result,status,xhr) {
            if( status.toLowerCase()=="error".toLowerCase() )
            { 
                alert("An Error Occurred.."); 
            }
            else { 
                
                $("#editForm")[0].reset();
                alert(result);
                window.location.reload();
            }
        })
        .fail(function(){ alert("something went wrong. Please try again") });
}

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip(); 
    var issue_table =$('#issue_table').DataTable({
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
                "data": "reported_by"
            },
            {
                "data": "issue_status"
            },
            { 
                "defaultContent": '<button>Edit</button>'
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
                    return "To be rescued";
                }

            },
            "targets": 7
        }, {// The `data` parameter refers to the data for the cell (defined by the
            // `data` option, which defaults to the column being worked with, in
            // this case `data: 0`.
            "render": function(data, type, row) {
                return "<button onclick=editClick('"+row.issue_id+"')>Edit</button>";
                // if (row.issue_status == 2) {
                //     return "Rescue Completed";
                // } else if (row.issue_status == 1) {
                //     return "Rescue In Progress";
                // } else {
                //     return "Yet to rescue";
                // }

            },
            "targets": 8
        }

        ]

    });
    $('#issue_table tbody').on('click', 'tr', function () {
        var data = issue_table.row( this ).data();
        if ( data['latitude'] != '' && data['longitude'] != '') {
            var myLatlng = new google.maps.LatLng(data['latitude'], data['longitude']);
            $('html, body').scrollTop(0);
            map.setZoom(17); 
            map.panTo(myLatlng);
        } else {
            alert("There is no marker pin for this location, because Google API did not provide latitude or longitude for this location");
        }

    } );

    $('#issue_table tbody').on('click', 'td', function (event) {
        if ($(this).index() == 8 ) { //Edit button at this index
            event.stopPropagation();
            return;
        }
    });
    // $("#radio_location").click(function(){
    //     $("#lat").attr("disabled","disabled");
    //     $("#lon").attr("disabled","disabled");
    //     $("#user_input_autocomplete_address").removeAttr("disabled");        
    // });
    // $("#radio_latlong").click(function(){
    //     $("#user_input_autocomplete_address").attr("disabled","disabled");        
    //     $("#lat").removeAttr("disabled");
    //     $("#lon").removeAttr("disabled");
    // });
});
function editClick(id){
 //$('#issue_table tbody').on( 'click', 'button', function () {
       // var data = table.row( $(this).parents('tr') ).data();
        //var id = data.issue_id;
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
                $('#latitude').val(data.latitude);
                $('#longitude').val(data.longitude);
                $('#no_personsedit').val(data.no_of_persons);
                $('#contact_nameedit').val(data.contact_person_name);
                $('#contact_mobileedit').val(data.contact_person_mobile);
                $('#notesedit').val(data.additional_notes);
                $('#statusedit').val(data.issue_status);
                $('#issueId').val(data.issue_id);
                $('#mySatus').val(data.issue_status); 
                if(localStorage.getItem("user_type") == 1){
                    $('#mySatus').attr("disabled","disabled"); 
                }
                $('#issueIdDelete').val(data.issue_id);  

            }
        })
        .fail(function(){ alert("something went wrong. Please try again") });


   // } );

}


function changeStatus(issue_id) {
    var issue_status = $('#change_status_' + issue_id + ' option:selected').val();
    $.ajax({
    url: "./ajax/change_status.php?issue_id="+issue_id+"&newStatus="+issue_status,
    async: true,
    dataType: 'json',
    success: function (data) {
        if (data == 1) {
            alert("Rescue status saved succesfully");
            location.reload();
        } 
        else if(data == 0){
            alert("Temporarily unable to save the changes. Please try again later.");
        }
        else{
            alert("You are unauthorized to do this operation");
        }
    }
    });
}

function deleteIssueId(){        
    deleteIssue($('#issueId').val());
}
///nimi///
function deleteIssue(issue_id) {
    if(localStorage.getItem("user_type") == 1){
        alert("You are not authorized to do delete");
        return;
    }
    var message = confirm('Are you sure you want to delete this record?');
    if (message == true) {   
         $.post("./ajax/delete_issue.php",'issue_id='+issue_id,function(result,status,xhr) {
            if( status.toLowerCase()=="error".toLowerCase() )
            { 
                alert("An Error Occurred.."); 
            }
            else { 
             window.location.reload();              
            }
        })
        .fail(function(){ alert("something went wrong. Please try again") });
    }else{
       return;
    }
   
}
///
function userChange(){
    var userType = $("#user_type option:selected").val();
    if(userType != 1){
      $("#login_div").show();
      $("#user_name").val('');
      $("#password").val('');
    }
    else{
      $("#login_div").hide();        
    }
}
function modalClose(){
    var userType = $("#user_type option:selected").val();
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
    var userType = $("#user_type option:selected").val();    
    if(userType == 1){
        $("#loggedin_user").text('Victim/Guest');
        localStorage.setItem("user_type", userType);
        localStorage.setItem("user_name", 'Victim/Guest');
        var userName = 'Victim/Guest';
        var password = '';
        //$('#loginModal').modal('hide');
    }    
    else{
        var userName = $("#user_name").val();
        var password = $("#password").val();
        if(!userName || !password){
            alert("Incorrect user name and password");
            return;
        }                
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
function changeUser(){
    $('#loginModal').modal('show');

}
function reportIssue(){

    $("#add_button").click();
}
function resetIssue(){

    $('#user_input_autocomplete_address').val('');
    $("#lat").val('');
    $("#lon").val(''); 
    $('#no_persons').val('');
    $('#contact_name').val('');
    $('#contact_mobile').val('');    
    $('#notes').val('');
      
}