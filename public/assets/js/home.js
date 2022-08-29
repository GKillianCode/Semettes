
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
    console.log(events);
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: { center: 'timeGridWeek,dayGrid' },
        initialView:'timeGridWeek',
        header:{
            left:'prev,next,today',
            center :'title',
        },
        allDaySlot: false,
        timeZone: 'UTC',
        
        // events: [
        //     {
        //         extendedProps: {
        //             room : ['salle1','salle2'],
        //             isClickable : true
        //         },
        //         start: '2022-08-23 08:00:00',
        //         end: '2022-08-23 12:00:00'
        //     }
        // ],
        events: events,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        },
        eventClick: function(info) {
            if (info.event.extendedProps.isClickable === true){
                // sectionRoom.classList.toggle("salle_available_toggled")
                // localStorage.setItem('purchasingInfo',JSON.stringify(info.event))

                paneInfo.classList.add('pane-info-open');
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

apiGetAllSlots(drawCalendar);



