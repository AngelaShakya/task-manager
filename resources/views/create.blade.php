@extends('master')
@section('content')
<div class="container mt-5 ">
    <div class="header-box d-flex justify-content-between mb-3">
        <h4>Create Task</h4>
        <div>
            <a href="{{route('tasks.index')}}"> <button>View All Tasks</button></a>

        </div>

    </div>
    <div class="form-box">
        <form method="POST" action="{{route('tasks.store')}}" class="add-task">
            @csrf
            <div class="item mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{old('name')}}" />
                <small class="text-danger">
                    <i>
                        @if ($errors->has('name'))
                        {{ $errors->first('name') }}
                        @endif
                    </i>
                </small>

            </div>
            <div class="item mb-4">
                <label>Priority</label>
                <input type="number" class="form-control" name="priority" min="1" value="{{old('priority',1)}}" />
                <small class="text-danger">
                    <i>
                        @if ($errors->has('priority'))
                        {{ $errors->first('priority') }}
                        @endif
                    </i>
                </small>
            </div>
            <div class="item mb-4">
                <label>Project</label>
                <select name="project" class="form-control" value="{{old('project')}}">
                    <option name="project" value="" disabled selected>Select Project</option>
                    @foreach($projects as $project)
                    <option name="project" value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>
                <small class="text-danger">
                    <i>
                        @if ($errors->has('project'))
                        {{ $errors->first('project') }}
                        @endif
                    </i>
                </small>
            </div>
            <div class="item mb-4 text-center">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>


</div>
@endsection