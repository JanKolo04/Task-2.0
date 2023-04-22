// constants variables
const allAddedUsers = document.querySelector(".allAddedUsers");
const countAddedUsers = document.querySelector("#usersCountValue");
const addButton = document.querySelector(".addButton");
const deleteButton = document.querySelector(".deleteButton");

let listOfAddedUsers = [];

function AddLostUsersIntoArray() {
    let users = document.querySelectorAll(".email");
    
    // add emails into list
    for(let i=0; i<users.length; i++) {
        listOfAddedUsers.push(users[i].innerHTML);
    }
}

AddLostUsersIntoArray();
console.log(listOfAddedUsers);
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
        
        // create div for user email
        let user = document.createElement("div");
        user.classList.add("user");
        user.id = "user"+(parseInt(countAddedUsers.innerHTML)+1);
        user.setAttribute("data-value", newEmail.value);
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
        let deleteButton = CreateButton(parseInt(countAddedUsers.innerHTML)+1);
        // append delete button into user section
        user.appendChild(deleteButton);
        // update number of added users
        countAddedUsers.innerHTML = parseInt(countAddedUsers.innerHTML)+1;
        
        //clear value after add
        newEmail.value = "";
    }
}

function CreateButton(divId) {
    // create object with button to delete new added user
    let button = document.createElement("a");
    button.classList.add("deleteButton");
    button.innerHTML = "X";

    // create function to delete user form list
    button.onclick = function() {
        // user 
        let user = document.querySelector("#user"+divId);
        let emailUser = user.getAttribute("data-value");

        // find index of emailUser in array
        index = listOfAddedUsers.indexOf(emailUser);
        // delete user from list
        listOfAddedUsers.splice(index,1);
        // change count of user in counter
        countAddedUsers.innerHTML = parseInt(countAddedUsers.innerHTML)-1;

        // delete user from div
        allAddedUsers.removeChild(user);
        PassEmailToCookies();
    }

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

function CheckCountOfUsers() {
    // get count of added users and print this for allways showing count of added users
    let users_count = document.querySelectorAll(".user").length;
    countAddedUsers.innerHTML = users_count;
}

function AddStyle() {
    // if in list exist min one user add css
    if(countAddedUsers.innerHTML > 0) {
        addButton.style = "margin-left: 12.5px;";
        allAddedUsers.style = "margin-left: 5px;";
    }
}

CheckCountOfUsers();