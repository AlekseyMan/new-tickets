function goTo(event) {
    location.href = event;
}

function checkBoxChecking(id) {
    if (document.querySelectorAll('input[type=checkbox]:checked').length > 0) {
        document.getElementById(id).click()
    } else {
        alert("Необходимо выбрать хотябы одно значение")
    }
}

async function markVisit(event) {
    if (document.getElementById(event).dataset.ticketid === "0") {
        return alert("Необходимо завести/обновить абонемент")
    }
    let visited = 1
    if (event.substr(0, 4) == "miss") {
        visited = 0
    }

    const token = document.getElementById('token').dataset.token
    let visit_date = document.getElementById("visit-date").value;
    let coach_id = document.getElementById("coach_id").value;

    let response = await fetch('/visit', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            return_json : 1,
            visited     : visited,
            date        : visit_date,
            coach_id    : coach_id,
            ticket_id   : event.split('-')[2],
            _token      : token
        }),
    });
    let res = await response.json()
    if (visited === 1) {
        document.getElementById(event).className = "btn btn-success"
        document.getElementById(event.replace('visit', 'miss')).className = "btn"
        document.getElementById(event.replace('visit', 'count')).innerText = res.visits_number
    } else {
        document.getElementById(event).className = "btn btn-danger"
        document.getElementById(event.replace('miss', 'visit')).className = "btn"
        document.getElementById(event.replace('miss', 'count')).innerText = res.visits_number
    }
    if (res.is_closed == true) {
        alert("У " + res.userName + " закончился абонемент.")
        document.getElementById(event.replace(res.btnType, 'count')).classList.add("bg-secondary")
        document.getElementById("ticketDateid=" + res.userId).classList.add("bg-secondary")
        document.getElementById("ticketDateid=" + res.userId).innerText = "Абонемент закончился"
    }
}

function addDataToModal(id, type) {
    let obj = {};
    let headerText = '';
    let fio = document.getElementById("userNameId=" + id).innerText
    switch (type) {
        case 'balance':
            document.getElementById('balance-input').value = ''
            obj = document.getElementById('addBalanceLabel')
            headerText = 'Добавить оплату для: ' + fio
            document.getElementById('update-balance').action = "/balance/" + id + "/update"
            break;
        case 'abonement':
            obj = document.getElementById('addAbonementLabel')
            headerText = 'Открыть новый абонемент для: ' + fio
            document.getElementById('add-abonement').action = "/balance/" + id + "/new-ticket"
            break;
        case 'remove':
            obj = document.getElementById('removeFromGroupLabel')
            headerText = 'Подтверждаете удаление из группы ' + fio
            document.getElementById("remove-user-id").value = id
    }

    obj.innerText = headerText
    obj.dataset.userid = id
}

async function addTicket() {
    const token = document.getElementById('token').dataset.token
    const id = document.getElementById('addAbonementLabel').dataset.userid
    let response = await fetch('/add-ticket', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            id: id,
            _token: token
        }),
    });
    let res = await response.json()

    document.getElementById("userId=" + res.userId).innerText = res.balance
    document.getElementById('ticketDateid=' + res.userId).innerText = res.date
    document.getElementById("visit-" + res.userId + "-0").dataset.ticketid = res.ticket.id
    document.getElementById("miss-" + res.userId + "-0").dataset.ticketid = res.ticket.id
    document.getElementById("button-" + res.userId + "-0").classList.add("d-none")
    backgrounds(res.userId, res.balance)
}

function backgrounds(id, balance) {
    if (balance < 0) {
        document.getElementById("userNameId=" + id).className = "bg-danger"
        document.getElementById("userBalanceId=" + id).className = "bg-danger"
    } else {
        document.getElementById("userNameId=" + id).className = ""
        document.getElementById("userBalanceId=" + id).className = "bg-success"
    }
}

async function newKarateka() {
    const token = document.getElementById('token').dataset.token
    const name = document.getElementById('name').value
    const surname = document.getElementById('surname').value
    let response = await fetch('/karateki/add-new', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            name: name,
            surname: surname,
            _token: token
        }),
    });
    let res = await response.json()

    let elem = document.createElement("tr");
    elem.className = "col-xl-3 text-center"
    elem.innerHTML = '<td>' +
        '<h3>' + res.surname + ' ' + res.name + '</h3>' +
        '</td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>'

    document.getElementById("tbody").insertAdjacentElement('beforeend', elem)
    document.getElementById('name').value = ''
    document.getElementById('surname').value = ''
}

function teamEdit(id) {
    document.getElementById("input-number-" + id).classList.remove("d-none")
    document.getElementById("input-name-" + id).classList.remove("d-none")
    document.getElementById("button-save-" + id).classList.remove("d-none")
    document.getElementById("button-cancel-" + id).classList.remove("d-none")
    document.getElementById("text-number-" + id).classList.add("d-none")
    document.getElementById("text-name-" + id).classList.add("d-none")
    document.getElementById("button-edit-" + id).classList.add("d-none")

    document.getElementById("button-cancel-" + id).addEventListener('click', () => {
        document.getElementById("input-number-" + id).classList.add("d-none")
        document.getElementById("input-name-" + id).classList.add("d-none")
        document.getElementById("button-save-" + id).classList.add("d-none")
        document.getElementById("button-cancel-" + id).classList.add("d-none")
        document.getElementById("text-number-" + id).classList.remove("d-none")
        document.getElementById("text-name-" + id).classList.remove("d-none")
        document.getElementById("button-edit-" + id).classList.remove("d-none")

        document.getElementById("button-cancel-" + id).removeEventListener('click', () => {
        })
    })
}


async function groupOnPause(id, date){
    const token = document.getElementById('token').dataset.token
    let response = await fetch('/group/'+id+'/on_pause', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            date:   date,
            _token: token
        }),
    });
    let res = await response.json()
    alert(res.message)
}
