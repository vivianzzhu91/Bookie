document.querySelector("#pass").oninput = function(){
    let pass = document.querySelector("#pass").value;
    if(pass.length <= 8){
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
    if(repass.length <= 8){
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
    let repass = rePassinput.value;
    let pass = document.querySelector("#pass").value;
    //clean up previous warning
    document.querySelector('.warning').innerHTML = "";
    if(pass.length <= 8 ){
        let warning = document.createElement("p");
        warning.innerHTML="PASSWORD NEED TO BE LONGER THAN 8 CHARS";
        warning.style.color = '#FABEA2';
        document.querySelector('.warning').appendChild(warning);
    }
    if(repass != pass){
        rePassinput.classList.remove("valid");
        rePassinput.classList.add("invalid");
        let warning = document.createElement("p");
        warning.innerHTML="PASSWORDS DO NOT MATCH :(";
        warning.style.color = '#FABEA2';
        document.querySelector('.warning').appendChild(warning);
    }
    return false;
}