
const paneInfo = document.querySelector('.pane-info');
const paneRecap = document.querySelector('.pane-recap');
const paneInfoCloseButton = document.querySelector('.pane-info-close');
const paneRecapOpenButton = document.querySelector('.pane-recap-openButton');

paneInfoCloseButton.addEventListener('click', () => {
    paneInfo.classList.remove('pane-info-open');
});

paneRecapOpenButton.addEventListener('click', () => {
    paneRecap.classList.toggle('pane-recap-open');
});

function drawCalendar(events){

    console.log(events)

    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: { center: 'timeGridWeek,dayGrid' },
        initialView:'timeGridWeek',
        header:{
            left:'prev,next,today',
            center :'title',
        },
        allDaySlot: false,
        minTime: '10:00',
        maxTime: '18:00',
        timeZone: 'UTC',
        
        events: events,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        },
        eventClick: function(info) {
            if (info.event.extendedProps.isClickable === true){
                sectionRoom.classList.toggle("salle_available_toggled")
                localStorage.setItem('purchasingInfo',JSON.stringify(info.event))
            }
        },
        eventContent: function(info) {
            if (info.event._def.extendedProps.isClickable === true){  
                info.backgroundColor='red';
            }
                let arrayOfDomNodes = []
                info.event.extendedProps.room.forEach(e => {
                let room = document.createElement('p')
                room.innerHTML = e
                arrayOfDomNodes.push(room)
            })
                
            return { domNodes: arrayOfDomNodes }    
        }
    });
    calendar.render();
}

function getAllSlots(onSuccess){
    const request = new XMLHttpRequest();
    let url = 'https://localhost:8000/api'
    request.open("GET", url+"/weekslots", true);
    request.addEventListener("readystatechange", function (){
        if(request.readyState === XMLHttpRequest.DONE){
            let response = request;
            if(request.status === 200){
                let res = JSON.parse(request.responseText);
                onSuccess(res);
            } else if(request.status === 400){
                console.error("Une erreur s'est produite : ", response.status);
            } else {
                console.error("Une erreur s'est produite : ", response.status);
            }
        }
    })
    request.send();
}

getAllSlots(drawCalendar);



