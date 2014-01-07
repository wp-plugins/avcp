=== AVCP XML ===
Contributors: Milmor
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F2JK36SCXKTE2
Tags: avcp, autorita, vigilanza, lavori, pubblici, amministrazione, trasparente, legge, obblighi, marco, milesi, normativa, pubblicazione
Requires at least: 3.3
Tested up to: 3.8
Version: 2.3
Stable tag: 2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Generatore XML per l’AVCP (Autorità per la Vigilanza sui Contratti Pubblici di Lavori, Servizi e Forniture) // Art. 1 comma 32 Legge 190/2012.


== Description ==

> Questo plugin non supporta i raggruppamenti temporanei di impresa. In futuro questa funzione potrebbe essere aggiunta!

Dopo il positivo feedback ricevuto per il plugin [Amministrazione Trasparente](http://wordpress.org/plugins/amministrazione-trasparente/), è arrivato su Wordpress.org anche il nuovo software per l'adeguamento normativo richiesto per l’Autorità per la Vigilanza sui Contratti Pubblici di Lavori, Servizi e Forniture, conforme alle specifiche tecniche ai sensi dell’art. 1 comma 32 Legge n. 190/2012. Sulla scia di Amministrazione Trasparente questo plugin, costantemente aggiornato, è focalizzato su flessibilità, semplicità e intuitività nell'aggiornamento delle informazioni, direttamente dall'interfaccia di amministrazione di Wordpress.

AVCP XML per Wordpress è il più semplice e intuitivo software per la gestione dei bandi di gara attualmente presente nel panorama open-source. Sfruttando le potenzialità native del cms su cui è sviluppato, questo plugin presenta un'interfaccia familiare che può essere sfruttata anche dai principianti di questa piattaforma, presentandosi come soluzione ideale per i siti della pubblica amministrazione "Powered by Wordpress" e per tutti gli enti che desiderano una soluzione gratuita, stabile, aggiornata e supportata. ...E installabile in pochi secondi!!

= Funzioni =
* Creazione e gestione dei bandi di gara tramite Custom Post Type (stessa impostazione di pagine e articoli)
* Creazione e gestione delle ditte tramite Taxonomy (tassonomia, stessa impostazione delle categorie)
* Assegnazione ditte partecipanti e aggiudicatari direttamente nella pagina di creazione del bando
* Generazione di tabelle di riepilogo tramite shortcode [avcp] // [avcp anno="2013"] // [avcp anno="%%%%"]
* Generazione **automatica** o manuale dei file XML per la trasmissione ad AVCP, suddivisi per anno
* Codice leggero, commentato e facilmente modificabile
* Compatibilità completa per i temi Wordpress
* Generazione di dataset .xml vuoti

= Caratteristiche Salienti =
Oltre all'adempimento degli obblighi di legge, AVCP XML per Wordpress offre alcune funzioni in grado di dare valore aggiunto al vostro operato:

* Visualizzazione pubblica dei file .xml in una pagina dedicata: www.example.com**/avcp**
* Visualizzazione singola delle voci, con possibilità di aggiunta testo a piacere, documenti, link,...
* Visualizzazione **archivio** di tutte le gare partecipate da ogni ditta [opzionale]

= Idee di sviluppo future =
* Importazione gare e ditte da file csv/excel
* Controllo validazione XML

= BACKUP & RIPRISTINO =
AVCP XML permette il backup e il ripristino nativo delle voci dei bandi (per trasferimento sito Wordpress o solo per avere una copia di sicurezza). Accedendo a Strumenti -> Esporta è possibile scaricare il file xml di backup (da non confondere con quello generato per l'avcp, che ha una struttura completamente diversa). Per il ripristino delle voci in un altro sito è sufficiente caricare questo file in un'altra installazione utilizzando il menù Strumenti -> Importa

= CONTATTI & SUPPORTO =
Per qualsiasi informazione, per segnalare problemi o per suggerire nuove funzioni, è attivo il forum di supporto su [www.marcomilesi.ml/supporto](http://marcomilesi.ml/supporto/)

> **ATTENZIONE** | **"For each author’s protection [***] we want to make certain that everyone understands that there is no warranty for this free software.** In accordo con la licenza GPL v.2 con cui questo software viene fornito, **declino** ogni responsabilità per eventuali inadempimenti legislativi e/o altri problemi legali e/o tecnici derivanti, implicitamente o esplicitamente, dall'utilizzo di questo plugin Wordpress o da un'affrettata configurazione dello stesso (ivi compresi eventuali aggiornamenti). E' compito del gestore del sito assicurarsi che il modulo funzioni correttamente e adempia agli obblighi di legge e, al contempo, è obbligo degli operatori/impiegati/dipendenti/funzionari preposti alla gestione dell'Amministrazione Trasparente la pubblicazione degli opportuni dati.

> **EN** | This plugin is developed for **schools, universities, municipalities and local authorities** of **ITALY** and respects their legal parameters. The installation of this plugin on amateur websites and/or portals not subject to 'Amministrazione Trasparente' legislation is a waste of time since the purpose of this software is the posting of data in a legal and validated way.

== Installation ==

1. Carica il contenuto estratto nella cartella `/wp-content/plugins/`
2. Attiva il plugin dal menu 'Plugins' in WordPress
3. Aggiungi le informazioni dell'ente in AVCP -> Impostazioni
4. Dai un'occhiata alle altre impostazioni
5. Predisponi un'area del sito in cui mostrare l'elenco dei bandi (per assolvere anche all'obbligo di pubblicazione sul sito istituzionale). Di seguito trovi tutte le informazioni nella sezione **Shortcode**
6. Inserisci le ditte, con Codice Fiscale/Partita IVA, dal menù AVCP -> Ditte
7. Inserisci le gare, avendo cura di riempire in modo corretto tutti i campi, dal menù AVCP -> Nuova Gara
8. Per la generazione del file .xml e la sua comunicazione all'Avcp, leggi il paragrafo successivo

= SHORTCODE =
AVCP XML permette, oltre alla creazione del file xml per la trasmissione ad AVCP, di assolvere anche l'obbligo di pubblicazione delle informazioni sul sito istituzionale. E' infatti possibile utilizzare lo shortcode [avcp] in una pagina/articolo per visualizzare una tabella (con funzioni di filtraggio avanzate) contenente tutti i bandi.
E' possibile configurare lo shortcode inserendo il parametro dell'anno:

* [avcp] -> Mostra una lista di **tutti** i bandi (può rallentare il caricamento della pagina in presenza di molte informazioni
* [avcp anno="2013"] -> Mostra una lista dei bandi relativi all'anno impostato. L'anno preso in considerazione **non** è la data di pubblicazione del bando, ma l'**anno di riferimento** che si inserisce creando il nuovo bando.

= GENERAZIONE FILE .XML E COMUNICAZIONE AD AVCP =

= SYSTEM CHECK-UP =
AVCP XML integra, nella pagina delle impostazioni, un piccolo sistema di auto-diagnostica che permette di conoscere facilmente se la configurazione del server permette il corretto funzionamento del plugin. In particolare vengono effettuati 4 test:

* 1. Presenza della cartella www.miodominio.com**/avcp** (creata dal plugin durante l'attivazione).
* 2. Permessi di scrittura/lettura della cartella precedente (impostati dal plugin durante l'attivazione).
* 3. Presenza del file index.php nella cartella precedente (copiato dal .zip del plugin alla cartella /avcp durante l'attivazione).
* 4. Controllo dell'effettivo accesso pubblico al link

Se tutti i parametri vengono rispettati, accanto alle 4 voci precedenti compare la dicitura 'OK'. In caso contrario, il sistema avvisa di un problema critico. Se questo dovesse accadere, è probabile che la cartella /avcp o i file in essa contenuti siano stati rimossi o spostati mentre il plugin era attivo e per ricrearli è sufficiente disattivare e riattivare il plugin, avendo poi cura di ricontrollare se "System Check-UP" indica che gli errori sono stati risolti.

**Attenzione! Anche i file .xml generati dal plugin vengono salvati nella cartella /avcp quindi è necessario ricreare questi file avviando rigenerando manualmente il dataset .xml da AVCP -> Impostazioni**.
Se dopo questi passaggi "System Check-UP" rileva ancora alcuni problemi, è probabile che il server non sia configurato correttamente. In questo caso usa il forum di supporto www.marcomilesi.ml/supporto

== Screenshots ==

1. Pagina di gestione delle gare (back-end)
2. Inserimento guidato delle informazioni
3. Semplici e intuitive impostazioni
4. Menù del plugin
5. Esempio pagina /avcp contenente i file .xml generati
6. Tabella generata con lo shortcode [avcp] configurabile per anno

== Changelog ==
> Questa è la lista completa di tutti gli aggiornamenti, test e correzioni. Ogni volta che una nuova versione viene rilasciata assicuratevi di aggiornare il prima possibile per usufruire delle ultime migliorie!

= Versione 2.3 8/01/2014 =
* **Rinnovata** visualizzazione singola bandi di gara, con visualizzazione aggiudicatari

= Versione 2.2 7/01/2014 =
* **Corretto** errore scrittura xml del codice fiscale e nome ditta aggiudicataria (erano invertiti) [!]
* **Corretta** mancata generazione automatica file .xml al salvataggio/pubblicazione di una gara
* Validazione automatica .xml rivista completamente per migliorare le performance del sito (non più lanciata in admin_init)
* **Migliorata** leggibilità dei messaggi

= Versione 2.1 6/01/2014 =
* **Corretti** errori di generazione della tabella shortcode filtrata per anno
* Aggiunto Anno di riferimento 2012
* **Migliorata** pagina delle impostazioni
* **Rimossa** opzione per disabilitare il caricamento aggiuntivo di css (dalla versione 2 è javascript richiesto)
* **Aggiunto** sistema di validazione AVCP (75% accuratezza), con notifica opzionale in caso di errore
* **Corretta** mancata scrittura <entePubblicatore> nella testata del file .xml

= Versione 2.0.3 2/01/2014 =
* Modifica nome immagine case-sensitive

= Versione 2.0.2 =
* Modifica nome immagine case-sensitive

= Versione 2.0.1 =
* Aggiunto file mancante (svista)

= Versione 2.0 2/01/2014 =
* **Corretta** errata generazione dell'url xml nel dataset
* **Corretta** errata generazione delle ditte partecipanti // Grazie Gianni Cepollina
* **Aggiunta** validazione campi data delle gare con obbligo di scelta dal calendario (input readonly)
* Nuovo sistema di gestione degli anni di riferimento: adesso vengono creati dal plugin (richiede step di aggiornamento 1.2 aggiuntivo)
* Corretto messaggio di errore "FATAL ERROR" causato da una continua chiamata dell' hook save_post
* **Corretti** valori "sceltacontraente" scritti nel dataset .xml
* **Corretto** orario generazione scritto nel dataset .xml
* **Aggiunta** generazione di file .xml vuoti
* Testato con WP 3.8

= Versione 1.1.2 30/12/2013 =
* **Corretto** conflitto con il plugin Amministrazione Trasparente che impediva il caricamento della funzione di ricerca nel metabox tipologie (Nuova Voce)

= Versione 1.1.1 28/12/2013 =
* **Corretto** problema di mancata generazione della data corretta nel file .xml [!]
* Data in formato d F Y nella visualizzazione singola del bando di gara

= Versione 1.1 19/12/2013 =
* **Migliore** notifica della creazione del file .xml
* Corretto Problema visualizzazione back-end dei Codici Fiscali
* Corretta scrittura partecipanti/aggiudicatari nel file .xml
* Rimosse alcune modifiche css per il backend
* Metabox anno di riferimento giallo!
* Rimosso il metabox "Campi Personalizzati" mostrato da Wordpress nella pagina di modifica delle gare (causava confusione)

= Versione 1.0.4 15/12/2013 =
* Corretti bug causa di possibili conflitti (taxfilteringbackend.php + avcp_metabox_generator.php)
* Rimossi 2 file .php attualmente inattivi

= Versione 1.0.3 10/12/2013 =
* Risolto bug mancata visualizzazione campi nella vista singola

= Versione 1.0.2 10/12/2013 =
* Migliore stile per System Check-up
* Forzato CHMOD del file /avcp/index.php - 0755
* Aggiunto parametro di controllo al System Check-up

= Versione 1.0.1 9/12/2013 =
* Correzione file readme.txt
* Nascosti i campi per la creazione gerarchica delle tassonomie, per evitare possibili conflitti

= Versione 1.0 9/12/2013 =
* Prima versione rilasciata

= 20/10/2013 =
* **Pubblicazione** sul repository WP.ORG per inizio fase di sviluppo/testing

(!) = Aggiornamento Importante (Sicurezza/Stabilità)
[!] = Nuova generazione del file .xml necessaria per adempiere agli obblighi normativi