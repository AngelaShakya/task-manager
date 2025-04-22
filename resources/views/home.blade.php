@extends('master')
@section('content')
<div class="container text-center mt-5 ">
    <div class="header-box d-sm-flex justify-content-between">
        <h4>Tasks List</h4>
        <div class="d-flex align-items-center">
            <a href="{{route('tasks.create')}}"><button>Create New Task</button></a>
            <form method="GET" action="{{route('tasks.index')}}">
                <select name="project" id="project-filter" onchange="this.form.submit()">
                    <option disabled selected name="project">Select Project</option>
                    @foreach($projects as $project)
                    <option value="{{$project->id}}" name="project"
                        {{ isset($selected) && $selected->id === $project->id ? 'selected' : '' }}>
                        {{$project->name}}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>

    </div>
    <div class="table-responsive">
        <table class="table ">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Priority</th>
                    <th>Project</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class=" task-list">
                @if($tasks->count() > 0)
                @foreach($tasks as $index=>$task)
                <tr draggable="true" data-id="{{$task->id}}" class="tasks">
                    <td>{{$index+1}}</th>
                    <td>{{$task->name}}</th>
                    <td class="task-priority">#{{$task->priority}}</th>
                    <td>{{$task->project->name}}</th>
                    <td class="d-sm-flex justify-content-evenly">
                        <a href="{{route('tasks.edit',$task)}}"><button class="btn btn-secondary mb-2">Edit</button></a>
                        <form method="POST" action="{{route('tasks.delete',$task)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')"
                                class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-danger"><b>No Tasks Found</b></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection
@section('scripts')
<script>
// Drag and drop to update priority
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

    let order = [...document.querySelectorAll('tr.tasks')].map(function(tr, index) {
        var priorityItems = tr.getElementsByClassName("task-priority");
        // console.log(priorityItems);
        if (priorityItems.length > 0) {
            for (i = 0; i < priorityItems.length; i++) {
                // console.log(priorityItems[i]);
                priority = index + 1;
                priorityItems[i].innerHTML = "#" + priority;
            }
        }
        return tr.getAttribute('data-id');
    });
    // console.log(order);
    $.ajax({
        url: "{{url('update-priority')}}",
        method: "POST",
        data: {
            order: order,
            _token: "{{csrf_token()}}",
        },
        success: function(data) {
            console.log(data);
        }
    });

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
            return {
                offset: offset,
                element: child
            };
        } else {
            return closest;
        }
    }, {
        offset: Number.NEGATIVE_INFINITY
    }).element;
}
</script>

@endsection