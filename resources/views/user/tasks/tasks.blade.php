@extends('user.layouts.index')
@section('user-title', 'User | Tasks')
@section('user-content')

<div class="pagetitle">
    <h1>Project : {{ isset($project[0]['name']) ? $project[0]['name'] : "Tasks" }}</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col">
                            <button class="btn btn-primary float-end mt-3" id="addtask">Add Task</button>
                        </div>
                    </div>
                    <table class="table" id="taskTable">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: center">Id</th>
                                <th scope="col" style="text-align: center">Title</th>
                                <th scope="col" style="text-align: center">Description</th>
                                <th scope="col" style="text-align: center">status</th>
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
@include('user.tasks.taskModal')

<script type="text/javascript" src="{{ asset('assets/users/js/tasks.js') }}"></script>

@endsection
