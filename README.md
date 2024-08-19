# IliadDev

## Requisiti

### Software

1. **Docker**: (https://www.docker.com/products/docker-desktop).
2. **Docker Compose**: Necessario per gestire i servizi multi-container. Generalmente viene incluso con Docker Desktop.
3. **npm**: Node Package Manager, per gestire le dipendenze di Angular. Installabile da [Node.js](https://nodejs.org/).
4. **Composer**: Per gestire le dipendenze di PHP e Symfony. Scaricabile [qui](https://getcomposer.org/).
5. **WSL (Windows Subsystem for Linux)**: Se usi Windows, configura WSL per eseguire i comandi Linux nativi. La guida si trova [qui](https://docs.microsoft.com/en-us/windows/wsl/install).

### Librerie e Strumenti

1. **Symfony 7.1**: Utilizzato per il backend e la gestione delle API.
2. **Angular 17.0**: Utilizzato per il frontend e l'interfaccia utente.
3. **Clarity Design System**: Fornisce componenti UI per Angular.
4. **PostgreSQL**: Database open source, utilizzato per la gestione dei dati

### Sistema

1. Per il progetto è stato utilizzato Windows 11.
2. Assicurarsi che le porte 4200 (per il frontend), 8000 (per il backend) e 5432 (per il database) siano libere

## installazione ed avvio del Progetto

1. Eseguire docker e lanciare il motore di gestione dei container.
2. Clonare il repository nella cartella desiderata e posizionarsi al suo interno.

### Metodo 1: Utilizzare l'Eseguibile `start.bat`

1. **Esegui il file `start.bat`**:
   - Nella radice del progetto, fai doppio clic sul file `start.bat` per avviare il progetto. Questo eseguibile costruirà e avvierà i contenitori Docker necessari per il progetto.

### Metodo 2: Utilizzare PowerShell

1. **Apri PowerShell**:
   - Posizionati sulla radice del progetto utilizzando il terminale PowerShell.

2. **Esegui il Comando Docker**:
   - Lancia il seguente comando per costruire e avviare i contenitori Docker: