
    $(document).ready(function() {
        userList();
        $("#userModal").on("hidden.bs.modal", function() {
            $("#userForm")[0].reset();
            $("#hid").val("");
            $("#userForm").validate().resetForm();
            $("#userForm").find('.error').removeClass('error');
        });
    });

    $(document).on('click', '#addUser', function() {
        $("#userModal").modal("show");
    })

    $('form[id="userForm"]').validate({
        rules: {
            username: 'required',
            email: 'required',
            pass: 'required',
        },
        messages: {
            username: 'username is required',
            email: 'Email is required',
            pass: 'pass is required',
        },
        submitHandler: function() {
            var submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">Loading...</span>
            `);
            $.ajax({
                url: BASE_URL + "/admin/insert/users",
                type: "POST",
                data: $("#userForm").serialize(),
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        Swal.fire(
                            'Good job!',
                            data.msg,
                            'success'
                        );
                        userList();
                        $("#userModal").modal("hide");
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.msg,
                        })
                    }
                    submitButton.prop('disabled', false).html('Save changes');
                },
            });
        },
    });

    function userList() {
        $("#usersTable").DataTable({
            processing: true,
            bDestroy: true,
            bAutoWidth: false,
            serverSide: true,
            lengthChange: false,
            searching: false,
            paging: false,
            ajax: {
                type: "POST",
                url: BASE_URL + "/admin/users",
                data: {
                    _token: $("[name='_token']").val(),
                },
            },
            columns: [
                {data: "id", name: "id"},
                {data: "name", name: "name"},
                {data: "email", name: "email"},
                {data: "role", name: "role"},
                {data: "action", name: "action"},
                 ],
            columnDefs: [{
                targets: [],
                orderable: false,
                searchable: false,
            }, ],
        });
    }

    
$(document).on('click','#editUser',function(){
    var editId = $(this).data('id');
    $.ajax({
        type: "GET",
        url: BASE_URL + "/admin/edit/users",
        data: {
            _token: $("[name='_token']").val(),
            id: editId,
        },
        success: function(response) {
            var data = JSON.parse(response);
            console.log(data)
            if (data.status == 1) {
                $('#hid').val(data.data.id);
                $('#username').val(data.data.name);
                $('#email').val(data.data.email);
                // $('#pass').val(data.data.email);
                $("#userModal").modal("show");
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

  
$(document).on('click','#removeUser',function(){
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
                url:  BASE_URL + "/admin/delete/users",
                data: {
                    _token: $("[name='_token']").val(),
                    id: deleteId,
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        Swal.fire(
                          'Deleted!',
                          'User has been deleted.',
                          'success'
                        );
                        userList();
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