@extends('user.layouts.index')
@section('user-title', 'User | Projects')
@section('user-content')

<div class="pagetitle">
    <h1>Projects</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                        {{--  <div class="col">
                            <button class="btn btn-primary float-end mt-3" id="addProject">Add Project</button>
                        </div>  --}}
                    </div>
                    <table class="table" id="projectTable">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: center">Id</th>
                                <th scope="col" style="text-align: center">Name</th>
                                <th scope="col" style="text-align: center">Description</th>
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

@section('user-footer')
<script type="text/javascript" src="{{ asset('assets/users/js/projects.js') }}"></script>

@endsection
