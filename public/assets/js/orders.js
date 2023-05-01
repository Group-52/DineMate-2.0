document.addEventListener("DOMContentLoaded", () => {
  /**
   * Toggle the order details
   */
  document.querySelectorAll(".chevron").forEach((chevron) => {
    chevron.addEventListener("click", () => {
      let order = chevron.parentElement;
      while (!order.classList.contains("order")) {
        order = order.parentElement;
      }
      order.classList.toggle("expanded");
    })
  });

  /**
   * Modal Wrapper
   */
  const modalWrapper = document.querySelector(".modal-wrapper");
  const modalClose = document.querySelector(".modal .modal-close");
  const editableStars = document.querySelector(".stars-editable");
  const orderIdField = document.querySelector("#order-id");
  const feedbackIdField = document.querySelector("#feedback-id");
  const ratingField = document.querySelector("#rating");
  const descriptionField = document.querySelector("#description");
  const body = document.querySelector("body");
  const submitFeedback = document.querySelector("#submit-feedback");

  /**
    * Check if the elements exist
   */
  if (modalWrapper && modalClose && editableStars && orderIdField && feedbackIdField && ratingField && descriptionField && body && submitFeedback) {
    /**
     * Edit Feedback Modal
     */
    document.querySelectorAll(".edit-feedback").forEach((editFeedback) => {
      editFeedback.onclick = () => {
        const orderId = editFeedback.dataset.order;
        orderIdField.value = orderId;
        modalWrapper.style.display = "block";
        body.style.overflow = "hidden";
        fetch(ROOT + "/api/feedback/get/" + orderId)
          .then(response => response.json())
          .then(data => {
            const feedback = data["feedback"];
            const feedbackId = feedback["feedback_id"];
            const rating = feedback["rating"];
            const description = feedback["description"];

            feedbackIdField.value = feedbackId;
            ratingField.value = rating;
            [...editableStars.children].forEach((editableStar) => {
              if (editableStar.dataset.stars <= rating) {
                editableStar.classList.add("star");
              }
            })
            descriptionField.value = description;
            submitFeedback.onclick = () => submitFeedbackForm("edit");
          })
          .catch(error => new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Error", "Something went wrong", false, 5000))
      }
    });

    /**
     * Add Feedback Modal
     */
    document.querySelectorAll(".add-feedback").forEach((addFeedback) => {
      addFeedback.onclick = () => {
        orderIdField.value = addFeedback.dataset.order;
        modalWrapper.style.display = "block";
        body.style.overflow = "hidden";
        submitFeedback.onclick = () => submitFeedbackForm("add");
      }
    });

    [...editableStars.children].forEach((editableStar) => {

      /**
       * Changing the stars on click
       */
      editableStar.onclick = () => {
        const stars = editableStar.dataset.stars;
        ratingField.value = stars;
        [...editableStars.children].forEach((editableStar) => {
          if (editableStar.dataset.stars <= stars) {
            editableStar.classList.add("star");
          } else {
            editableStar.classList.remove("star");
          }
        });
      }

      /**
       * Changing the stars on hover
       */
      editableStar.onmouseover = () => {
        const stars = editableStar.dataset.stars;
        [...editableStars.children].forEach((editableStar) => {
          if (editableStar.dataset.stars <= stars) {
            editableStar.classList.add("hover");
          } else {
            editableStar.classList.remove("hover");
          }
        });
      }
    })

    /**
     * Removing hover stars on mouse leave
     */
    editableStars.onmouseleave = () => {
      [...editableStars.children].forEach((editableStar) => {
        editableStar.classList.remove("hover");
      });
    }

    /**
     * Closing the modal and resetting the form
     */
    const closeFeedbackModal = () => {
      modalWrapper.style.display = "none";
      body.style.overflowY = "auto";
      [...editableStars.children].forEach((editableStar) => {
        editableStar.classList.remove("star");
      });
      feedbackIdField.value = "";
      ratingField.value = "";
      descriptionField.value = "";
      orderIdField.value = "";
    }

    /**
     * Updating the stars on the order card
     * @param stars
     * @param orderId
     */
    const updateStars = (stars, orderId) => {
      const starsContainer = document.querySelector(`.stars[data-order="${orderId}"]`);
      starsContainer.classList.remove("d-none");
      [...starsContainer.children].forEach((star) => {
        if (star.dataset.stars <= stars) {
          star.classList.add("star");
        } else {
          star.classList.remove("star");
        }
      })
    }

    /**
     * Displaying the stars on the order card
     * @param stars
     * @param orderId
     */
    const displayStars = (stars, orderId) => {
      updateStars(stars, orderId);
      const addFeedbackButton = document.querySelector(`.add-feedback[data-order="${orderId}"]`);
      addFeedbackButton.classList.add("d-none");
      const editFeedbackButton = document.querySelector(`.edit-feedback[data-order="${orderId}"]`);
      editFeedbackButton.classList.remove("d-none");
    }

    // Closing the modal on click
    modalClose.onclick = closeFeedbackModal;

    /**
     * Submitting the feedback form
     * @param type
     */
    const submitFeedbackForm = (type) => {
      const orderId = orderIdField.value;
      const feedbackId = feedbackIdField.value;
      const rating = ratingField.value;
      const description = descriptionField.value;
      if (type === "edit") {
        fetch(ROOT + "/api/feedback/edit/" + feedbackId, {
          method: "POST",
          body: JSON.stringify({
            rating: rating,
            description: description
          })
        })
          .then(response => response.json())
          .then(data => {
            if (data["success"]) {
              new Toast("fa-solid fa-check-circle", "#4CAF50", "Success", "Feedback edited successfully", false, 5000);
              closeFeedbackModal();
              updateStars(rating, orderId);
            } else {
              new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Error", "Something went wrong", false, 5000);
            }
          })
          .catch(error => new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Error", "Something went wrong", false, 5000))
      } else {
        fetch(ROOT + "/api/feedback/add", {
          method: "POST",
          body: JSON.stringify({
            order_id: orderId,
            rating: rating,
            description: description
          })
        })
          .then(response => response.json())
          .then(data => {
            if (data["success"]) {
              new Toast("fa-solid fa-check-circle", "#4CAF50", "Success", "Feedback added successfully", false, 5000);
              closeFeedbackModal();
              displayStars(rating, orderId);
            } else {
              new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Error", "Something went wrong", false, 5000);
            }
          })
          .catch(error => new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Error", "Something went wrong", false, 5000))
      }
    }
  }


  /**
   * Sockets
   */
  const socket = new Socket("ws://localhost:8080");
  socket.receive_data("accepted_order", (data) => {
    const orderId = data["order_id"];
    new Toast("fa-solid fa-check-circle", "#4CAF50", "Accepted", `Order #${orderId} accepted successfully`, false, 5000);
    const orderStatus = document.querySelector(`.order-status[data-order="${orderId}"]`);
    if (orderStatus !== null) {
      orderStatus.innerHTML = "Accepted";
      orderStatus.classList.remove("pending");
      orderStatus.classList.add("accepted");
    }
  })

  socket.receive_data("rejected_order", (data) => {
    const orderId = data["order_id"];
    new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Rejected", `Order #${orderId} rejected`, false, 5000);
    const orderStatus = document.querySelector(`.order-status[data-order="${orderId}"]`);
    if (orderStatus !== null) {
      orderStatus.innerHTML = "Rejected";
      orderStatus.classList.remove("pending");
      orderStatus.classList.add("rejected");
    }
  });

  socket.receive_data("completed_order", (data) => {
    const orderId = data["order_id"];
    new Toast("fa-solid fa-check-circle", "#4CAF50", "Completed", `Order #${orderId} completed successfully`, false, 5000);
    const orderStatus = document.querySelector(`.order-status[data-order="${orderId}"]`);
    if (orderStatus !== null) {
      orderStatus.innerHTML = "Completed";
      orderStatus.classList.remove("accepted");
      orderStatus.classList.add("completed");
    }
  });
})