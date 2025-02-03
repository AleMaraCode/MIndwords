//--oggetti--

//immagini con l'occhio
const EyeBtns = document.querySelectorAll(".btnBg");

//--on mount--

// aggiorno l'immagine al caricamento della pagina
if (!theme) {
    EyeBtns.forEach(e => {
        e.firstElementChild.classList.add("invert");
    });
}

//--event--

//se cambio tema aggiorno l'immagine
ThemeBtn.addEventListener("click", ()=>{
    EyeBtns.forEach(e => {
        e.firstElementChild.classList.toggle("invert");
    });
});

//attivo o disattivo la visibilità del campo alla pressione dell corrispettivo bottone
EyeBtns.forEach(e => {
    e.addEventListener("click", () =>{
        let input = e.parentElement.firstElementChild;
        let icon = e.firstElementChild;
        if (input.type.includes("password")){
            input.type = "text";
            icon.src = "src/hide.png";
        }else{
            input.type = "password";
            icon.src = "src/visible.png";
        }
    });
});
