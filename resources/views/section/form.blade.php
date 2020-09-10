@extends('layouts.app')

@section('content')

<?php
if (isset($result['name'])) {
    $value_name = $result['name'];
    $value_desc = $result['description'];
    $value_logo = "<img src='/public/storage/" . $result['logo'] . "' class='update_logo'>";
    $button = "UPDATE";
    $color = "btn-success";
} else {
    $value_name = "";
    $value_desc = "";
    $value_logo = "";
    $button = "SEND";
    $color = "btn-info";
}
?>  

<div class="container">
    @if(empty($result['id']))
    <form action="{{route('sections.store')}}" method="post" enctype="multipart/form-data">
        @else
        <form action="{{route('sections.update',$result['id'])}}" method="POST" enctype="multipart/form-data">
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
                <label class="control-label col-sm-2" for="description">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" placeholder="Enter Description" rows="3" name="description">{{$value_desc}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="file_logo" for="logo">Logo</label>
                <input type="file" name="file" class="form-control-file" id="logo">
                    <?= $value_logo ?>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                    <h3>Users</h3>
                    <?php
                    if (empty($checked_users_arr)) {
                        foreach ($user as $value) {
                            echo "<input class='users_checkbox' type='checkbox' name='users[]' value='" . $value['id'] . "'/>" . $value['name'] . " <a href='mailto:" . $value['email'] . "'>" . $value['email'] . "</a>
                                        <br>";
                        }
                    } else {
                        foreach ($user as $value) {
                      
                            if (isset($checked_users_arr[$value['id']])) {
                                echo "<input class='users_checkbox' type='checkbox' name='users[]' value='" . $value['id'] . "' checked='checked' />" . $value['name'] . " <a href='mailto:" . $value['email'] . "'>" . $value['email'] . "</a>
                                        <br>";
                            } else {
                                echo "<input class='users_checkbox' type='checkbox' name='users[]' value='" . $value['id'] . "'/>" . $value['name'] . " <a href='mailto:" . $value['email'] . "'>" . $value['email'] . "</a>
                                        <br>";
                            }
                        }
                    
                    }
                    ?>

                       <input class="users_checkbox" type="checkbox" name="users[]" value="{{$value['id']}}"/>{{$value['name']}} <a href="mailto:{{$value['email']}}">({{$value['email']}})</a>
                        <br>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10 buttons_div">
                            <button type="submit" class="btn {{$color}}">{{$button}}</button>
                            <a class="btn btn-warning section_show" href="/public/sections">SHOW SECTIONS</a>
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