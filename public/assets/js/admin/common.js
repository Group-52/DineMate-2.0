//function to display error message at a given position
function displayError(message, top_position=window.innerHeight/2 , left_position = window.innerWidth / 2) {

    const error = document.createElement("div");
    document.body.appendChild(error);
    error.style.color = "red";
    error.style.border = "2px solid red";
    error.style.position = "absolute";
    error.style.transform = "translate(-50%, -50%)";
    error.style.zIndex = "999";
    error.style.padding = "10px";
    error.style.borderRadius = "5px";
    error.style.backgroundColor = "#fff";
    error.style.boxShadow = "0 0 10px rgba(0,0,0,0.5)";

    //set the message to be displayed
    error.innerHTML = message;
    //set co-ordinates of error message
    error.style.top = top_position + "px";
    error.style.left = left_position + "px";
    error.style.display = "block";
    setTimeout(function () {
        error.style.display = "none";
        document.body.removeChild(error);
    }, 2000);
}
