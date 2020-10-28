
async function saveTask() {
    document.getElementsByClassName('errorsContainer')[0].innerHTML = "";

    if (document.querySelector('#taskFormContainer #task_id').value) {
        return updateTask()
    }

    let body = {
        "name": document.querySelector('#taskFormContainer #name').value,
        "type_name": document.querySelector('#taskFormContainer #type_name').value,
        "place": document.querySelector('#taskFormContainer #place').value,
        "date": document.querySelector('#taskFormContainer #date').value,
        "time": document.querySelector('#taskFormContainer #time').value,
        "duration": document.querySelector('#taskFormContainer #duration').value,
        "comment": document.querySelector('#taskFormContainer #comment').value,
        "_token": document.getElementsByName('_token')[0].value
    }

    let response = await fetch("/tasks/", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        }
    )
    if (response.status === 201) {
        await loadNewTaskList()
        document.querySelector('#taskFormContainer #task_id').value = ""
        //elem = document.createElement('tr')
        //for (let i = 0; i < 7; i++) {
        //    elem.innerHTML += document.createElement('td')
        //}
        //elem.innerHTML += '<td><label for="done"></label> <input id="done" type="checkbox" onclick="onClickDone(event)"></td>'
        //fillRow(elem, result)
        //console.log(elem)
        //document.querySelector('tbody').append(elem)
    }
    else if (response.status === 422) {
        let result = await response.json()
        printErrors(result)
    }

}


function printErrors(error_obj) {
        let container = document.getElementsByClassName('errorsContainer')[0];
        let errors = document.createElement('div');
        errors.classList.add('alert');
        errors.classList.add('alert-danger');
        Object.keys(error_obj.errors).map((errorName) => {
            errors.innerHTML += `<p>${errorName}: ${error_obj.errors[errorName]}\n</p>`
        })

        container.append(errors)

}

function newTask() {
    document.querySelector('#taskFormContainer h2').innerHTML = "Создание"
    document.querySelector('#taskFormContainer #task_id').value = 0
    document.querySelector('#taskFormContainer #name').value = ""
    document.querySelector('#taskFormContainer #type_name').value = ""
    document.querySelector('#taskFormContainer #place').value = ""
    document.querySelector('#taskFormContainer #date').value = ""
    document.querySelector('#taskFormContainer #time').value = ""
    document.querySelector('#taskFormContainer #duration').value = ""
    document.querySelector('#taskFormContainer #comment').value = ""
}



async function updateTask() {
    document.getElementsByClassName('errorsContainer')[0].innerHTML = "";

    let taskId = document.querySelector('#taskFormContainer #task_id').value

    let body = {
        "name": document.querySelector('#taskFormContainer #name').value,
        "type_name": document.querySelector('#taskFormContainer #type_name').value,
        "place": document.querySelector('#taskFormContainer #place').value,
        "date": document.querySelector('#taskFormContainer #date').value,
        "time": document.querySelector('#taskFormContainer #time').value,
        "duration": document.querySelector('#taskFormContainer #duration').value,
        "comment": document.querySelector('#taskFormContainer #comment').value,
        "_token": document.getElementsByName('_token')[0].value
    }

    let response = await fetch(`/tasks/${taskId}`, {
            method: "PUT",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        }
    )
    if (response.status === 201) {
        let result = await response.json()
        await loadNewTaskList()
        document.querySelector('#taskFormContainer #task_id').value = result.body.id
        document.querySelector('#taskFormContainer #name').value = result.body.name
        document.querySelector('#taskFormContainer #type_name').value = result.body.type.name
        document.querySelector('#taskFormContainer #place').value = result.body.place
        document.querySelector('#taskFormContainer #date').value = result.body.date
        document.querySelector('#taskFormContainer #time').value = result.body.time
        document.querySelector('#taskFormContainer #duration').value = result.body.duration
        document.querySelector('#taskFormContainer #comment').value = result.body.comment


    } else if (response.status === 422) {
        let result = await response.json()
        printErrors(result)
    }
}


function formatDate(date) {

    let dd = date.getDate()
    if (dd < 10) dd = '0' + dd

    let  mm = date.getMonth() + 1
    if (mm < 10) mm = '0' + mm

    let  yy = date.getFullYear()
    return dd + '.' + mm + '.' + yy
}

function fillRow(elem, data) {
    let cols = elem.querySelectorAll('td')
    elem.setAttribute('data_id', data.id)
    cols[0].innerText = data.name
    cols[1].innerText = data.type.name
    cols[2].innerText = data.place
    cols[3].innerText = formatDate(new Date(Date.parse(data.date)))
    cols[4].innerText = data.time
    cols[5].innerText = data.duration
    cols[6].innerText = data.comment
}
