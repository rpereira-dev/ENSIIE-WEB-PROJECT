/** déconnectes l'utilisateur  */
function disconnect() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", 'disconnect.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                toast("Déconnecté(e). Vous allez être redirigé(e).", 2);
                setTimeout(function () { window.location.replace(window.location.href); }, 1000);
            } else {
                toast("Une erreur innatendue a eu lieu", 0);
            }
        }
    }
    xhr.send();
}