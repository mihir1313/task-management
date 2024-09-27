$(document).ready(function () {
    // alert('hello');
    taskList();
    $("#taskModal").on("hidden.bs.modal", function () {
        $("#taskForm")[0].reset();
        $("#hid").val("");
        $("#taskForm").validate().resetForm();
        $("#taskForm").find('.error').removeClass('error');
    });
});

$(document).on('click', '#addtask', function () {
    $("#taskModal").modal("show");
})

$('form[id="taskForm"]').validate({
    rules: {
        title: 'required',
        description: 'required',
        user: 'required',
        status: 'required',
    },
    messages: {
        title: 'title is required',
        description: 'description is required',
        user: 'Select user',
        status: 'Select status',
    },
    submitHandler: function () {
        $.ajax({
            url: BASE_URL + "/admin/insert/tasks",
            type: "POST",
            data: $("#taskForm").serialize(),
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status == 1) {
                    Swal.fire(
                        'Good job!',
                        data.msg,
                        'success'
                    );
                    taskList();
                    $("#taskModal").modal("hide");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                }
            },
        });
    },
});

function taskList() {
    $("#taskTable").DataTable({
        processing: true,
        bDestroy: true,
        bAutoWidth: false,
        serverSide: true,
        lengthChange: false,
        searching: false,
        paging: false,
        ajax: {
            type: "POST",
            url: BASE_URL + "/admin/tasks",
            data: {
                _token: $("[name='_token']").val(),
            },
        },
        columns: [
            { data: "id", name: "id" },
            { data: "title", name: "title" },
            { data: "description", name: "description" },
            { data: "status", name: "status" },
            { data: "action", name: "action" },
        ],
        columnDefs: [{
            targets: [],
            orderable: false,
            searchable: false,
        },],
    });
}

$(document).on('click', '#editTask', function () {
    var editId = $(this).data('id');
    $.ajax({
        type: "GET",
        url: BASE_URL + "/admin/edit/tasks",
        data: {
            _token: $("[name='_token']").val(),
            id: editId,
        },
        success: function (response) {
            var data = JSON.parse(response);
            console.log(data)
            if (data.status == 1) {
                $('#hid').val(data.data.id);
                $('#title').val(data.data.title);
                $('#description').val(data.data.description);
                $('select[name="user"]')
                    .val(data.data.user_id)
                    .trigger("change");
                $('select[name="status"]')
                    .val(data.data.status)
                    .trigger("change");
                $("#taskModal").modal("show");
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.msg,
                });
            }
        },
    });
})


$(document).on('click', '#removeTask', function () {
    var deleteId = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "DELETE",
                url: BASE_URL + "/admin/delete/tasks",
                data: {
                    _token: $("[name='_token']").val(),
                    id: deleteId,
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'success'
                        );
                        taskList();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.msg,
                        })
                    }
                },
            });
        }
    })
})