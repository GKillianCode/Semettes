

const url = "/api";

const apiGetAllSlots = (onSuccess) => {
    const request = new XMLHttpRequest();
    let url = 'https://localhost:8000/api'
    request.open("GET", url+"/weekslots", true);
    request.addEventListener("readystatechange", function (){
        if(request.readyState === XMLHttpRequest.DONE){
            let response = request;
            if(request.status === 200){
                let res = JSON.parse(request.responseText);
                setTimeout(onSuccess(res), 5000);
            } else if(request.status === 400){
                console.error("Une erreur s'est produite : ", response.status);
            } else {
                console.error("Une erreur s'est produite : ", response.status);
            }
        }
    })
    request.send();
}

const apiGetAllSlotsByRoom = (roomId, onSuccess) => {
    const request = new XMLHttpRequest();
    let url = 'https://localhost:8000/api';
    request.open("GET", url+"/weekslots/"+roomId, true);
    request.addEventListener("readystatechange", function (){
        if(request.readyState === XMLHttpRequest.DONE){
            let response = request;
            if(request.status === 200){
                let res = JSON.parse(request.responseText);
                onSuccess(res)
            } else if(request.status === 400){
                console.error("Une erreur s'est produite : ", response.status);
            } else {
                console.error("Une erreur s'est produite : ", response.status);
            }
        }
    })
    request.send();
}

const apiGetAllRooms = (onSuccess) => {
    const request = new XMLHttpRequest();
    let url = 'https://localhost:8000/api'
    request.open("GET", url+"/rooms", true);
    request.addEventListener("readystatechange", function (){
        if(request.readyState === XMLHttpRequest.DONE){
            let response = request;
            if(request.status === 200){
                let res = JSON.parse(request.responseText);
                onSuccess(res)
            } else if(request.status === 400){
                console.error("Une erreur s'est produite : ", response.status);
            } else {
                console.error("Une erreur s'est produite : ", response.status);
            }
        }
    })
    request.send();
}

const apiPostAdminBooking = (id, firstname, name, tel, email, slotData, onSuccess, onError) => {
    const request = new XMLHttpRequest();
    let url = 'https://localhost:8000/'
    request.open("POST", url+"admindashboard/"+id+"/addbooking", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", function (){
        if(request.readyState === XMLHttpRequest.DONE){
            let response = request;
            if(request.status === 200){
                console.log(response.responseText)
            } else {
                console.log(request.statusText);
            }
        }
    });

    request.send(`firstname=${encodeURIComponent(firstname)}&name=${encodeURIComponent(name)}&tel=${encodeURIComponent(tel)}&email=${encodeURIComponent(email)}&slot=${encodeURIComponent(slotData)}`);
}
