//nav bar toggle

const sideMenu = document.querySelector("#menu");
const interface = document.querySelector("#interface");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

menuBtn.addEventListener('click', () =>{
    sideMenu.style.display = 'block';
    menuBtn.style.display = 'none';
    document.getElementById('interface').style.cssText ='width: calc(100% - 270px); margin-left: 270px;';
})

closeBtn.addEventListener('click', () =>{
    sideMenu.style.display = 'none';
    menuBtn.style.display = 'block';
    document.getElementById('interface').style.cssText ='width: 100%; margin-left: 0px;';
})

    