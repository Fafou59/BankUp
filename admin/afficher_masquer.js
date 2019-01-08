function afficher_cacher(id)
(
    if(document.getElementById(id).style.visibility=="hidden")
    (
        document.getElementById(id).style.visibility="visible";
        document.getElementById('bouton_texte').innerHTML='cacher le texte';
    )
    else
    (
        document.getElementById(id).style.visibility="hidden";
        document.getElementById('bouton_texte').innerHTML='Afficher le texte';
    )
    return true;
)