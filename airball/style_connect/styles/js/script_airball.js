const btn=document.querySelector(".button");
const overlay=document.querySelector(".overlay");
let menuOpen=false;

btn.addEventListener("click",()=>{
    if(menuOpen==false){
        overlay.classList.add("open");
        menuOpen=true;
    }
    else{
        overlay.classList.remove("open");
        menuOpen=false;
    }
});

const signIn=document.querySelector("#signIn");
const signUp=document.querySelector("#signUp");
const container=document.querySelector(".connection");

signUp.addEventListener("click",()=>{
    container.classList.add("slide");
});
signIn.addEventListener("click",()=>{
    container.classList.remove("slide");
});
