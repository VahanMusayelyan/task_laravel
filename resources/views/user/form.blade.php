@extends('layouts.app')

@section('content')

<?php
if (isset($result['name'])) {
    $value_name = $result['name'];
    $value_email = $result['email'];
    $button = "UPDATE";
    $color = "btn-success";
} else {
    $value_name = "";
    $value_email = "";
    $button = "SEND";
    $color = "btn-info";
}
?>  

<div class="container">
    @if(empty($result['id']))
    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
        @else
        <form action="{{route('users.update',$result['id'])}}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @endif

            @csrf
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="name form-control" value="{{$value_name}}" id="name" placeholder="Enter Name" name="name" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">E-mail</label>
                <div class="col-sm-10">
                    <input type="email" class="email form-control" value="{{$value_email}}" id="email" placeholder="Enter Email" name="email" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="password">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="password form-control" id="password" placeholder="Enter Password" name="password" autocomplete="off">
                </div>
            </div>

            <div class="col-sm-offset-2 col-sm-10 buttons_div">
                <button type="submit" class="btn {{$color}}">{{$button}}</button>
                <a class="btn btn-warning section_show" href="/public/users">SHOW USERS</a>
            </div>

        </form>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
</div>


@endsection