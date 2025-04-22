@extends('master')
@section('content')
<div class="container mt-5 ">
    <div class="header-box d-flex justify-content-between mb-3">
        <h4>Update Task</h4>
        <div>
            <a href="{{route('tasks.index')}}"> <button>View All Tasks</button></a>

        </div>

    </div>
    <div class="form-box">
        <form method="POST" action="{{route('tasks.update',$task)}}" class="edit-task">
            @method('PATCH')
            @csrf
            <div class="item mb-4">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $task->name) }}" />
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
                <input type="number" class="form-control" name="priority" min="1"
                    value="{{ old('priority', $task->priority) }}" />
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
                <select name="project" class="form-control">
                    <option name="project" value="" disabled>Select Project</option>
                    @foreach($projects as $project)
                    <option name="project" value="{{$project->id}}"
                        {{ $task->project_id === $project->id ? 'selected' : '' }}>{{$project->name}}</option>
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
                <button type="submit">Update</button>
            </div>
        </form>
    </div>


</div>
@endsection