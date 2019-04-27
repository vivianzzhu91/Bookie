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
document.querySelector("#repass").oninput = function(){
    let repass = document.querySelector("#repass").value;
    if(repass.length < 6){
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
document.querySelector("#signupForm").onsubmit = () =>{
    let rePassinput = document.querySelector("#repass");
    let usernameInput = document.querySelector("#username");
    let passInput = document.querySelector("#pass");
    let repass = rePassinput.value;
    let pass = document.querySelector("#pass").value;
    let username = document.querySelector("#username").value; 
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
    if(repass != pass){
        rePassinput.classList.remove("valid");
        rePassinput.classList.add("invalid");
        let warning = document.createElement("p");
        warning.innerHTML="PASSWORDS DO NOT MATCH :(";
        warning.style.color = '#FABEA2';
        document.querySelector('.warning').appendChild(warning);
        checkForm = false;
    }
    return checkForm;
}