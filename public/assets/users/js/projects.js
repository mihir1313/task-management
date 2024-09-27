
$(document).ready(function() {
    projectList();
});


function projectList() {
    $("#projectTable").DataTable({
        processing: true,
        bDestroy: true,
        bAutoWidth: false,
        serverSide: true,
        lengthChange: false,
        searching: false,
        paging: false,
        ajax: {
            type: "POST",
            url: BASE_URL + "/user/projects",
            data: {
                _token: $("[name='_token']").val(),
            },
        },
        columns: [
            { data: "project_id", name: "project_id" },
            { data: "name", name: "name" },
            { data: "description", name: "description" },
            { data: "action", name: "action" },
        ],
        columnDefs: [{
            targets: [],
            orderable: false,
            searchable: false,
        },],
    });
}
