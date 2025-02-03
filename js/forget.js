//--costanti--

//elemento contenitore della domanda
const displayDomanda = document.getElementById("display");
// casella di input del username
const inputUser = document.getElementById("username");

//--stati--

//timer per eveitare troppe chiamate al server
let debounceTimeout;

//--funzioni--

//funzione per prendere dal database la domanda di sicurezza corretta o una a caso
async function getQuestion(maybeUser) {
    if (maybeUser == ''){
        return null;
    }

    let data = 
        "userForget=" + encodeURIComponent(maybeUser);
    try{
        const risposta = await fetch("logic/question.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: data
        });

        if (risposta.ok){
            const data = await risposta.json();
            if (data.question) {
                return data.question;
            }else if (data.error) {
                console.error(data.error);
            }
        }else{
            alert("Qualcosa è andato male durante la comunicazione con server, ci scusiamo");
            console.error("Errore:", risposta.status);
        }
    }catch(error) {
        console.error("Errore di rete:", error);
    }
}

//--event--

// evento per prendere e mostrare la domanda a schermo
inputUser.addEventListener("input", () => {
    // Cancella il timeout precedente se l'utente continua a scrivere
    clearTimeout(debounceTimeout);  

    debounceTimeout = setTimeout(() => {
        getQuestion(inputUser.value).then(r =>{
            if (r) {
                displayDomanda.textContent = r;
            }
        }).catch(error =>{
            console.error(error);
        });
    }, 400);  
});