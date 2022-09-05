const paneRoom = document.querySelector(".pane-room-list");
const paneRoomCloseButton = document.querySelector(
    ".pane-room-list-openButton"
);
const leftPaneRoom = document.querySelector(".pane-info");

const roomList = document.querySelector(".rooms-list");

let templateRoomCard = document.querySelector("#room-list-template");

let rooms_bdd = [];

paneRoomCloseButton.addEventListener("click", () => {
    paneRoom.classList.toggle("pane-room-list-open");
});


const editClientInfo = document.querySelector('#edit-client-info')
editClientInfo.addEventListener('click', (ev) => {
    ev.preventDefault()
    let clientDetail = document.querySelectorAll('.client-info')
    editClientInfo.textContent="Save";
    editClientInfo.style.backgroundColor="";
    clientDetail.forEach((elem) => {

        if(!elem.toggleAttribute('readonly')){
            //ev.preventDefault()
            elem.classList.remove("client-info")  
        }
        
    })
}
)


apiGetAllRooms((response) => {
    response.forEach((room) => {
        let clonedTemplate = templateRoomCard.content.cloneNode(true);
        let image = clonedTemplate.querySelector(".room-list-img");
        image.src = "/assets/imgs/" + room.room_image_name;
        let roomName = clonedTemplate.querySelector(".room-list-name");
        roomName.textContent = room.room_name;
        let roomLink = clonedTemplate.querySelector("a");
        roomLink.href = "/admindashboard/" + room.id;

        roomList.appendChild(clonedTemplate);
    });
});

function drawCalendar(events) {
    apiGetAllRooms((rooms) => {
        rooms_bdd = rooms;
        let calendarEl = document.getElementById("calendar");
        let calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: { center: "timeGridWeek" },
            initialView: "timeGridWeek",
            header: {
                left: "prev,next,today",
                center: "title",
            },
            allDaySlot: false,
            timeZone: "local",
            locale: "fr",
            slotMinTime: "08:00:00",
            slotMaxTime: "18:00:00",
            firstDay: 1,
            height: 600,

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
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
                hour12: false,
            },
            eventClick: function (info) {
                if (info.event._def.extendedProps.isClickable == true) {
                    alert("ok");
                }
                leftPaneRoom.classList.add("pane-info-open");
            },
            eventContent: function (info) {
                let arrayOfDomNodes = [];

                if (info.event._def.extendedProps.isClosed === false) {
                    if (info.event._def.extendedProps.isClickable === true) {
                        info.backgroundColor = "#b25f8f";

                        let isClickable = document.createElement("p");
                        isClickable.className = "fermeture";
                        isClickable.innerHTML =
                            'Créneau à réserver <span class="fermeture-smiley">📖</span>';
                        arrayOfDomNodes.push(isClickable);

                    } else {
                        info.backgroundColor = "#efc698";

                        let isClickable = document.createElement("p");
                        isClickable.className = "fermeture booking";
                        isClickable.innerHTML =
                            'Créneau réservé <span class="fermeture-smiley">📕</span>';
                        arrayOfDomNodes.push(isClickable);
                    }
                } else {
                    info.backgroundColor = "#272e3f";

                    let isClosed = document.createElement("p");
                    isClosed.className = "fermeture";
                    isClosed.innerHTML =
                        'Fermeture exceptionnelle <span class="fermeture-smiley">🥲</span>';
                    arrayOfDomNodes.push(isClosed);
                }

                return { domNodes: arrayOfDomNodes };
            },
        });
        calendar.render();
    });
}

apiGetAllSlotsByRoom(3, drawCalendar);



