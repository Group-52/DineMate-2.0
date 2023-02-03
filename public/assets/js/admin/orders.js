document.addEventListener("DOMContentLoaded", () => {

  

  const circles = document.querySelectorAll('#circle');

  // adjust color of circle based on status
  circles.forEach(circle => {
    var s = circle.getAttribute('data-status');
    switch (s) {
      case "pending":
        circle.style.backgroundColor = "transparent";
        circle.style.borderColor = "black";
        break;
      case "accepted":
        circle.style.backgroundColor = "yellow";
        circle.style.borderColor = "black";
        break;
      case "completed":
        circle.style.backgroundColor = "lightgreen";
        circle.style.borderColor = "black";
        break;
      case "rejected":
        circle.style.backgroundColor = "red";
        circle.style.borderColor = "black";
        break;
    }
  });
  
  circles.forEach(circle => {

    circle.addEventListener('click', function () {

      const status = circle.getAttribute('data-status');

      switch (status) {
        case "pending":
          circle.style.backgroundColor = "yellow";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'accepted');
          break;
        case "accepted":
          circle.style.backgroundColor = "lightgreen";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'completed');
          break;
        case "completed":
          circle.style.backgroundColor = "red";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'rejected');
          break;
        case "rejected":
          circle.style.backgroundColor = "transparent";
          circle.style.borderColor = "black";
          circle.setAttribute('data-status', 'pending');
          break;
      }
    });

  });


});