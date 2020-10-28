window.currentList = 0



async function openTask(event) {

    let taskId = event.target.parentNode.getAttribute('data_id')

    let response = await fetch(`/tasks/${taskId}`, {
            method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }
    )
    if (response.status === 200) {
        let result = await response.json()
        let task = result.data
        document.querySelector('#taskFormContainer h2').innerHTML = "Редактирование"
        if (task) {
            document.querySelector('#taskFormContainer #task_id').value = task.id
            document.querySelector('#taskFormContainer #name').value = task.name
            document.querySelector('#taskFormContainer #type_name').value = task.type.name
            document.querySelector('#taskFormContainer #place').value = task.place
            document.querySelector('#taskFormContainer #date').value = task.date
            document.querySelector('#taskFormContainer #time').value = task.time
            document.querySelector('#taskFormContainer #duration').value = task.duration
            document.querySelector('#taskFormContainer #comment').value = task.comment
        }

    }
    else {
        alert("task Not found")
    }
}


async function onClickDone(event) {
    event.stopPropagation()
    let taskId = event.target.parentNode.parentNode.getAttribute("data_id")
    let body = {
        done: event.target.checked,
        "_token": document.getElementsByName('_token')[0].value
    }
    event.target.disabled= true;
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
        await loadNewTaskList()

    }
    else {
        let result = await response.json()
        console.log(result)
        event.target.checked = !event.target.checked
    }
    event.target.disabled= false
}

async function listTypeEvent(event) {
    let allButtons = document.querySelectorAll('.btn-group-lg button')
    allButtons.forEach((buttonElem) => {
        buttonElem.disabled = true
        buttonElem.classList.remove('active')
    })
    event.target.classList.add('active')
    event.target.disabled = false
    await loadNewTaskList(event.target.getAttribute('dataListType'))
    allButtons.forEach((buttonElem) => {
        buttonElem.disabled = false
    })
}


async function loadNewTaskList(listType = window.currentList) {

    let response = await fetch(`/tasks?TypeList=${listType}`, {
            method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }
    )
    if (response.status === 200) {
        let result = await response.json()
        window.currentList = listType
        let tableBody = document.querySelector('tbody')
        tableBody.innerHTML = ""
        result.data.forEach((task) => {
            let row = document.createElement('tr')
            row.onclick = openTask
            for (let i = 0; i < 7; i++)
                row.append(document.createElement('td'))
            fillRow(row, task)
            let doneElem = document.createElement('td')
            let inputDone = document.createElement('input')
            inputDone.type = 'checkbox'
            inputDone.onclick = onClickDone
            inputDone.checked = task.done
            doneElem.append(inputDone)
            row.append(doneElem)
            tableBody.append(row)
        })
    }
}


