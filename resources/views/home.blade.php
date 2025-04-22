@extends('master')
@section('content')
<div class="container text-center mt-5 ">
    <div class="header-box d-flex justify-content-around">
        <h1>Tasks List</h1>
        <div>
            <a href="{{route('tasks.create')}}"><button class="btn btn-primary">Create New Task</button></a>
            <select name="project">
            <option disabled selected>Select Project</option>
            @foreach($projects as $project)
            <option value="{{$project->id}}">{{$project->name}}</option>
            @endforeach
        </select>
        </div>
        
    </div>
    <table class="table table-responsive">
    <thead>
        <tr>
            <th>S.N.</th>
            <th>Name</th>
            <th>Priority</th>
            <th>Project</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="task-list">
    @foreach($tasks as $index=>$task)
        <tr draggable="true" data-id="{{$task->id}}" class="tasks">
                <td>{{$index+1}}</th>
                <td>{{$task->name}}</th>
                <td class="task-priority">{{$task->priority}}</th>
                <td>{{$task->project->name}}</th>
                <td class="d-flex justify-content-evenly">
                    <a href="{{route('tasks.edit',$task)}}" class=" mr-3"><button class="btn btn-secondary">Edit</button></a>
                    <form method="POST" action="{{route('tasks.delete',$task)}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')"  class="btn btn-danger">Delete</button>
                    </form>
                </td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script>
    const list = document.querySelector('tbody.task-list');
    let draggingItem = null;

    list.addEventListener('dragstart', (e) => {
        draggingItem = e.target;
        e.target.classList.add('dragging');
    });

    list.addEventListener('dragend', (e) => {
        e.target.classList.remove('dragging');
        document.querySelectorAll('tbody.task-list').forEach(item => item.classList.remove('over'));
        draggingItem = null;

        let order = [...document.querySelectorAll('tr.tasks')].map(tr => tr.getAttribute('data-id'));
        
        fetch('/update'){

        }
        console.log(order);
    });

    list.addEventListener('dragover', (e) => {
        e.preventDefault();
        const draggingOverItem = getDragAfterElement(list, e.clientY);

        // Remove .over from all items
        document.querySelectorAll('tbody.task-list').forEach(item => item.classList.remove('over'));

        if (draggingOverItem) {
        draggingOverItem.classList.add('over'); // Add .over to the hovered item
        list.insertBefore(draggingItem, draggingOverItem);
        } else {
        list.appendChild(draggingItem); // Append to the end if no item below
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('tr:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }


</script>
@endsection