<div class="col-sm">
    <div class="flex-xl-row">
        <h2 id="listHeader" class="flex">{{$listHeader}}</h2>
    </div>
    <div class="btn-group-lg">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-outline-secondary active" onclick="listTypeEvent(event)" dataListType="0">Все задания</button>
            <button type="button" class="btn btn-outline-secondary" onclick="listTypeEvent(event)" dataListType="1">Текущие задания</button>
            <button type="button" class="btn btn-outline-secondary" onclick="listTypeEvent(event)" dataListType="2">Выполненные задания</button>
            <button type="button" class="btn btn-outline-secondary" onclick="listTypeEvent(event)" dataListType="3">Просроченные задания</button>
        </div>
    </div>


    <table class="table">
        <thead class="thead-dark">
            <tr>
                <td scope="col">Имя</td>
                <td scope="col">Тип встречи</td>
                <td scope="col">Место</td>
                <td scope="col">Дата</td>
                <td scope="col">Время</td>
                <td scope="col">Длительность</td>
                <td scope="col">Комментарий</td>
                <td scope="col">Выполнено</td>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr onclick="openTask(event)" data_id="{{$task->id}}">
                <td scope="col">{{$task->name}}</td>
                <td scope="col">{{$task->type->name}}</td>
                <td scope="col">{{$task->place}}</td>
                <td scope="col">{{$task->date->format("d.m.Y")}}</td>
                <td scope="col">{{$task->time->format("H:i")}}</td>
                <td scope="col">{{$task->duration->format("H:i")}}</td>
                <td scope="col">{{$task->comment}}</td>
                <td scope="col"><label for="done"></label> <input id="done" type="checkbox" @if ($task->done) checked @endif onclick="onClickDone(event)"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
