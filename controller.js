/*
TODO:
*/
let ido = 0
let idozito
let jatekTer = []

function jatekMezoGeneralas(){

XJATEKMERET = document.getElementById("xtablaMeret").value
YJATEKMERET = document.getElementById("ytablaMeret").value

if(XJATEKMERET>=5 && YJATEKMERET>=5){
    document.getElementById("jatekContainer").style = "display:block;"
    let tablazat = document.getElementById("jatekMezo")

        for(let i=0;i<XJATEKMERET;i++){
            let tr = document.createElement("tr")
            for (let j = 0; j < YJATEKMERET; j++) {
                let td = document.createElement("td")
                let button = document.createElement("button")
                button.innerHTML = ""
                button.setAttribute("class","generaltGomb");                 
                button.setAttribute("onclick","gombraKattintvaLep(this)")
                button.setAttribute("id","s"+i+"o"+j)
                td.appendChild(button)
                tr.appendChild(td)
                jatekTer.push(button)
            }
            tablazat.appendChild(tr)
        }
        document.getElementById("meretBeker").style = "display:none" 
        meretAdatbazisba(XJATEKMERET,YJATEKMERET)
    }else{
        alert("túl kicsi a pálya(minimum:5)")
    }    
}

function getSor(gomb){
    let tomb = gomb.id; //s2o2
    tomb = tomb.substr(1);
    tomb= tomb.split("o");
    //console.log(tomb[0]);
    return tomb[0]
}

function getOszlop(gomb){
    let tomb = gomb.id; //s2o2
    tomb = tomb.substr(1);
    tomb= tomb.split("o");
    //console.log(tomb[1]);
    return tomb[1]
}

function gombraKattintvaLep(gomb){
    const x = parseInt(getSor(gomb))+1;
    const y = parseInt(getOszlop(gomb))+1;
    const kar = document.getElementById("karakterInput").value;
   // console.log(x+" "+y+" "+kar)
    document.getElementById("xKoord").value = x
    document.getElementById("yKoord").value = y

    lepes(x,y,kar);
}

function kovetkezoJatekos(elozoKarakter) {
    let karInputs = document.getElementById("karakterInput");
    //let options = karInputs.options
    
    if(elozoKarakter =="x"){
        karInputs.selectedIndex = 1
    }else{
        karInputs.selectedIndex = 0
    }
}

function chkNyertes(nyertes){
    console.log("cb: "+(nyertes||"Bercy papa"))
    if(nyertes !="Senki"){
        if (confirm(nyertes+" Nyert!\nInduljon új játék?")) {
            // IGEN
            ujJatekGeneral()
        } else {
            // NE
            nincsUjJatek()
        }                    
    }  
}

function idozitoIndit(){
     idozito = setInterval(() => {
        ido=ido+0.1;
        document.getElementById("ido").innerHTML = 15-parseInt(ido)
        if(parseInt(ido)==15){//15
            kovetkezoJatekos(document.getElementById("karakterInput").value)
            let jatekosKar = document.getElementById("karakterInput").value
            jatekosKar = jatekosKar.toUpperCase()
            document.getElementById("error").innerHTML = "Az idő lejárt! A következő játékos jön: "+jatekosKar           
            ido=0;
            //clearInterval(idozito)
        }
    }, 100); 
}

function idozitotNullaz(){
    ido = 0
    document.getElementById("ido").innerHTML = ""
    clearInterval(idozito)
}

function lepes(xKoord,yKoord,karakter) {
    if(xKoord.length != 0 && yKoord.length != 0){  
             
        if(xKoord<=XJATEKMERET && yKoord<=YJATEKMERET && xKoord>0 && yKoord>0){            
            const kijeloltGomb = document.getElementById("s"+parseInt(xKoord-1)+"o"+parseInt(yKoord-1))
            if(!kijeloltGomb.disabled){
                if(karakter=="o"){
                    kijeloltGomb.style.color ="#ff3d00";//piros
                }else{
                    kijeloltGomb.style.color = "#2196f3"//kék
                }
                kijeloltGomb.innerHTML = ""+karakter
                kijeloltGomb.value = ""+karakter
                kijeloltGomb.disabled = true
                kovetkezoJatekos(karakter)
                koordAdatbazisba(xKoord,yKoord,karakter,chkNyertes,ido)
                document.getElementById("error").innerHTML = ""

                idozitotNullaz()
                idozitoIndit()
                
            }else{
                //már ki lett jelölve
                document.getElementById("error").innerHTML = "A mező foglalt!"
                console.log("már ki lett jelölve")
            }
            
        }else{
            document.getElementById("error").innerHTML = "Nem létező koordináta!"
            console.log("rossz koordináta: s:"+xKoord+" o:"+yKoord)
        }
    }else{
        document.getElementById("error").innerHTML = "Nincs szám! Kattitson vagy írja be a koordinátákat!"
        console.log("nincs szam")
    } 
}

function nincsUjJatek() {
    for(let i=0;i<jatekTer.length;i++){
        jatekTer[i].disabled = true;
    }
   
    idozitotNullaz()
    //document.getElementById("lepesGomb").disabled = true;
    statistikaMegjelenites();
}

function ujJatekGeneral() {

    //document.getElementById("potgomb").style.display = "none"
    document.getElementById("lepesGomb").value = "Lépés"
    document.getElementById("lepesGomb").setAttribute("onclick","lepes(document.getElementById('xKoord').value,document.getElementById('yKoord').value,document.getElementById('karakterInput').value)")
    document.getElementById("eredmeny").style.display = "none"
    document.getElementById("eredmeny").innerHTML=""
    document.getElementById("statisztikaOut").innerHTML=""
    idozitotNullaz()
    document.getElementById("karakterInput").selectedIndex = 0
    document.getElementById("jatekContainer").style.display= "none"
    document.getElementById("jatekMezo").innerHTML = ""
    document.getElementById("xKoord").value = ""
    document.getElementById("yKoord").value = ""
    document.getElementById("xtablaMeret").value = 6
    document.getElementById("ytablaMeret").value = 6
    document.getElementById("meretBeker").style.display = "block"
    
}

function csakSzam(evt) {
    var theEvent = evt || window.event;
    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
    // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }

  

