
$(document).ready(function () {
    projectList();
    $("#projectModal").on("hidden.bs.modal", function () {
        $("#projectForm")[0].reset();
        $("#hid").val("");
        $("#projectForm").validate().resetForm();
        $("#projectForm").find('.error').removeClass('error');
    });
});


$(document).on('click', '#addProject', function () {
    $("#projectModal").modal("show");
})

$('form[id="projectForm"]').validate({
    rules: {
        projectname: 'required',
        description: 'required',
    },
    messages: {
        projectname: 'Project name is required',
        description: 'description is required',
    },
    submitHandler: function () {
        $.ajax({
            url: BASE_URL + "/admin/insert/projects",
            type: "POST",
            data: $("#projectForm").serialize(),
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status == 1) {
                    Swal.fire(
                        'Good job!',
                        data.msg,
                        'success'
                    );
                    projectList();
                    $("#projectModal").modal("hide");
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
            url: BASE_URL + "/admin/projects",
            data: {
                _token: $("[name='_token']").val(),
            },
        },
        columns: [
            { data: "id", name: "id" },
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


$(document).on('click','#editProject',function(){
    var editId = $(this).data('id');
    $.ajax({
        type: "GET",
        url: BASE_URL + "/admin/edit/projects",
        data: {
            _token: $("[name='_token']").val(),
            id: editId,
        },
        success: function(response) {
            var data = JSON.parse(response);
            console.log(data)
            if (data.status == 1) {
                $('#hid').val(data.data.id);
                $('#projectname').val(data.data.name);
                $('#description').val(data.data.description);
                $("#projectModal").modal("show");
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

  
$(document).on('click','#removeProject',function(){
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
                url:  BASE_URL + "/admin/delete/projects",
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
                        projectList();
                    } else{
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