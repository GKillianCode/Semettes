
const paneInfo = document.querySelector('.pane-info');
const paneRecap = document.querySelector('.pane-recap');
const paneInfoCloseButton = document.querySelector('.pane-info-close');
const paneRecapOpenButton = document.querySelector('.pane-recap-openButton');
let rooms_bdd =[];


paneInfoCloseButton.addEventListener('click', () => {
    paneInfo.classList.remove('pane-info-open');
});

paneRecapOpenButton.addEventListener('click', () => {
    paneRecap.classList.toggle('pane-recap-open');
    paneInfo.classList.remove('pane-info-open');
});

function drawCalendar(events){
        apiGetAllRooms((rooms)=>{
            rooms_bdd = rooms;
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
            //             room : [1, 2, 3],
            //             isClickable : true,
            //             isClosed : false,
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

                const slot = document.querySelector('.display-date')
                .textContent = (new Date(Date.parse(info.event.startStr.substr(0, 10))).toLocaleDateString());

                if (info.event.extendedProps.isClosed === false){
                    if (info.event.extendedProps.isClickable === true){
                        localStorage.setItem('purchasingInfo',JSON.stringify(info.event))
                        let container = document.querySelector("#roomcontainer");
                        let template = document.querySelector("#card-template");
                        document.querySelectorAll("#container li").forEach(li=>{
                            li.remove();
                        });
                        rooms.forEach(e => {
                            if(Object.values(info.event._def.extendedProps.room).includes(e.id)){
                                let clone = template.content.cloneNode(true);
                                let element = clone.querySelector(".pane-info-room");
                                element.id = "room-"+e.id;
                                let image = clone.querySelector(".template-image");
                                image.src =  '/assets/imgs/' + e.room_image_name;
                                let roomName = clone.querySelector(".template-room-name");
                                roomName.textContent = e.room_name;
                                let description = clone.querySelector(".template-description");
                                description.textContent = e.room_description;
                                let maxperson = clone.querySelector(".room-max-person");
                                maxperson.textContent = e.max_person + ' personnes maximum';
                                let rate = clone.querySelector(".room-rate");
                                rate.textContent= 'Tarif : ' + e.rate + ' €';
                                let btnValidOneRoom = clone.querySelector(".template-btnValidOneRoom");
                                    btnValidOneRoom.id = e.id;
                                container.appendChild(clone);
                            }
                        })
                        let btnBookRoom = document.querySelectorAll('.template-btnValidOneRoom')
                        btnBookRoom.forEach(btn=>{
                            btn.addEventListener('click',ev=>{
                                dataSlot = JSON.parse(localStorage.getItem('purchasingInfo'))
                                if (!localStorage.getItem('basket')){
                                    localStorage.setItem('basket','[]');
                                }
                                let basket = JSON.parse(localStorage.getItem('basket'))
                                let basketTemp = {
                                    'slot' : dataSlot,
                                    'room' : btn.id
                                }
                                console.log(basketTemp.slot.end)
                                if (!basket.map(el=>JSON.stringify(el)).includes(JSON.stringify(basketTemp))){
                                    basket.push(basketTemp)
                                }else{
                                    basket.splice(basket.map(el=>JSON.stringify(el)).findIndex(el => (el === JSON.stringify(basketTemp))),1);
                                    console.log(basket)
                                }
                                localStorage.setItem('basket',JSON.stringify(basket));
                                update_basket();   
                        });
                    });

                    paneInfo.classList.remove('pane-info-open');
                    setTimeout(() => {
                        paneInfo.classList.add('pane-info-open')
                    }, 200);
                    paneRecap.classList.remove('pane-recap-open');
                    }   
                }
                    
            },
            eventContent: function(info) {
                let arrayOfDomNodes = []

                if(info.event._def.extendedProps.isClosed === false){
                    if (info.event._def.extendedProps.isClickable === true){  
                        info.backgroundColor='#b25f8f';
                    } else {
                        info.backgroundColor='#9c425e';
                    }

                    rooms.forEach(e => {
                        if(Object.values(info.event._def.extendedProps.room).includes(e.id)){
                            let room = document.createElement('a');
                            room.href = "#room-"+e.id;
                            room.className = "room-link bg-sPink";
                            room.textContent = e.room_name;
                            arrayOfDomNodes.push(room);
                        }
                    });
                } else {
                    info.backgroundColor='#272e3f';

                    let isClosed = document.createElement('p');
                    isClosed.className = 'fermeture';
                    isClosed.innerHTML = 'Fermeture exceptionnelle <span class="fermeture-smiley">🥲</span>';
                    arrayOfDomNodes.push(isClosed);
                }

                console.log(arrayOfDomNodes);
                    
                return { domNodes: arrayOfDomNodes }    
            }
        });
    calendar.render();
    });
};

apiGetAllSlots(drawCalendar);