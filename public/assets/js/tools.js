//let btnDetails = document.querySelectorAll('.btnDetails')
//let btnBookRoom = document.querySelectorAll('.btnBookRoom')
//let btnQuitRoomSelection = document.querySelector('#btnQuitRoomSelection')
//let btnValidRoomSelection = document.querySelector('#btnValidRoomSelection')
//let sectionRoom = document.querySelector('#salle_available')
localStorage.setItem('basket','[]');
let basket = [];
/*
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
        localStorage.setItem('basket',JSON.stringify(basket))    
    })
})

btnQuitRoomSelection.addEventListener('click',ev => {
    sectionRoom.classList.toggle("salle_available_toggled");
    localStorage.setItem('purchasingInfo','');
})*/



