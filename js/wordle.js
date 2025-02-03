//##il file presuppone l'inserimento del file come module##
import {updateScore} from './utilscore.js';

//--oggetti--

//keyboard divisa in 3 righe
const keyboard = document.querySelectorAll(".keyboardRow");
//alfabeto
const qwerty = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
//pulsante backspace
const backspace = document.getElementById("backspace");
//pulsante invio
const enter = document.getElementById("enter");
//caselle iserimento
const letters = document.querySelectorAll(".letter");
// popup father
const popup = document.getElementById("popup");
// vari popup
const boxes = document.querySelectorAll(".box");
//container fine lettere
const endConteiner = document.getElementById("endContainer");
//dysplay punteggio
const pointTraker = document.getElementById("punteggio");
//element section
const section = document.getElementById("section");
//bottone di err se non vengono iseriti tutti gli elem
const errorBtn = document.getElementById("notFull");

//--stati--

// parola attualmente selezionata
let buffer = "";
// i-eseimo elemento delle letter
let pointer = 0;
//numero tenetivi 
let currentTrys = 0;
//parola da indovinare
let word = ""
//keys
let keys = [];
//is the user allowed to operate the page
let blocked = false;
//punteggio totale sessione
let punteggio = 0;
//serie
let streak = 1;
//tempo per indovinare
let time = performance.now();


//--funzioni--

//rimovre char from string at specific index 
function indexRemove(string, index) {
    if (index >= string.length) {
        console.error("index troppo grande");
    }
    return string.slice(0, index) + " " + string.slice(index+1);
}

//gen new word from db
async function newDbWord(length, oldWord) {
    let data = 
        "len=" + encodeURIComponent(length) + 
        "&oldword=" + encodeURIComponent(oldWord);

    try{
        const risposta = await fetch("logic/getword.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: data
        });

        if (risposta.ok){
            const data = await risposta.json();
            if (data.generatedWord) {
                return data.generatedWord;
            }else if (data.error){
                console.error(data.error);
            }
        }else{
            alert("Qualcosa è andato storto con la creazione della parola, ci dispace");
            console.error("Errore:", risposta.status);
        }
    }catch(error) {
        console.error("Errore di rete:", error);
    }
}

//funzione di reset
function reset() {
    buffer = "";
    pointer = 0;
    currentTrys = 0;
    time = performance.now();
    newDbWord(lenWord, word).then(r => {
        word = r;
        console.log(word);
    });
    keys.forEach(e => {
        e.classList = "key";
    });

    for (let i = 0; i < letters.length; i++) {
        letters[i].classList = "letter";
        letters[i].textContent = "";
    }
}

//funzione che inserise un carattere
function insertChar(key) {
    /*
    preferito | 0, rispetto a Math.floor() perchè più veloce e ottengo il risultato che voglio
    */
    if (((pointer / lenWord) | 0) == currentTrys && currentTrys < Trys && !blocked) {
        buffer += key.toLowerCase();
        letters[pointer].textContent = key;
        pointer++;
    }
}

//funzione per cancellare
function cancella() {
    if (pointer > (currentTrys * lenWord) && !blocked) {
        buffer = buffer.slice(0, -1);
        pointer--;
        letters[pointer].textContent = "";
    }
}

