//--costanti--

//definisco gli elementi per mostrare la la difficolatà, aumentarla e diminuirla 
const masterInputTrys = document.querySelector("#masterTrys");
const masterUpTrys = document.querySelector("#masterUpTrys");
const masterDownTrys = document.querySelector("#masterDownTrys");

const masterInputLen = document.querySelector("#masterLen");
const masterUpLen = document.querySelector("#masterUpLen");
const masterDownLen = document.querySelector("#masterDownLen");

const wordleInputTrys = document.querySelector("#wordleTrys");
const wordleUpTrys = document.querySelector("#wordleUpTrys");
const wordleDownTrys = document.querySelector("#wordleDownTrys");

const wordleInputLen = document.querySelector("#wordleLen");
const wordleUpLen = document.querySelector("#wordleUpLen");
const wordleDownLen = document.querySelector("#wordleDownLen");

//--eventi--
// per diminuire la difficolta
function down(downButton, target) {
    downButton.addEventListener("click", ()=>{
        if (target.value === "Difficile") {
            target.value = "Normale";
        }else{
            target.value = "Facile";
        }
    }); 
}

//per aumenatre la difficolta
function up(upButton, target) {
    upButton.addEventListener("click", ()=>{
        if (target.value === "Facile") {
            target.value = "Normale";
        }else{
            target.value = "Difficile";
        }
    }); 
}

// bindo gli eventi hai parametri
down(masterDownTrys, masterInputTrys);
up(masterUpTrys, masterInputTrys);

down(masterDownLen, masterInputLen);
up(masterUpLen, masterInputLen);

down(wordleDownTrys, wordleInputTrys);
up(wordleUpTrys, wordleInputTrys);

down(wordleDownLen, wordleInputLen);
up(wordleUpLen, wordleInputLen);



