
const roomList = document.querySelector('.rooms');

apiGetAllRooms((response) => {
    response.forEach(room => {
        console.log(room);
        const el = {
            'item' : document.createElement('li'),
            'link' : document.createElement('a')
        }
        el.link.textContent = room.room_name;
        el.link.href="/admindashboard/"+room.id;
        el.item.appendChild(el.link);
        el.link.classList = "text-decoration-none text-white";
        el.item.classList = "p-2 bg-sSalmon rounded-2";
        roomList.appendChild(el.item);
    });
})