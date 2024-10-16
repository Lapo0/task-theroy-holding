# Laravel Livewire Jetstream Task-Theory-Holding

## Descrizione del Progetto
Questo progetto, sviluppato con Laravel Livewire Jetstream, permette agli utenti di creare un profilo, interagire con altri utenti, e gestire i propri post. 
L'interfaccia del progetto presenta una schermata iniziale che introduce il sito e permette la registrazione dell'utente. Dopo la registrazione, gli utenti possono accedere a una dashboard interattiva dove possono interagire con post propri e degli altri utenti.

## Funzionalità Principali
### Gestione Utente
- **Registrazione e Accesso**: Gli utenti possono registrarsi fornendo nome, email e password. Dopo la registrazione, gli utenti devono verificare il loro indirizzo email per accedere alla dashboard.
- **Gestione Profilo**: Una volta loggati, gli utenti possono:
  - Caricare e aggiornare la propria immagine di profilo.
  - Visualizzare e modificare le proprie informazioni, come nome e email (con necessità di una nuova verifica per l'email modificata).
  - Cambiare la password direttamente dal proprio profilo, senza bisogno di link di verifica.
  - Abilitare l'autenticazione a due fattori (2FA) per una maggiore sicurezza.
  - Terminare tutte le sessioni attive.
  - Eliminare il proprio account inserendo la password per la conferma.

### Dashboard Utente
- **Visualizzazione Attività**: Gli utenti possono visualizzare l'attività degli altri utenti nella dashboard.
- **Gestione Post**:
  - I post possono essere modificati o eliminati dall'utente proprietario in qualsiasi momento.
  - Gli utenti possono mettere "Mi piace" o salvare i post di altri utenti o i propri post.
  - I post possono essere filtrati per mostrare "Tutti i post", "Post che mi piacciono" o "Post salvati".

### Gestione dei Post
- **Pagina Post**: Esiste una sezione specifica dove l'utente può visualizzare tutti i propri post, con la possibilità di:
  - Creare nuovi post con anteprima del contenuto come apparirà pubblicato.
  - Modificare post esistenti.
  - Eliminare post propri direttamente dalla dashboard o dall'anteprima.

## Installazione del Progetto
Per installare e utilizzare questo progetto, è necessario avere una configurazione di Laravel con Livewire Jetstream. Segui i passaggi sotto per iniziare:

1. Clona questo repository:
   ```bash
   git clone <repository-url>
   cd <repository-folder>
   ```
2. Installa le dipendenze usando Composer:
   ```bash
   composer install
   ```
3. Installa le dipendenze NPM:
   ```bash
   npm install && npm run dev
   ```
4. Configura il file `.env`:
   - Copia il file `.env.example`:
     ```bash
     cp .env.example .env
     ```
   - Configura le variabili di ambiente come il database e il sistema di posta elettronica.
5. Genera la chiave dell'applicazione:
   ```bash
   php artisan key:generate
   ```
6. Esegui le migrazioni per creare il database:
   ```bash
   php artisan migrate
   ```
7. Avvia il server locale:
   ```bash
   php artisan serve
   ```
   Ora puoi accedere al progetto su `http://localhost:8000`.

## Tecnologie Utilizzate
- **Laravel**: Framework PHP utilizzato per la gestione del backend.
- **Livewire**: Usato per creare interazioni dinamiche senza necessità di scrivere JavaScript.
- **Jetstream**: Gestisce l'autenticazione e le funzionalità di gestione utente.