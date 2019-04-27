document.querySelector("#pass").oninput = function(){
    let pass = document.querySelector("#pass").value;
    if(pass.length < 6){
        this.classList.remove("valid");
        this.classList.add("invalid");
    }
    else{
        this.classList.remove("invalid");
        this.classList.add("valid");
    }
}
document.querySelector("#username").oninput = function(){
    let username = document.querySelector("#username").value; 
    if(username.trim().length == 0){
        this.classList.remove("valid");
        this.classList.add("invalid");
    }
    else{
        this.classList.remove("invalid");
        this.classList.add("valid");
    }
}
document.querySelector("#loginForm").onsubmit = () =>{
    let pass = document.querySelector("#pass").value;
    let username = document.querySelector("#username").value; 
    let usernameInput = document.querySelector("#username");
    let passInput = document.querySelector("#pass");
    //clean up previous warning
    document.querySelector('.warning').innerHTML = "";
    let checkForm = true;
    if(username.trim().length == 0){
        usernameInput.classList.remove("valid");
        usernameInput.classList.add("invalid");
        let warning = document.createElement("p");
        warning.innerHTML="USERNAME CANNOT BE EMPTY";
        warning.style.color = '#FABEA2';
        document.querySelector('.warning').appendChild(warning);
        checkForm = false;
    }
    if(pass.length < 6 ){
        passInput.classList.remove("valid");
        passInput.classList.add("invalid");
        let warning = document.createElement("p");
        warning.innerHTML="PASSWORD NEED TO BE LONGER THAN 6 CHARS";
        warning.style.color = '#FABEA2';
        document.querySelector('.warning').appendChild(warning);
        checkForm = false;
    }
    return checkForm;
}