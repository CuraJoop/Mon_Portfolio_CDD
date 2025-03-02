document.getElementById('container');
const calculeIMC=(event)=>{
    event.preventDefault();
    let poids=parseFloat(document.getElementById('Poids').value);
    let taille=parseFloat(document.getElementById('Taille').value);

    if(isNaN(poids) || isNaN(taille) || poids<0 || taille<0){
        alert("veuillez saisir que des valeurs vaildent");
        return;
    }
    let calcul= poids/(Math.pow(taille,2));
    if(calcul<18.5){
        resultat=`vous etes en sous poids : ${calcul.toFixed()}` ;
    }
    else if(calcul>=18.5 && calcul<=24.9){
        resultat=`vous avez un poids normal : ${calcul.toFixed()}`;
    }
    else if(calcul>=25 && calcul<=29.9){
        resultat=`vous etes en pré-obesite :${calcul.toFixed()}`;
    }
    else if(calcul>=30){
        resultat=`vous etes en obesite severe :${calcul.toFixed()}`;
    }
    else{
        resultat="donnees invalides";
    }
        document.getElementById('resultat').innerHTML=resultat;
}
