document.addEventListener("DOMContentLoaded", () => {
  const dishSelect = document.getElementById("dish-select");
  const dishImage = document.getElementById("dish-image");
  const dishIngredients = document.getElementById("ingredients-list");

  const baseUrl = `${ASSETS}/images/dishes/`;

  const urls = [`${ROOT}/api/dishes`, `${ROOT}/api/items`, `${ROOT}/api/units`];

  let dishes;
  let ingredientList;
  let ingredients;
  let units;

  const fetchData = async () => {
    const promises = urls.map((url) => fetch(url));
    const responses = await Promise.all(promises);
    return await Promise.all(responses.map((response) => response.json()));
  };

  fetchData().then((data) => {
    dishes = data[0]["dishes"] ?? [];
    ingredients = data[1]["items"] ?? [];
    units = data[2]["units"] ?? [];

    const ingredientNames = {};
    if (ingredients && ingredients.length > 0) {
      ingredients.forEach((ingredient) => {
        ingredientNames[ingredient.item_id] = ingredient;
      });
    }
    const unitNames = {};
    if (units && units.length > 0) {
      units.forEach((unit) => {
        unitNames[unit.unit_id] = unit;
      });
    }

    // add event listener to select ingredient
    dishSelect.addEventListener("change", (e) => {
      const selectedOption = dishSelect.options[dishSelect.selectedIndex];
      fetch(`${ROOT}/api/ingredients`)
        .then((response) => response.json())
        .then((data) => {
          ingredientList = data["ingredients"];
          document.getElementById("ing-form").style.display = "inline";
          document.getElementById("edit-button").style.display = "inline";

          clearForm();
          makeNonEditable();

          const id = selectedOption.getAttribute("data-id");
          // set the dish id in the form
          document
            .querySelector(".ingredient-form")
            .setAttribute("data-dish-id", id);

          const imgName = selectedOption.getAttribute("data-imgurl");
          const imageUrl = baseUrl + imgName;
          dishImage.src = imageUrl;

          // get the ingredients of the dish
          let currIngredients = ingredientList[id];

          // display all the ingredients of the dish below the image in the table
          dishIngredients.innerHTML = "";

          // if no ingredients are added yet
          if (!currIngredients) {
            dishIngredients.innerHTML = `
                <tr>
                    <td colspan="5">No ingredients added yet</td>
                </tr>
            `;
          } else {
            currIngredients.forEach((ingredient) => {
              dishIngredients.innerHTML += `
            <tr>
                <td class="edit-icons" style="display:none"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></tdi>
                <td data-ing-id = "${ingredient.item_id}" >${ingredient.item_name
                }</td>
                <td>${ingredient.quantity}</td>
                <td data-unit-id="${ingredient.unit}">${unitNames[ingredient.unit].unit_name
                }</td>
                <td class="trash-icons" style="display:none"><i class="fa fa-trash trash-icon"></i></td>
            </tr>
          `;
            });

            // Add event listener to all edit icons to edit the ingredient
            editOnClick();

            // Add event listener to all trash icons to delete the ingredient
            DeleteOnTrashClick();
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });

    // Add event listener to the form to add a new ingredient or update dish
    document
      .querySelector("#add-button")
      .addEventListener("click", function (event) {
        event.preventDefault();

        const dish = document
          .querySelector(".ingredient-form")
          .getAttribute("data-dish-id");
        const ingredient = document.getElementById("ingredient").value;
        const quantity = document.getElementById("quantity").value;
        const unit = document.getElementById("unit").value;

        let data = {
          dish: dish,
          ingredient: ingredient,
          quantity: quantity,
          unit: unit,
        };

        // check whether button is used for submitting form or updating
        if (event.target.textContent === "Add") {
          event.preventDefault();

          fetch(`${ROOT}/api/ingredients/add`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => response.json())
            .then((data) => {
              console.log(data);
            })
            .catch((error) => {
              console.error("Error:", error);
            });

          // add the ingredient to the table below the image

          // if the table is not empty, add the ingredient to the table
          let ingredient_id = document.getElementById("ingredient").value;
          let unit_id = document.getElementById("unit").value;
          const tr = document.createElement("tr");

          // create cells for pencil icon
          const pencilCell = document.createElement("td");
          pencilCell.classList.add("edit-icons");
          pencilCell.innerHTML = `<i class = "fa fa-pencil-square-o" aria-hidden="true" ></i>`;
          tr.appendChild(pencilCell);

          const ingredientCell = document.createElement("td");
          ingredientCell.textContent = ingredientNames[ingredient_id].item_name;
          tr.appendChild(ingredientCell);

          const quantityCell = document.createElement("td");
          quantityCell.textContent = quantity;
          tr.appendChild(quantityCell);

          const unitCell = document.createElement("td");
          unitCell.textContent = unitNames[unit_id].unit_name;
          tr.appendChild(unitCell);

          // create cells for trash icon
          const trashCell = document.createElement("td");
          trashCell.classList.add("trash-icons");
          trashCell.innerHTML = `<i class="fa fa-trash trash-icon" ></i>`;
          tr.appendChild(trashCell);

          // if the table is empty, remove the "no ingredients added yet" row
          if (
            dishIngredients.children[0]?.children[0]?.innerHTML ===
            "No ingredients added yet" ||
            dishIngredients.children.length === 0
          ) {
            dishIngredients.innerHTML = "";
          }

          // add the table row to the table
          dishIngredients.appendChild(tr);

          DeleteOnTrashClick(tr);
          editOnClick(tr);

          // hide the pencil and trash icons
          pencilCell.style.display = "none";
          trashCell.style.display = "none";

          ingredientCell.setAttribute("data-ing-id", data.ingredient);
          unitCell.setAttribute("data-unit-id", unit_id);

          clearForm();
          // makeNonEditable();
        } else if (event.target.textContent === "Save") {
          // send the data to the server to delete the ingredient from the dish
          fetch(`${ROOT}/api/ingredients/edit`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                location.reload();
              }
            })
            .catch((error) => {
              console.error("Error:", error);
            });
          clearForm();

          // change the table row to the new values
          var tablerow = document.querySelector(".row-in-form");
          tablerow.children[1].textContent =
            ingredientNames[ingredient].item_name;
          tablerow.children[2].textContent = quantity;
          tablerow.children[3].textContent = unitNames[unit].unit_name;

          rowInForm();
        }
      });

    // Add event listener to the add button to make the ingredients non-editable and submit the form
    document
      .getElementById("finish-button")
      .addEventListener("click", function (event) {
        event.preventDefault();
        rowInForm();
        makeNonEditable();
      });

    // Add event listener to the edit button to make the ingredients editable
    document
      .getElementById("edit-button")
      .addEventListener("click", function (event) {
        event.preventDefault();
        makeEditable();
        // make form field ingredient non editable
        document.getElementById("ingredient").disabled = true;
      });

    function makeEditable() {
      // Make the table headers with class edit-icons visible
      const editIcons = document.querySelectorAll(".edit-icons");
      editIcons.forEach((editIcon) => {
        editIcon.style.display = "block";
      });

      // make finish button visible
      document.getElementById("finish-button").style.display = "inline";

      // make trash icon visible
      const trashIcons = document.querySelectorAll(".trash-icons");
      trashIcons.forEach((trashIcon) => {
        trashIcon.style.display = "block";
      });

      // make the pencil icon visible
      const pencilIcons = document.querySelectorAll(
        ".ingredients-list .fa-pencil-square-o"
      );
      pencilIcons.forEach((pencilIcon) => {
        pencilIcon.parentElement.style.display = "block";
      });

      // make the edit button invisible
      document.getElementById("edit-button").style.display = "none";

      // make the add ingredient button say save
      document.getElementById("add-button").textContent = "Save";
    }

    function makeNonEditable() {
      // Make the table headers with class edit-icons invisible
      const editIcons = document.querySelectorAll(".edit-icons");
      editIcons.forEach((editIcon) => {
        editIcon.style.display = "none";
      });

      // make ingredient field editable
      document.getElementById("ingredient").disabled = false;

      // make finish button invisible
      document.getElementById("finish-button").style.display = "none";

      // make trash icon invisible
      const trashIcons = document.querySelectorAll(".trash-icons");
      trashIcons.forEach((trashIcon) => {
        trashIcon.style.display = "none";
      });

      // make the pencil icon invisible
      const pencilIcons = document.querySelectorAll(
        ".ingredients-list .fa-pencil-square-o"
      );
      pencilIcons.forEach((pencilIcon) => {
        pencilIcon.parentElement.style.display = "none";
      });

      // make the edit button visible
      document.getElementById("edit-button").style.display = "inline";

      // make the add ingredient button say add
      document.getElementById("add-button").textContent = "Add";
    }

    // Add event listener to all trash icons to delete the ingredient
    // If an object is passed only the trash icons in that object are added
    function DeleteOnTrashClick(something = null) {
      let trashIcons;
      if (!something) trashIcons = document.querySelectorAll(".trash-icon");
      else trashIcons = something.querySelectorAll(".trash-icon");

      trashIcons.forEach((trashIcon) => {
        trashIcon.addEventListener("click", function (event) {
          event.preventDefault();
          // get the ingredient id and dish id
          let ingredient =
            event.target.parentElement.parentElement.children[1].getAttribute(
              "data-ing-id"
            );
          let dish = document
            .querySelector(".ingredient-form")
            .getAttribute("data-dish-id");
          ingredient = ingredientNames[ingredient].item_id;
          let data = {
            dish: dish,
            ingredient: ingredient,
          };

          // send the data to the server to delete the ingredient from the dish
          fetch(`${ROOT}/api/ingredients/delete`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                location.reload();
              }
            })
            .catch((error) => {
              console.error("Error:", error);
            });

          // remove the ingredient from the table
          event.target.parentElement.parentElement.remove();
          clearForm();
          if (dishIngredients.children.length === 0) {
            dishIngredients.innerHTML = `
          <tr>
            <td colSpan="5">No ingredients added yet</td>
          </tr>
          `;
          }
        });
      });
    }

    function clearForm() {
      document.getElementById("ingredient").value = "";
      document.getElementById("quantity").value = "";
      document.getElementById("unit").value = "";
    }

    // Add event listener to all pencil icons to edit the ingredient
    // Fills in the form with the ingredient data
    // If an object is passed only the edit icons in that object are added

    function editOnClick(something = null) {
      let pencilIcons;
      if (!something)
        pencilIcons = document.querySelectorAll(".fa-pencil-square-o");
      else pencilIcons = something.querySelectorAll(".fa-pencil-square-o");

      console.log(pencilIcons);
      pencilIcons.forEach((pencilIcon) => {
        pencilIcon.addEventListener("click", function (event) {
          event.preventDefault();

          // get the row that is being edited
          let tablerow = event.target.parentElement.parentElement;
          // get the ingredient id, dish id, unit id and quantity
          let dish = document
            .querySelector(".ingredient-form")
            .getAttribute("data-dish-id");
          let ingredient = tablerow.children[1].getAttribute("data-ing-id");
          let quantity = tablerow.children[2].textContent;
          let unit_id = tablerow.children[3].getAttribute("data-unit-id");

          // highlight the row that is being edited
          rowInForm(tablerow);

          // autofill the form with the ingredient data
          document.getElementById("ingredient").value = ingredient;
          document.getElementById("quantity").value = quantity;
          document.getElementById("unit").value = unit_id;
          document.getElementById("quantity").value = quantity;

          // focus on the form
          document.getElementById("quantity").focus();
        });
      });
    }

    // Highlight the row that is being edited
    function rowInForm(row = null) {
      // remove the row-in-form class from all rows
      const rows = document.querySelectorAll(".row-in-form");
      rows.forEach((row) => {
        row.classList.remove("row-in-form");
      });

      // add the rowinform class to the row that is being edited
      if (row) row.classList.add("row-in-form");
    }
  });
});
