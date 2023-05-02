// TODO Update guest ID via sockets
// Check if guest ID is stored in local storage
if (localStorage.getItem("guestId") === null) {
    // If not, create a new guest ID
  fetch(ROOT + "/api/guest/create")
    .then(response => response.json())
    .then(data => {
      if (data.hasOwnProperty("guestId")) {
        localStorage.setItem("guestId", data["guestId"]);
        window.location.reload();
      }
    })
    .catch(error => console.log(error))
} else {
  // If yes, check if guest ID exists
  fetch(ROOT + "/api/guest/get/" + localStorage.getItem("guestId"))
    .then(response => response.json())
    .then(data => {
       if (data["status"] !== "success") {
          // If not, create a new guest ID
          fetch(ROOT + "/api/guest/create")
            .then(response => response.json())
            .then(data => {
              if (data.hasOwnProperty("guestId")) {
                localStorage.setItem("guestId", data["guestId"]);
                window.location.reload();
              } else {
                localStorage.removeItem("guestId");
              }
            })
            .catch(error => console.log(error))
       }
    })
}