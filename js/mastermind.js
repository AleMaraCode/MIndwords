//##il file presuppone l'inserimento del file come module##
import {updateScore} from './utilscore.js';

//--oggetti--

//Possibili colori
const colori = [
    "rgb(51, 87, 255)", //1
    "rgb(255, 215, 0)", //2
    "rgb(138, 43, 226)", //3
    "rgb(170, 85, 153)", //4
    "rgb(255, 69, 0)", //5
    "rgb(0, 206, 209)", //6
    "rgb(220, 20, 60)", //7
    "rgb(50, 205, 50)", //8
    "rgb(30, 144, 255)", //9
    "rgb(139, 0, 0)" //10
];

//Tutte caselle di colori
const selector = document.querySelectorAll(".color");
//contenitore colori scelta
const colorPopup = document.querySelector(".colorPopup");
//oggetto contenitore del popup 
const fatherPopup = document.getElementById("popup");
//contenitore elementi gioco
const playArea = document.querySelector(".playArea");
//bottoni di selezione
const guessesBtn = document.querySelectorAll(".guess");
//contenitore popup risulltato
const result = document.getElementById("result");
//dysplay punteggio
const pointTraker = document.getElementById("punteggio");
//vari popup
const boxes = document.querySelectorAll(".box");
//element section
const section = document.getElementById("section");
//bottone di err se non vengono iseriti tutti gli elem
const errorBtn = document.getElementById("notFull");

//--stati--

//sequenza attuale
let currentSeq = randSeq(lenSeq, colori);
//casella clicata
let targetColor = null;
//Tentativi
let currentTry = numberTrys;
//colori inseriti
let insert = 0;
//punteggio 
let punteggio = 0;
//serie di vittore
let streak = 1;
//tempo per indovinare
let time = performance.now();
//se può far sparire il popup
let allowed = true;
// variabile ausiliaria per la gestione del popup
let clickInside = true;

//--functions--

//generea sequenza rand di colori
function randSeq(len, base) {
    let seq = [];
    for (let i = 0; i < len; i++) {
        let colore = base[(Math.floor(Math.random() * base.length))];
        //cheat line
        console.log(colori.indexOf(colore)+1);
        seq.push(colore);
        result.children[i].style["backgroundColor"] = colore;
    }
    return seq;
}

//funzione di reset
function resetGame() {
    currentSeq = randSeq(lenSeq, colori);
    currentTry = numberTrys;
    time = performance.now();
    selector.forEach(e => {
        e.style = "";
        e.parentElement.classList = "colorResult";
    });
    guessesBtn.forEach(e =>{
        e.disabled = false;
        e.textContent = "conferma"; 
    });
}

//funzione per rimuovere il popup
function removePopup() {
    fatherPopup.classList.add("sparire");
    boxes[0].classList.add("sparire");
    fatherPopup.classList.remove("appear");
    targetColor = null;
}

//--on mount--

//setto il primo bottone, per seganlare l'utente quale riga è attiva
guessesBtn[0].textContent = "Conferma";

// creo l'UI del input popup
let conteiner = null;
for (let i = 0; i < colori.length; i++) {
    if (i % (colori.length/2) == 0) {
        conteiner = document.createElement("div");
        conteiner.classList.add("selectContainer");
        colorPopup.appendChild(conteiner);
    }
    let option = document.createElement("div");
    option.classList.add("popupColor");
    option.style = ("background-color: " + colori[i]);
    option.addEventListener("click", ()=>{
        if (targetColor) {
            insert += (targetColor.style["backgroundColor"] === "") ? 1 : 0;  
            targetColor.style = ("background-color: " + colori[i]);
            fatherPopup.classList.add("sparire");
            boxes[0].classList.add("sparire");
            fatherPopup.classList.remove("appear");
        }
    })
    conteiner.appendChild(option);
}

//--events--

//per chiudere il messaggio di non riempito
errorBtn.addEventListener("click", ()=>{
    fatherPopup.classList.add("sparire");
    boxes[1].classList.add("sparire");
    fatherPopup.classList.remove("appear");
    allowed = true;
});

