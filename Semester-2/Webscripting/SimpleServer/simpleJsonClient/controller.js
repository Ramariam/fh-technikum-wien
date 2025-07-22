$(document).ready(function () {
    $("#searchResult").hide();
    $("#btn_Search").click(function () {
        var searchTerm = $("#searchfield").val();
        loaddata(searchTerm);
    });

    // Extension A: Search by first name
    $("#btn_SearchFirstName").click(function () {
        var firstName = $("#searchFirstName").val();
        loaddataByFirstName(firstName);
    });

    // Extension B: Search by department
    $("#btn_SearchDepartment").click(function () {
        var department = $("#searchDepartment").val();
        loaddataByDepartment(department);
    });
});

function loaddata(searchterm) {
    $.ajax({
        type: "GET",
        url: "serviceHandler.php",
        data: { method: "queryPersonByName", param: searchterm },
        dataType: "json",
        success: function (response) {
            $("#noOfentries").val(response.length);
            displayResults(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// Extension A: Load data by first name
function loaddataByFirstName(firstName) {
    $.ajax({
        type: "GET",
        url: "serviceHandler.php",
        data: { method: "queryPersonByFirstName", param: firstName },
        dataType: "json",
        success: function (response) {
            $("#noOfentries").val(response.length);
            displayResults(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// Extension B: Load data by department
function loaddataByDepartment(department) {
    $.ajax({
        type: "GET",
        url: "serviceHandler.php",
        data: { method: "queryPersonByDepartment", param: department },
        dataType: "json",
        success: function (response) {
            $("#noOfentries").val(response.length);
            displayResults(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}