function drawCalendar(events){
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
          headerToolbar: { center: 'dayGridMonth,timeGridWeek,dayGrid' },
          initialView:'timeGridWeek',
          header:{
            left:'prev,next,today',
            center :'title',
          },
          timeZone: 'UTC',
          //events: events,
          events: [
                {
                    id: 'a',
                    title: 'my event',
                    extendedProps: {
                        salle : ['salle1','salle2'],
                        isClickable : true
                    },
                    start: '2022-08-23 08:00:00',
                    end: '2022-08-23 12:00:00'
                },
                {
                    id: 'a',
                    title: 'my event',
                    extendedProps: {
                        salle : ['salle2'],
                        isClickable : false
                    },
                    start: '2022-08-23 13:00:00',
                    end: '2022-08-23 17:00:00'
                },
                {
                    id: 'a',
                    title: 'zojfo',
                    extendedProps: {
                        salle : ['salle1','salle2','salle3'],
                        isClickable : true
                    },
                    start: '2022-08-24 13:00:00',
                    end: '2022-08-24 17:00:00'
                }
    
            ],
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
              },
              eventClick: function(info) {
                if (info.event.extendedProps.isClickable === true){
                    sectionRoom.classList.toggle("salle_available_toggled")
                    localStorage.setItem('purchasingInfo',JSON.stringify(info.event))
                    console.log(info.event)
                }
              },
              eventContent: function(info) {
                console.log(info)
                if (info.event._def.extendedProps.isClickable === true){
                    
                    info.backgroundColor='red';
                }
                    let arrayOfDomNodes = []
                    info.event.extendedProps.salle.forEach(e => {
                        let salle = document.createElement('p')
                        salle.innerHTML = e
                        arrayOfDomNodes.push(salle)
                    })
                    return { domNodes: arrayOfDomNodes }    
              }
              
        });
        calendar.render();
      });
    

}

function getAllSlots(onSuccess){
    const request = new XMLHttpRequest();
    let url = 'localhost:8000'
    request.open("GET", url, true);
    request.addEventListener("readystatechange", function (){
        if(request.readyState === XMLHttpRequest.DONE){
            if(request.status === 200){
                response = JSON.parse(request.responseText);
                onSuccess(response);
            } else if(request.status === 400){
                showAlert("Une erreur s'est produite : "+response.error);
            } else {
                showAlert("Une erreur s'est produite : "+response.error);
            }
        }
    })
    request.send();
}
drawCalendar();
//getAllSlots(drawCalendar);