//funzione di invio
function send(){
    if (blocked) {
        return;
    }

    if (!word) {
        //aspettare
        console.error("La parola non è stata ancora generata");
        return;
    }

    if (buffer.length < lenWord) {
        popup.classList.remove("sparire");
        popup.classList.add("appear");
        boxes[0].classList.remove("sparire"); 
        blocked = true;
        return;
    }
    
    let correct = 0;
    let tempWord = word;
    let basePointer = currentTrys * lenWord;
    currentTrys++;

    // vedo quanti corretti
    for (let i = 0; i < buffer.length; i++) {
        if (tempWord[i] == buffer[i]) {
            keys[qwerty.indexOf(tempWord[i].toUpperCase())].classList.add("correct"); 
            letters[basePointer + i].classList.add("correct");
            buffer = indexRemove(buffer, i);
            tempWord = indexRemove(tempWord, i);
            correct++;
        }
    }

    //win condition
    if(correct == lenWord){
        let scaleScore = ((Trys - currentTrys + 1) / Trys);
        let gameScore = Math.floor(maxPoints * scaleScore * streak);
        punteggio += gameScore;
        pointTraker.textContent = "Punteggio: " + punteggio; 

        if (isLogged) {
            
            streak++;
            time = performance.now() - time;

            section.classList.remove("confetti");
            void section.offsetWidth;
            section.classList.add("confetti");

            //inserimento punetgio
            updateScore(startTime, time, currentTrys, gameScore).then(r =>{
                if (!r) {
                    alert("il punteggio non è stato salvato");
                }
            });

            reset();
        } else{
            popup.classList.remove("sparire");
            endConteiner.classList.add("sparire");
            popup.classList.add("appear");
            boxes[1].classList.remove("sparire"); 
            boxes[1].firstElementChild.children[0].textContent = "Hai vinto!";
            boxes[1].firstElementChild.children[2].textContent += punteggio;
            blocked = true;
        }
        return;
    }

    // guardo gli sbagiati o non in posizione corretta
    for (let i = 0; i < lenWord; i++) {
        let char = buffer[i];
        if (char !== " ") {
            let index = tempWord.indexOf(char);
            if (index >= 0) {
                letters[basePointer + i].classList.add("guess");
                keys[qwerty.indexOf(char.toUpperCase())].classList.add("guess");
                buffer = indexRemove(buffer, i);
                tempWord = indexRemove(tempWord, index);
            }else{
                letters[basePointer + i].classList.add("wrong");
                keys[qwerty.indexOf(char.toUpperCase())].classList.add("wrong");
            }
        }
    }
    
    //condizione sconfitta
    if (currentTrys == Trys) {
        boxes[1].firstElementChild.children[0].textContent = "Hai perso :(";
        boxes[1].firstElementChild.children[2].textContent += punteggio;
        for (let i = 0; i < endConteiner.children.length; i++) {
            endConteiner.children[i].textContent = word[i].toUpperCase();
        }
        popup.classList.remove("sparire");
        popup.classList.add("appear");
        boxes[1].classList.remove("sparire");
        blocked = true;
    }
    buffer = "";
}


//--on mount--

//genereo una nuova parola
newDbWord(lenWord, word).then(r => {
    word = r;
    //cheat row
    console.log(word);
});

//per chiudere il messaggio di non riempito
errorBtn.addEventListener("click", ()=>{
    popup.classList.remove("appear");
    popup.classList.add("sparire");
    boxes[0].classList.add("sparire");
    blocked = false;
});

//aggiornamento contrasto bottoni
if (!theme) {
    backspace.firstElementChild.classList.add("invert");
    enter.firstElementChild.classList.add("invert");
}

//genearazione tastiera
let row = keyboard[0];
let before = backspace;
qwerty.forEach(e => {
    let key = document.createElement("div");
    key.classList.add("key");
    key.textContent = e;

    key.addEventListener("click", ()=>{
        insertChar(e);
    });

    keys.push(key);

    switch (e) {
        case 'A':
            row = keyboard[1];
            before = enter;
            break;
        
        case 'Z':
            row = keyboard[2];
            before = null;
            break;
    
        default:
            break;
    }
    row.insertBefore(key, before);
});

//--eventi--

//colleamento tasteira fisica
qwerty.forEach(ele => {
    document.addEventListener("keydown", (e)=>{
        if (e.key.toUpperCase() === ele) {
            insertChar(ele);
        }
    });
});

//collegemnto backspace fisico
document.addEventListener("keydown", (e)=>{
    if (e.key == "Backspace") {
        cancella();
    }
    if (e.key == "Enter") {
        send();
    }
});

//backspace finto
backspace.addEventListener("click", ()=>{
    cancella();
})

//collegamento enter fisico
enter.addEventListener("click", ()=>{
    send();
});

//cambio tema tasteria
ThemeBtn.addEventListener("click", ()=>{
    backspace.firstElementChild.classList.toggle("invert");
    enter.firstElementChild.classList.toggle("invert");
});