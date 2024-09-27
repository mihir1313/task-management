@extends('admin.layouts.index')
@section('admin-title', 'Admin | Users')
@section('admin-content')

<div class="pagetitle">
    <h1>Users</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col">
                            <button class="btn btn-primary float-end mt-3" id="addUser">Add User</button>
                        </div>
                    </div>
                    <table class="table" id="usersTable">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: center">Id</th>
                                <th scope="col" style="text-align: center">Username</th>
                                <th scope="col" style="text-align: center">Mail</th>
                                <th scope="col" style="text-align: center">Role</th>
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('admin-footer')
@include('admin.users.usersModal')
<script type="text/javascript" src="{{ asset('assets/admin/js/users.js') }}"></script>

@endsection
