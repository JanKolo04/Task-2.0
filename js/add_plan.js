// constants variables
const allAddedUsers = document.querySelector(".allAddedUsers");
const countAddedUsers = document.querySelector("#usersCountValue");
const addButton = document.querySelector(".addButton");

let listOfAddedUsers = [];
function AddNewUserBox() {
    let newEmail = document.querySelector("#planUserEmail");
    // valid data
    if(newEmail.value != "" && countAddedUsers.innerHTML < 2) {
        // when email exist in list return alert
        for (let item of listOfAddedUsers) {
            if(newEmail.value == item) {
                alert("User is added into list!");
                return;
            }
        }
        // push new user into array
        listOfAddedUsers.push(newEmail.value);
        
        // add margin to addButton and for container for users
        addButton.style = "margin-left: 12.5px;";
        allAddedUsers.style = "margin-left: 5px;";
        
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
        // set name for new user
        let nameForEmail = "newUser";
        email.setAttribute("name", nameForEmail);
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
    let button = document.createElement("a");
    button.classList.add("deleteButton");
    button.innerHTML = "X";

    return button;
}

function PassEmailToCookies() {
    if(listOfAddedUsers.length != 0) {
        const d = new Date();
        d.setTime(d.getTime() + (24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = "emails="+listOfAddedUsers+";"+expires+";path=/";
    }

    
}