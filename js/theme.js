//--const--

//Bottone
const ThemeBtn = document.querySelector("#ThemeChanger");
//chiave per memorizzaione in localstore
const LocalStoragekey = "themeMindWords";
//nome classe da attivare
const LightClass = "light-mode";
//percorso sole
const SunPath = "src/whitesun.png";
//path luna
const MoonPath = "src/drarkmoon.png";
// immagine reale
const ImgBtn = ThemeBtn.children[0];

//--stati--

//cotenitore tema
let theme = localStorage.getItem(LocalStoragekey);

//--on mount

//carico il thema al loding
if (theme) {
    document.body.classList.add(LightClass);
    ImgBtn.src = MoonPath;
}

//--event--

//se premo il bottone cambio icona e add/remove la classe per cambiare tema 
ThemeBtn.addEventListener("click", ()=>{
    document.body.classList.toggle(LightClass);
    if (theme) {
        localStorage.removeItem(LocalStoragekey);
        ImgBtn.src = SunPath;
        theme = null;
    }else{
        localStorage.setItem(LocalStoragekey, LightClass);
        ImgBtn.src = MoonPath;
        theme = LightClass;
    }
});

