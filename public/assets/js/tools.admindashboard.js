
if(!localStorage.getItem('basket')){

}
localStorage.setItem('basket','[]');
let pricesArray = document.querySelectorAll(".template-price-recap");

let priceTotal = document.querySelector("#price-total");
function update_basket(){
    let container = document.querySelector("#container-recap");
    let template = document.querySelector("#template-card-recap");
    document.querySelectorAll("#container-recap li").forEach(li=>{
        li.remove();
    });
    basket.forEach(e => {
        let start = new Date(e.slot.start);
        let end = new Date(e.slot.end);
        let room = rooms_bdd.filter(room => room.id == e.room);
        console.log(e.slot.start)
        let clone = template.content.cloneNode(true)
        let image = clone.querySelector(".template-image-recap");
            image.src =  '/assets/imgs/' + room[0].room_image_name
        let roomDom = clone.querySelector(".template-room-recap");
            roomDom.textContent = room[0].room_name
        let capacity = clone.querySelector(".template-capacity-recap");
            capacity.textContent = room[0].max_person + capacity.textContent;
        let date = clone.querySelector(".template-date-recap");
            date.textContent = start.toLocaleDateString()
        let hour = clone.querySelector(".template-hour-recap");
            hour.textContent = start.getHours() + ':' + start.getMinutes() + ' à ' + end.getHours() + ':' + end.getMinutes();
        let price = clone.querySelector(".template-price-recap");
            price.textContent = room[0].rate 
        container.appendChild(clone);
    })
    let pricesArray = document.querySelectorAll(".template-price-recap")
    priceTotal.textContent = "Total : " + Array.from(pricesArray)
        .map(price => parseFloat(price.textContent))
        .reduce((acc,price)=> acc + price)
}

