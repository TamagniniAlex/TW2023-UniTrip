<?php
function login($nickname_mail, $password, $mysqli)
{
    // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
    $nickname = "";
    $db_password = "";
    $salt = "";

    if (!strstr($nickname_mail, '@')) { 
        if($stmt = $mysqli->prepare("SELECT mail FROM profile WHERE nickname = ? LIMIT 1")){
            $stmt->bind_param('s', $nickname_mail); 
            $stmt->execute(); // esegue la query appena creata. 
            $stmt->store_result(); 
            $stmt->bind_result($nickname_mail); // recupera il risultato della query e lo memorizza nelle relative variabili. 
            $stmt->fetch(); 
        }
    } 
    $nickname = $nickname_mail;

    if ($stmt = $mysqli->prepare("SELECT nickname, password, salt FROM profile WHERE mail = ? LIMIT 1")) {
        // esegue il bind del parametro '$email'.
        $stmt->bind_param('s', $nickname);
        $stmt->execute(); // esegue la query appena creata.
        $stmt->store_result();
        $stmt->bind_result($nickname, $db_password, $salt); // recupera il risultato della query e lo memorizza nelle relative variabili.
        $stmt->fetch();
        $password = hash('sha512', $password . $salt); // codifica la password usando una chiave univoca.
        if ($stmt->num_rows == 1) { // se l'utente esiste
            // verifichiamo che non sia disabilitato in seguito all'esecuzione di troppi tentativi di accesso errati.
            if (checkbrute($nickname, $mysqli) == true) {
                // Account disabilitato
                // Invia un e-mail all'utente avvisandolo che il suo account è stato disabilitato.
                return 0;
            } else {
                if ($db_password == $password) { // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
                    // Password corretta!            
                    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.
                    $nickname = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $nickname); // ci proteggiamo da un attacco XSS
                    $_SESSION['nickname'] = $nickname;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    // Login eseguito con successo.
                    return 1;
                } else {
                    $now = time();
                    $mysqli->query("INSERT INTO LoginAttempts (nickname, time) VALUES ('$nickname', '$now')");
                    return 0;
                }
            }
        } else {
            // L'utente inserito non esiste.
            return 0;
        }
    }
}
function checkbrute($nickname, $mysqli)
{
    $now = time();
    // Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
    $valid_attempts = $now - (2 * 60 * 60);
    if ($stmt = $mysqli->prepare("SELECT time FROM LoginAttempts WHERE nickname = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('s', $nickname);
        $stmt->execute();
        $stmt->store_result();
        // Verifico l'esistenza di più di 5 tentativi di login falliti.
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}