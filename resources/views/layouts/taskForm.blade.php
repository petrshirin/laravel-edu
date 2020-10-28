<div class="col-sm" id="taskFormContainer">
    <h2>Создание</h2>

    <button type="button" class="btn btn-primary" onclick="newTask()">Новое задание</button>
    <form class="mb-3" id="taskForm">
        @csrf
        <div class='errorsContainer' role='alert'></div>
        <label for="id">
            <input class="form-control" type="number" hidden id="task_id">
        </label>
        <label for="name">
            Название задания:
            <input class="form-control" type="text" id="name" value="">
        </label>
        <label for="type">
            Тема:
            <select class="form-control" id="type_name">
                @foreach($taskTypes as $taskType)
                    <option>{{$taskType->name}}</option>
                @endforeach
            </select>
        </label>
        <label for="place">
            Место:
            <input class="form-control" type="text" id="place" value="">
        </label>
        <label for="date">
            Дата:
            <input class="form-control" type="date" id="date" value="">
        </label>
        <label for="time">
            Время:
            <input class="form-control" type="time" id="time" value="">
        </label>
        <label for="duration">
            Длительность:
            <input class="form-control" type="time" id="duration" value="">
        </label>
        <label for="comment">
            Комментарий:
            <textarea class="form-control" type="text" id="comment"></textarea>
        </label>
        <button class="btn btn-primary" onclick="saveTask()" type="button">Сохранить задание</button>
    </form>
</div>
