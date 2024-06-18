let bloqueRegistro = document.getElementById("formulariRegistre");
let bloqueInicio = document.getElementById("formulariInici");
let bloqueCalculadora = document.getElementById("calculadora");
let c1 = document.getElementById("capsa1");
let c2 = document.getElementById("capsa2");
let c3 = document.getElementById("capsa3");
let c4 = document.getElementById("capsa4");
let c5 = document.getElementById("capsa5");
let c6 = document.getElementById("capsa6");
let campNom = document.getElementById("infoNom");

//-----ARRAYS

let consulta = [];
let operacionHistorial = [];
let fechaOperacion = [];
let tiempoOperacion = [];

//-----FORMULARI DE REGISTRE

let usuario = [
    {
        usr: " ", 
        passwd: " "
    } 
];

let botonRegistro = document.getElementById("registrar");

botonRegistro.addEventListener("click", () => {
    let nomRegistre = document.getElementById("usuari");
    let contra = document.getElementById("contra");

    let longitudUsuari = nomRegistre.value;
    let longitudContra = contra.value;

    /*
    if((longitudUsuari.length < 8) || (longitudContra.length < 4) || (longitudContra.length > 4) || (longitudUsuari != longitudUsuari.replace(/\s+/g, "")) || isNaN(contra.value) == true){
        alert("Les dades son errònies, prova-ho de nou.");
    }else{
        usuario.usr = nomRegistre.value;
        usuario.passwd = contra.value;
        c1.style.display = 'none';
        c2.style.display = 'block';
        campNom.innerHTML = "Usuari: " + nomRegistre.value;
    }
    */

    if(longitudUsuari.length < 8){
        alert("Nom d'usuari massa curt!");
    }else if(longitudContra.length < 4){
        alert("Contrasenya massa curta!");
    }else if(longitudUsuari != longitudUsuari.replace(/\s+/g, "")){
        alert("El nom d'usuari no pot contenir espais!");
    }else if(isNaN(contra.value) == true){
        alert("La contrasenya no pot contenir lletres!");
    }else{
        usuario.usr = nomRegistre.value;
        usuario.passwd = contra.value;
        c1.style.display = 'none';
        c2.style.display = 'block';
        campNom.innerHTML = "Usuari: " + nomRegistre.value;
    }

});

//-----INICI DE SESSIÓ

let iniciUsuari = document.getElementById("usuariInici");
let iniciContra = document.getElementById("contraInici");
let botoInici = document.getElementById("iniciar");

botoInici.addEventListener("click", () => {
    if((iniciUsuari.value == usuario.usr) && (iniciContra.value == usuario.passwd)){
        c2.style.display = 'none';
        c3.style.display = 'block';
        c5.style.display = 'block';
    }else{
        alert("Error!");
    }
});

//-----CALCULADORA
let texto = document.getElementById("title");
let boton = document.getElementsByClassName("boton");
let operacion = document.getElementsByClassName("operador");
let resultado = document.getElementById("resultat");
let botonSup = document.getElementsByClassName("botonSuperior");

//-----FOCUS

document.addEventListener("keydown", () => {
    texto.focus();
});

//---- BOTONES SUPERIORES

botonSup[0].addEventListener("click", () => {
    if(texto.value == usuario.passwd){
        c3.style.display = 'none';
        c4.style.display = 'block';
        c6.style.display = 'none';
        botoTornar.style.display = 'block';
    }else{
        alert("Contrasenya incorrecta!");
    }
});

botonSup[1].addEventListener("click", () => {
    texto.value = texto.value.slice(0,-1);
});

botonSup[2].addEventListener("click", () => {
    texto.value = " ";
});

botonSup[3].addEventListener("click", () => {
    location.reload();
});

//---- NUMEROS 
boton[0].addEventListener("click", () => {
    texto.value = texto.value + boton[0].innerHTML;
});

boton[1].addEventListener("click", () => {
    texto.value = texto.value + boton[1].innerHTML;
});

boton[2].addEventListener("click", () => {
    texto.value = texto.value + boton[2].innerHTML;
});

boton[3].addEventListener("click", () => {
    texto.value = texto.value + boton[3].innerHTML;
});

boton[4].addEventListener("click", () => {
    texto.value = texto.value + boton[4].innerHTML;
});

boton[5].addEventListener("click", () => {
    texto.value = texto.value + boton[5].innerHTML;
});

boton[6].addEventListener("click", () => {
    texto.value = texto.value + boton[6].innerHTML;
});

boton[7].addEventListener("click", () => {
    texto.value = texto.value + boton[7].innerHTML;
});

boton[8].addEventListener("click", () => {
    texto.value = texto.value + boton[8].innerHTML;
});

boton[9].addEventListener("click", () => {
    texto.value = texto.value + boton[9].innerHTML;
});

boton[10].addEventListener("click", () => {
    texto.value = texto.value + boton[10].innerHTML;
});

//---- OPERADORES 
operacion[0].addEventListener("click", () => {
    texto.value = texto.value + operacion[0].innerHTML;
});

operacion[1].addEventListener("click", () => {
    texto.value = texto.value + operacion[1].innerHTML;
});

operacion[2].addEventListener("click", () => {
    texto.value = texto.value + "*";
});

operacion[3].addEventListener("click", () => {
    texto.value = texto.value + "/";
});

//---- RESULTADO 
resultat.addEventListener("click", () => {
    let fecha = new Date();
    let operacionPantalla = texto.value;
    operacionHistorial.push(operacionPantalla);
    texto.value = eval(texto.value);
    consulta.push(eval(texto.value));
    fechaOperacion.push(fecha.toLocaleDateString());
    tiempoOperacion.push(fecha.getHours() + ":" + fecha.getMinutes() + ":" + fecha.getSeconds());
});


//---- BOTON HISTORIAL

let botonHistorial = document.getElementById("historial");
let div = document.getElementById("contenido");

botonHistorial.addEventListener("click", () => {
    c6.style.display = 'block';
});

//---- AÑADIR RESULTADO OPERACIONES

botonHistorial.addEventListener("click", () => {
    for(let i = 0; i < consulta.length; i++){
        div.innerHTML += "<p>" + (i + 1) + ") "  + operacionHistorial[i] + " = " + consulta[i] + " " + fechaOperacion[i] + " " + tiempoOperacion[i] + "</p>";
        div.innerHTML += "<p>" + "———————————————————————————————" + "</p>";
    }
});

//---- BOTON VOLVER

let botoTornar = document.getElementById("tornar");

botoTornar.addEventListener("click", () => {
    c4.style.display = 'none';
    c3.style.display = 'block';
    botoTornar.display = 'none';
});


/*
botonHistorial.addEventListener("click", () => {
    infoHistorial.value = infoHistorial.value + consulta;
});

botonHistorial.addEventListener("click", () => {
    for(let i = 0; i < consulta.length; i++){
        infoHistorial.value = infoHistorial.value + consulta[i] + "\n";
    }
});
*/


