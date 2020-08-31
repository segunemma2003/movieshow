@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        @include('layouts.sidebar')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Movies') }}</div>

                <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Movie Name</th>
                        <th scope="col">Cinema</th>
                        <th scope="col">Show time</th>
                       
                        <th scope="col">Date</th>
                        <!-- <th scope="col">Added</th> -->
                        
                        <th scope="col" class="text-center">Action</th>
                     

                        </tr>
                    </thead>
                    <tbody>
                    @if(count($shows)< 1)
                    <tr>
                    No Movies Yet
                    </tr>
                    @else
                        @foreach($shows as $show)
                            @if(count($show->movies) < 1)
                            <tr>
                            No show
                            </tr>
                            @else
                                @foreach($show->movies as $move)
                            <tr>
                                <td>{{$move->pivot->id}}</td>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$move->name}}</td>
                                <td>{{$show->name}}</td>
                                <td>{{$move->pivot->time}}</td>
                                <td>{{$move->pivot->date}}</td>
                                <!-- <td>{{$move->created_at->diffForHumans()}}</td> -->
                                <td><a href="{{route('show.edit',[$move->id,$show->id])}}" class="btn btn-primary">Edit</a>||<a href="{{route('show.delete',[$move->id,$show->id])}}" class="btn btn-danger">Delete</a></td>
                            </tr>
                                @endforeach
                            @endif    
                    
                        @endforeach
                    @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
