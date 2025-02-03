//--oggetti--

//lente di ingrandimento
const img = document.getElementById("mGlass");
//casella dove sono iseriti i risulatti della ricerca
const result = document.getElementById("result");
//input della ricerca
const search = document.getElementById("search");
//pulsanti per il rifiuto
const decline = document.querySelectorAll(".rifiuta");
//pulisanti per l'accetare
const accept = document.querySelectorAll(".accetta");

//--stati

// variabile temporanea che eveita che vengano fatte troppe richieste al server
let debounceTimeout;

//--funzioni

//prendo utenti che contengono quella sotto string
async function getSubString(subString) {
    if (subString == ''){
        return null;
    }

    let data = 
        "substring=" + encodeURIComponent(subString)+
        "&sender=" + encodeURIComponent(user);
    try{
        const risposta = await fetch("logic/substring.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: data
        });

        if (risposta.ok){
            const data = await risposta.json();
            if (data.users) {
                return data.users;
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

// funzione per inviare la richiesta al utente selezionato
async function sendFriendReq(who) {
    let data = 
        "who=" + encodeURIComponent(who) +
        "&sender=" + encodeURIComponent(user);
    try{
        const risposta = await fetch("logic/sendreq.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: data
        });

        if (risposta.ok){
            const data = await risposta.json();
            if (data) {
                if (data.error) {
                    console.error(data.error);   
                }else {
                    return data.success;
                }
            }
            
        }else{
            alert("Qualcosa è andato male durante la comunicazione con server, ci scusiamo");
            console.error("Errore:", risposta.status);
        }
    }catch(error) {
        console.error("Errore di rete:", error);
    }
}

//funzione per accettare la richeista
async function acceptFriend(who) {
    let data = 
        "who=" + encodeURIComponent(who) +
        "&sender=" + encodeURIComponent(user);
    try{
        const risposta = await fetch("logic/acceptfriend.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: data
        });

        if (risposta.ok){
            const data = await risposta.json();
            if (data.error) {
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

//funzione per rifiutare la richiesta
async function refuseFriend(who) {
    let data = 
        "who=" + encodeURIComponent(who) +
        "&sender=" + encodeURIComponent(user);
    try{
        const risposta = await fetch("logic/refusefriend.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: data
        });

        if (risposta.ok){
            const data = await risposta.json();
            if (data.error) {
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

//--on mount

//per aggioranre l'icona della lente con il tema correte
if (!theme) {
    img.classList.add("invert");
}

// evento per fare la richerca dinamica sull'input
search.addEventListener("input", () => {
    // Cancella il timeout precedente se l'utente continua a scrivere
    clearTimeout(debounceTimeout);  

    debounceTimeout = setTimeout(() => {
        getSubString(search.value).then(r => {
            result.textContent = '';
            if (r) {
                r.forEach(e => {
                    let div = document.createElement("div");
                    div.textContent = e;
                    div.addEventListener("click", ()=> {
                        sendFriendReq(e).then((r)=> {
                            result.removeChild(div);
                            // se ho accettato una richeista inseredno ricarco
                            if (r) {
                                location.reload();
                            }
                        });
                    });
                    result.append(div);
                });
            }  
        });
    }, 300);  
});

// attacco l'evento per l'accetatzione dell'amicizia a tutte le richeiste ricevute
for (let i = 0; i < accept.length; i++) {
    accept[i].addEventListener("click", ()=>{
        acceptFriend(sender[i]).then(()=>{
            location.reload();
        });
    });
}

// attacco l'evento per il rifiuto dell'amicizia a tutte le richeiste ricevute
for (let i = 0; i < decline.length; i++) {
    decline[i].addEventListener("click", ()=>{
        refuseFriend(sender[i]).then(()=>{
            location.reload();
        });
    });
}

// aggiorno la lente di ingradimento se cambio il tema tema
ThemeBtn.addEventListener("click", ()=>{
    img.classList.toggle("invert");
});
