@extends('layouts.app')

@section('content')

<div class="container">
    
  
    
    <table class="table">
        
    

    <?php
    $i = 1;
    foreach ($result as $key => $value) {
        echo "<tr>"
        . "<td><img src='storage/".$value['logo']."' class='section_list_logo'></td>"
        . "<td>" . $value['name'] . "<br>".substr($value['description'],0,20) ."</td>"
        . "<td><b>Users</b><br>";

        foreach ($value->users as $user) {
                echo $user->name." <br>";
            }
        echo "</td><td><a class='editlink btn btn-info' href='".url('/sections/'.$value['id'])."/edit'>Edit</a>";
        ?>
        <form class="section_form" action="{{route('sections.destroy',$value['id'])}}" method='POST' enctype='multipart/form-data'>
                    @csrf
                    @method('DELETE')
    <?php 
        echo "<button type='submit' class='btn btn-danger'>Delete</button></form></td></tr>";
        $i++;
    }
    ?>
        </table>
    {{ $result->links() }}
    
    <a class="btn btn-warning partnerAdd" href="/public/sections/create">ADD SECTION</a>

</div>

@endsection