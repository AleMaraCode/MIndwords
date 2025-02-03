//--costanti--

//hidden inputs
const inputs = document.querySelectorAll("form input[type=text]");

//oggetti contenitori degli pseudo-radio
let options = document.querySelectorAll(".option");

//--funzioni--

//prende un valore in secondi e restitusce il valore in xh ym zs
function secondsToTime(seconds) {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let remainingSeconds = seconds % 60;

    let timeString = '';

    if (hours > 0) {
        timeString += hours + 'h ';
    }

    if (minutes > 0) {
        timeString += minutes + 'm ';
    }

    if (remainingSeconds > 0 || timeString === '') { // Include seconds even if 0 if no other units exist
        timeString += remainingSeconds + 's';
    }

    return timeString.trim(); // Rimuove eventuali spazi finali
}

//classe per la gestione dei grafici
class GraphDatas {
    constructor(Pointid, Trysid, Timeid, dataUser, colors) {

        this.#addEvents();

        this.canvas = [document.getElementById(Pointid), document.getElementById(Trysid), document.getElementById(Timeid)];
        this.context = [this.canvas[0].getContext('2d'), this.canvas[1].getContext('2d'), this.canvas[2].getContext('2d')];

        // se non sono forntti almeno i colori o i dati fallisco
        if (!dataUser || !colors) {
            return;
        }
        this.data = dataUser; 
        this.color = colors;

        //calcolo max
        this.max = [1, 1, 1];
        this.data.forEach(e => {
            let sessione = parseInt(e.totSessione);
            let trys = parseFloat(e.avgTentativi);
            if (this.max[2] < e.tempoMedio) {
                this.max[2] = e.tempoMedio;
            }

            if (this.max[1] < trys) {
                this.max[1] = trys;
            }

            if (this.max[0] < sessione) {
                this.max[0] = sessione;
            }
        });
    }
  
    //metodo privato per legare le canvas questi eventi
    #addEvents(){
        window.addEventListener("load", this.updateCanvas.bind(this));
        window.addEventListener("resize", this.updateCanvas.bind(this));
    }

    // aggiorno la dimezione della canvas in modo che sia reattiva
    updateCanvas(){
        let newWidth = window.innerWidth * 0.5;
        newWidth = newWidth < 320 ? 320 : newWidth;
        this.canvas.forEach(e => {
            e.width = newWidth;
        }); 
        this.plotData();
    } 

    //funzione per disegnare un pallino
    drawCircle(canvasid, x, y, radius, color) {
        if (canvasid < 0 || canvasid >= 3) {
            return;
        }
        this.context[canvasid].beginPath();
        this.context[canvasid].arc(x, this.canvas[canvasid].height - 10 - y, radius, 0, Math.PI * 2, false);
        this.context[canvasid].fillStyle = color;
        this.context[canvasid].fill();
        this.context[canvasid].closePath();
    }

    //funzione per drow una retta
    drawLine(canvasid, startX, startY, endX, endY, color){
        if (canvasid < 0 || canvasid >= 3) {
            return;
        }
        this.context[canvasid].beginPath();
        this.context[canvasid].moveTo(startX, this.canvas[canvasid].height - 10 -startY);
        this.context[canvasid].lineTo(endX, this.canvas[canvasid].height - 10 - endY);
        this.context[canvasid].strokeStyle = color
        this.context[canvasid].stroke();
        this.context[canvasid].closePath();
    }

    // funzione per scrivere 
    drawText(canvasid, text, x, y, color, font = "15px Calibri"){
        if (canvasid < 0 || canvasid >= 3) {
            return;
        }
        this.context[canvasid].font = font;
        this.context[canvasid].textAlign = "center"; 
        this.context[canvasid].fillStyle = color;
        this.context[canvasid].fillText(text, x, this.canvas[canvasid].height - 10 - y);
    }

    // funzione per stampare i dati su i grafici
    plotData(){
        if (!this.data) {
            return;
        }

        //data logic        
        let coordx = 21;
        let coordy;
        const offsetx = ((this.canvas[0].width - coordx - 23) / (this.data.length - 1));

        //console.log(maxTempo, maxSessione, maxTentati);
        let oldCord = [-1, -1, -1];
        for (let j = 0; j < this.data.length; j++) {
            const e = this.data[j];
            let row = [!e.totSessione ? 0 : parseInt(e.totSessione), !e.avgTentativi ? 0 : parseFloat(e.avgTentativi), e.tempoMedio]

            for (let i = 0; i < row.length; i++) {
                coordy = 7 + (row[i] / this.max[i]) * (this.canvas[i].height - 40) ;
                if (oldCord[i] >= 0) {
                    this.drawLine(i, coordx - offsetx, oldCord[i], coordx, coordy, this.color[i]);
                }
                this.drawCircle(i, coordx, coordy, 5, this.color[i]);
                if (i == 2) {
                    this.drawText(i, secondsToTime(row[i]) , coordx, coordy + 10, this.color[i], "11px Calibri");
                } else{
                    this.drawText(i, row[i], coordx, coordy + 10, this.color[i]);
                }
                
                oldCord[i] = coordy;
            }
            coordx += offsetx;
        }
    }
}

//--on mount--

//instanziamento classe
const grafici = new GraphDatas('punteggio', 'tentativi', 'tempo', userData, ['#4CAF50', '#FF9800', '#2196F3']);

//--eventi--

//funzione per la gestione dei selettori di difficoltà e modalità
for (let i = 0; i < options.length; i++) {
    for (let j = 0; j < options[i].children.length; j++) {
        let elem = options[i].children[j]; 
        if (elem.nodeName == "P") {
            elem.addEventListener("click", function(){
                for (let k = 0; k < options[i].children.length; k++) {
                    options[i].children[k].classList.remove("selected");
                }
                this.classList.add("selected");
                inputs[i].value = j;
            });
        }
    }
    
}