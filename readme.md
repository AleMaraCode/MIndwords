# Informazioni sul sito

Questa sezione descrive le funzionalità e il comportamento del sito.

## Introduzione

* Mindworks offre attualmente due giochi: Wordle e Mastermind. È possibile giocare a entrambi senza registrazione o login, ma in tal caso le partite saranno singole, e una volta completate si tornerà al menu principale senza memorizzare il punteggio.
* Effettuando il login, invece, si potrà accedere a funzionalità aggiuntive e alla modalità infinita, che in caso di vittoria proporrà una nuova sequenza, e così fino alla sconfitta. In modalità infinita, il punteggio sarà calcolato in base alla difficoltà selezionata e al numero di partite vinte consecutivamente.
* Per migliorare l'accessibilità, il sito include una modalità a tema chiaro, accessibile tramite il footer, ed il sito è completamente responsive.

## Giochi

> Il sito attualmente offre due giochi per cui è possibile impostare individualmente la difficoltà in termini di lunghezza della sequenza e numero di tentativi. Aumentando la difficoltà dei tentativi, il loro numero diminuirà; aumentando la lunghezza della sequenza, questa sarà più lunga, e viceversa.

### Wordle

- Il gioco consiste nell'indovinare la parola segreta nel minor numero di tentativi possibile. Si può usare la tastiera virtuale a schermo o quella fisica. Inserendo una parola e premendo Invio, il colore delle caselle e dei tasti della tastiera virtuale cambierà in base alla correttezza delle lettere e della loro posizione:
    - **Verde** → posizione corretta
    - **Giallo** → presente, ma in posizione errata
    - **Grigio** → non presente

### Mastermind

- Gioco simile a Wordle ma basato sui colori. Ogni riga corrsponde a un tentativo, il primo tentativo è la riga in cima, utilizzano un tentativo ci si sposta di una riga verso il basso. Cliccando su una casella della riga del tentativo apparirà un menu con tutti i colori disponibili. Una volta inseriti i colori in tutte le caselle della riga corrente, si può confermare premendo il tasto "Conferma" nella riga. Questo mostrerà quanti colori sono corretti, e i bordi delle caselle si evidenzieranno in base alla loro correttezza di:
    - **Verde** → posizione corretta
    - **Giallo** → presente, ma in posizione errata
    - **Grigio** → non presente

## Parte utente

### Account

* Qualsiasi utente può registrarsi a Mindworks inserendo un nome utente, una password e una domanda di sicurezza con risposta, per il recupero della password in caso di smarrimento.
* Una volta effettuato il login, al posto del link alla pagina di login sarà disponibile un collegamento alla propria pagina utente, dove si possono visualizzare le statistiche delle ultime 15 partite giocate in modalità infinita tramite grafici. I grafici mostrano il punteggio totale, il numero medio di tentativi e il tempo medio. Accedere a una pagina di gioco da loggati conta come una partita, e se la pagina viene ricaricata senza fare tentativi corretti, verrà considerata come partita con punteggio zero. Sono presenti anche classifiche tra gli amici per ciascuna modalità di gioco.
* È presente una pagina per la gestione delle amicizie, accessibile dalla sezione della classifica. Tramite una barra di ricerca, è possibile trovare utenti digitando una parte del loro nome utente. Cliccando sul nome, si può inviare una richiesta di amicizia. Le richieste ricevute saranno sempre visibili in questa pagina, dove si potranno accettare o rifiutare. Nel caso in cui entrambi gli utenti si mandino una richiesta di amicizia, questa verrà automaticamente accettata.
