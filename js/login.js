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