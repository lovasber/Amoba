let ujJatek = true;
function koordAdatbazisba(sor,oszlop,karakter,vanEnyertes,ido) {
    let nyertes
    const xhttp = new XMLHttpRequest()        
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {                
                nyertes = this.responseText;

                vanEnyertes(nyertes)            
            }               
        }
        xhttp.open("GET","beilleszt.php?sor="+sor+"&oszlop="+oszlop+"&karakter="+karakter+"&uj_e="+ujJatek+"&ido="+ido,true)         
        xhttp.send()
        
}

function meretAdatbazisba(sor,oszlop) {
    const xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
        }   
    }
    xhttp.open("GET","ujJatek.php?sor="+sor+"&oszlop="+oszlop,true)
    xhttp.send()
    ujJatek = false; 
}

function getHighScore() {
    const xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
            document.getElementById("statisztikaOut").innerHTML = 
            "<h2>Statisztika: </h2><br>"
            +this.responseText

        } 
    }
    xhttp.open("GET","highscore.php",true)
    xhttp.send()
}

function statistikaMegjelenites() {
    const xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText)
            document.getElementById("eredmeny").style.display = "block"
            document.getElementById("eredmeny").innerHTML = 
            this.responseText
            document.getElementById("lepesGomb").setAttribute("onclick","ujJatekGeneral()");
            document.getElementById("lepesGomb").value = "Új játék"

        } 
    }
    xhttp.open("GET","statisztika.php",true)
    xhttp.send()
}


