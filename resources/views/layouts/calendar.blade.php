<div class="calendar">
    <div class="navigationTools">
        <span class="back"></span>
        <span class="today"></span>
        <span class="forward"></span>
    </div>
    <table class="calendarDays">
        <tr><td>Понедельник</td><td>Вторник</td><td>Среда</td><td>Четверг</td><td>Пятница</td><td>Суббота</td><td>Воскресенье</td></tr>
        @foreach($weeks as $week)
            <tr>
                @foreach($week as $day)
                    <td>
                        <div class="addButton" onclick="createNewTask({{$day->date}})"></div>
                        <div class="dayNum">{{$day->num}}</div>
                        <div class="createButton"></div>
                        <div class="tasks">
                            @foreach($day->tasks as $task)
                                <div class="task" onclick="openCurrentTask({{$task->id}})">
                                    <div class="taskHeader">
                                        <div class="taskType">{{$task->type}}</div>
                                        <div class="taskTime">{{$task->time}}</div>
                                    </div>
                                    <div class="taskContent">
                                        <div class="taskName">{{$task->name}}</div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach

    </table>
</div>
