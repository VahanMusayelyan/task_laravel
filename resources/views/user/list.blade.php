@extends('layouts.app')

@section('content')

<div class="container">
    
  
    
    <table class="table">
        
    

    <?php
    $i = 1;
    foreach ($result as $key => $value) {
        echo "<tr>"
        . "<td>".$value['name']."</td>"
        . "<td>".$value['email']."</td>"
        . "<td>".$value['created_at']."</td>"
        . "</td><td><a class='editlink btn btn-info' href='".url('/users/'.$value['id'])."/edit'>Edit</a>";
        ?>
        <form class="users_form" action="{{route('users.destroy',$value['id'])}}" method='POST' enctype='multipart/form-data'>
                    @csrf
                    @method('DELETE')
    <?php 
        echo "<button type='submit' class='btn btn-danger'>Delete</button></form></td></tr>";
        $i++;
    }
    ?>
        </table>
    {{ $result->links() }}
    
    <a class="btn btn-warning partnerAdd" href="/public/users/create">ADD USERS</a>

</div>

@endsection