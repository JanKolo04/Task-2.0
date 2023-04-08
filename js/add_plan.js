// constants variables
const allAddedUsers = document.querySelector(".allAddedUsers");
const countAddedUsers = document.querySelector("#usersCountValue");

function AddNewUser() {
    let newEmail = document.querySelector("#planUserEmail");
    // valid data
    if(newEmail.value != "" && countAddedUsers.innerHTML < 3) {
        // create div for user email
        let user = document.createElement("div");
        user.classList.add("user");
        allAddedUsers.appendChild(user);

        // section for email
        let userEmail = document.createElement("div");
        userEmail.classList.add("userEmail");
        user.appendChild(userEmail);

        // span with email
        let email = document.createElement("span");
        email.classList.add("email");
        email.innerHTML = newEmail.value;
        userEmail.appendChild(email);

        // detele nutton
        let deleteButton = CreateButton();
        // append delete button into user section
        user.appendChild(deleteButton);
        // add one more if user was addded
        countAddedUsers.innerHTML = parseInt(countAddedUsers.innerHTML)+1;

        //clear value after add
        newEmail.value = "";
    }
}

function CreateButton() {
    // create object with button to delete new added user
    let button = document.createElement("button");
    button.classList.add("deleteButton");
    button.innerHTML = "X";

    return button;
}