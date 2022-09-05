const apiGetBookingByBookingId = (bookingId, onSuccess) => {
    const request = new XMLHttpRequest();
    let url = 'https://localhost:8000'
    request.open("GET", url + "/admindashboard/getdata/" + bookingId, true);
    request.addEventListener("readystatechange", function () {
        if (request.readyState === XMLHttpRequest.DONE) {
            let response = request;
            if (request.status === 200) {
                let res = JSON.parse(request.responseText);
                onSuccess(res)
            } else if (request.status === 400) {
                console.error("Une erreur s'est produite : ", response.status);
            } else {
                console.error("Une erreur s'est produite : ", response.status);
            }
        }
    })
    request.send();
}
