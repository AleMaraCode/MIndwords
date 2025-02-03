//convert ms in time
function msToTime(milliseconds) {
    let totalSeconds = Math.floor(milliseconds / 1000);
    
    let hours = Math.floor(totalSeconds / 3600);
    let minutes = Math.floor((totalSeconds % 3600) / 60);
    let seconds = totalSeconds % 60;
    
    let timeString = 
        String(hours).padStart(2, '0') + ':' + 
        String(minutes).padStart(2, '0') + ':' + 
        String(seconds).padStart(2, '0');

    return timeString;
}

// Funzione per aggiornare il punteggio della partita
export async function updateScore(startTime, time, currentTrys, gameScore) {

    let EndData = 
    "user=" + encodeURIComponent(user) + 
    "&inizio=" + encodeURIComponent(startTime) + 
    "&tempo=" + encodeURIComponent(msToTime(time)) + 
    "&tryes=" + encodeURIComponent(currentTrys) + 
    "&punteggio=" + encodeURIComponent(gameScore);

    try{
        const risposta = await fetch("logic/setscore.php", {
            method: "POST", 
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: EndData 
        })

        if (risposta.ok){
            const data = await risposta.json();
            if (data.ok) {
                return data.ok;
            }else if (data.error){
                console.error(data.error);
            }
        }else{
            console.error("Errore:", risposta.status);
        }
    }catch(error) {
        console.error("Errore di rete:", error);
    }
}