//per chiudere il menu di input
document.addEventListener("keydown", (e)=>{
    if (e.key == "Escape" && allowed) {
        removePopup();
    }
});

//evitare di chiudere il pop se si clicca la parte grigia del popup
for (let i = 0; i < boxes.length; i++) {
    boxes[i].firstElementChild.addEventListener("click", ()=>{
        clickInside = false;
    });
    boxes[i].addEventListener("click", ()=>{
        if (allowed && clickInside) {
            removePopup();
        }else{
            clickInside = true;
        }
    });   
}

//event lissner su le caselle di input 
selector.forEach(e => {
    e.addEventListener("click", ()=>{
        if (playArea.children[numberTrys-currentTry] === e.parentElement.parentElement.parentElement) {
            fatherPopup.classList.remove("sparire");
            boxes[0].classList.remove("sparire");
            fatherPopup.classList.add("appear");
            targetColor = e;
        }
    });
});

//logica conferma/invio per analisi
guessesBtn.forEach(e => {
    e.addEventListener("click", ()=>{
        //se non sono il tentativo corrente
        if (playArea.children[numberTrys-currentTry] !== e.parentElement) {
            return;
        }

        //se non ho inserito tutti gli i colori
        if (insert != lenSeq) {
            fatherPopup.classList.remove("sparire");
            boxes[1].classList.remove("sparire");
            fatherPopup.classList.add("appear");
            allowed = false;
            return;
        }

        insert = 0;
        currentTry--;
        let choices = [...e.parentElement.firstElementChild.children]; 
        let tempSeq = [...currentSeq];
        let curentColor = null;
        let correct = 0;
        e.disabled = true;

        //controllo quali sono corretti
        for (let i = 0; i < choices.length; i++) {
            curentColor = choices[i].firstElementChild.style["backgroundColor"];
            if (curentColor == tempSeq[i]) {
                choices[i].classList.add("corretto");
                choices.splice(i,1);
                tempSeq.splice(i,1);
                correct++;
                i--;
            }
        }

        //mostro nel pulsante quanti sono corretti
        e.textContent = correct;

        //win condition
        if (correct == lenSeq) {
            let scaleScore = ((currentTry + 1) / numberTrys);
            let gameScore = Math.floor(maxPoint * scaleScore * streak);
            punteggio += gameScore;
            pointTraker.textContent = "Punteggio: " + punteggio; 

            if (isLogged) {
                streak++;
                time = performance.now() - time;

                section.classList.remove("confetti");
                void section.offsetWidth;
                section.classList.add("confetti");

                //inserisco la partita
                updateScore(startTime, time, (numberTrys-currentTry), gameScore).then(r =>{
                    if (!r) {
                        alert("il punteggio non è stato salvato");
                    }
                });

                resetGame();
            }else{
                boxes[2].firstElementChild.firstElementChild.textContent = "Hai vinto!";
                boxes[2].firstElementChild.children[2].textContent += punteggio;
                fatherPopup.classList.remove("sparire");
                boxes[2].classList.remove("sparire");
                fatherPopup.classList.add("appear");
                allowed = false;
            }
            return;
        }

        // conto quali sono presenti
        for (let i = 0; i < choices.length; i++) {
            curentColor = choices[i].firstElementChild.style["backgroundColor"];
            let index = tempSeq.indexOf(curentColor);
            if (index >= 0) {
                choices[i].classList.add("presenza");
                choices.splice(i,1);
                tempSeq.splice(index,1);
                i--;
            }
        }

        //end game condition
        if (currentTry == 0) {
            boxes[2].firstElementChild.firstElementChild.textContent = "Hai perso :(";
            boxes[2].firstElementChild.children[2].textContent += punteggio; 
            fatherPopup.classList.remove("sparire");
            boxes[2].classList.remove("sparire");
            fatherPopup.classList.add("appear");
            allowed = false;
        }else{
            //metto il bottone successivo a conferma
            guessesBtn[numberTrys-currentTry].textContent = "Conferma";
        }
    });
});
