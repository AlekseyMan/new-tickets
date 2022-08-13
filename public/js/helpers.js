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
    let sendData = event.replace('0', document.getElementById(event).dataset.ticketid)
    const token = document.getElementById('token').dataset.token

    let response = await fetch('/mark-visit', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            data: sendData,
            _token: token
        }),
    });
    let res = await response.json()

    if (res.btnType === "visit") {
        document.getElementById(event).className = "btn btn-success"
        document.getElementById(event.replace('visit', 'miss')).className = "btn"
        document.getElementById(event.replace('visit', 'count')).innerText = res.visits_number
    } else {
        document.getElementById(event).className = "btn btn-danger"
        document.getElementById(event.replace('miss', 'visit')).className = "btn"
        document.getElementById(event.replace('miss', 'count')).innerText = res.visits_number
    }

    if (res.isClosed === 1) {
        alert("У " + res.userName + " закончился абонемент. Обновите страницу, чтобы завести новый абонемент.")
        document.getElementById(event.replace(res.btnType, 'count')).classList.add("bg-danger")
        document.getElementById("ticketDateid=" + res.userId).classList.add("bg-danger")
        document.getElementById("ticketDateid=" + res.userId).innerText = "Абонемент закончился"
    }

}

async function addKaratekaToGroup() {
    const token = document.getElementById('token').dataset.token
    const id = document.getElementById('selectKarateka').value
    const group_id = location.pathname.split('/').pop()
    let response = await fetch('/add-to-group', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            group_id: group_id,
            profile_id: id,
            _token: token
        }),
    });
    let res = await response.json()

    let bg = ""
    if (res.profile.balance < 0) {
        bg = "bg-danger"
    } else {
        bg = "bg-success"
    }

    let ticketId = 0
    let visits = 0
    let abonementDate = 'Нет абонемента'
    if (res.profile.ticket !== null) {
        ticketId = res.profile.ticket.id
        visits = res.profile.ticket.visits_number
        abonementDate = res.profile.ticket.end_date
    }

    let elem = document.createElement("tr");
    elem.id = "trUserId=" + res.profile.id
    elem.className = "text-center"
    elem.innerHTML = '<td><button type="button" class="btn-danger" data-bs-toggle="modal" data-bs-target="#removeFromGroup"' +
        ' onclick="addDataToModal(' + res.profile.id + ', \'remove\')">X</button></td>' +
        '<td class="' + bg + '" id="userNameId=' + res.profile.id + '">' + res.profile.surname + ' ' + res.profile.name + '</td>' +
        '<td>' +
        '<button data-ticketid="' + ticketId + '" class="btn"' +
        ' onclick="markVisit(\'visit-'+ res.profile.id +'-' + ticketId + '\')" id="visit-'+ res.profile.id +'-' + ticketId + '">' +
        'Посетил' +
        '</button>' +
        '</td>' +
        '<td>' +
        '<button data-ticketid="' + ticketId + '" class="btn"' +
        ' onclick="markVisit(\'miss-'+ res.profile.id +'-' + ticketId + '\')" id="miss-'+ res.profile.id +'-' + ticketId + '">' +
        'Пропустил' +
        '</button>' +
        '</td>' +
        '<td class="' + bg +'" id="userBalanceId='+ res.profile.id +'">' +
        '<b id="userId='+ res.profile.id +'">'+ res.profile.balance +'</b>' +
        '<button type="button" class="btn btn-light ms-2" data-bs-toggle="modal" data-bs-target="#addBalance"' +
        ' onclick="addDataToModal ('+ res.profile + ', \'balance\')">+</button>' +
        '</td>' +
        '<td id="count-'+ res.profile.id +'-' + ticketId + '">' + visits + '</td>' +
        '<td class="text-center"' +
        ' id="ticketDateid='+ res.profile.id +'">' + abonementDate + '</td>' +
        '<td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAbonement"' +
        ' onclick="addDataToModal('+ res.profile + ', \'abonement\')">+</button></td>'

    document.getElementById("tbody").insertAdjacentElement('beforeend', elem)
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
            break;
        case 'abonement':
            obj = document.getElementById('addAbonementLabel')
            headerText = 'Открыть новый абонемент для: ' + fio
            break;
        case 'remove':
            obj = document.getElementById('removeFromGroupLabel')
            headerText = 'Подтверждаете удаление из группы ' + fio
    }

    obj.innerText = headerText
    obj.dataset.userid = id
}


async function addBalance() {
    const token = document.getElementById('token').dataset.token
    const amount = document.getElementById('balance-input').value
    const id = document.getElementById('addBalanceLabel').dataset.userid
    let response = await fetch('/add-amount', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            amount: amount,
            id: id,
            _token: token
        }),
    });
    let res = await response.json()

    document.getElementById("userId=" + res.userId).innerText = res.balance
    backgrounds(res.userId, res.balance)
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

async function removeFromGroup() {
    const token = document.getElementById('token').dataset.token
    const id = document.getElementById('removeFromGroupLabel').dataset.userid
    const groupId = location.pathname.split('/')[2]
    let response = await fetch('/remove-from-group', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json'
        }),
        body: JSON.stringify({
            id: id,
            groupId: groupId,
            _token: token
        }),
    });
    let res = await response.json()

    document.getElementById("trUserId=" + id).classList.add("d-none")
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
