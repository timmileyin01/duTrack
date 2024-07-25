

const themeToggler = document.querySelector(".theme-toggler");
const active = document.querySelector(".theme-toggler .active");
const nth1 = document.querySelector(".theme-toggler i:nth-child(1)");
const nth2 = document.querySelector(".theme-toggler i:nth-child(2)");



//change theme





nth1.addEventListener('click', () => {
    document.body.classList.remove('dark-theme-variables');

    nth1.classList.add('active');
    nth2.classList.remove('active');
    
    localStorage.setItem('elem', 'nth1');
});

nth2.addEventListener('click', () => {
    document.body.classList.add('dark-theme-variables');

    
    nth1.classList.remove('active');
    nth2.classList.add('active');

    localStorage.setItem('elem', 'nth2');
});



let theme = localStorage.getItem('elem');


if (theme == 'nth2'){

    document.body.classList.add('dark-theme-variables');

    
    nth1.classList.remove('active');
    nth2.classList.add('active');

}else {
    document.body.classList.remove('dark-theme-variables');

   nth1.classList.add('active');
   nth2.classList.remove('active');
} 