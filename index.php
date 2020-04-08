<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amőba Játék</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    Lovas Bertalan SZGVJV
    </header>
    <!-- Lovas Bertalan SzGVJV-->
    <div id="container">
        <div id="meretBeker">
            <input type="number" name="xtablaMeret" id="xtablaMeret" value="6" min="5" class="inputmezo" onkeypress='csakSzam(event)'>
            <input type="number" name="ytablaMeret" id="ytablaMeret" value="6" min="5" class="inputmezo" onkeypress='csakSzam(event)'>
            <button onclick="jatekMezoGeneralas();" class="kuldGomb">Új Játék</button>
        </div>    
        <div id="jatekContainer" style="border: 1px black solid;display:none">
        <div id="error"></div>
            <input type="number" name="xKoord" id="xKoord" placeholder="x koordináta" class="inputmezo" onkeypress='csakSzam(event)'>
            <input type="number" name="yKoord" id="yKoord" placeholder="y koordináta" class="inputmezo" onkeypress='csakSzam(event)'>
            <select name="karakterInput" id="karakterInput">
                <option value="x">x</option>
                <option value="o">o</option>
            </select>
            <input type="button" class="kuldGomb" id="lepesGomb" value="Lépés" onclick="lepes(document.getElementById('xKoord').value,document.getElementById('yKoord').value,document.getElementById('karakterInput').value)"/>
         
            <button onclick="getHighScore()" class="kuldGomb" id="highscore">Highscore</button>
            
            <div class="mezoStatiszitka">
                <table id="jatekMezo"></table>
                <div id="ido"></div>
                <div id="statisztikaOut"></div>
                <div id="eredmeny"></div>
            </div>            
        </div>
        
    </div>
    <script src="controller.js"></script>
    <script src="ajax.js"></script>
</body>
</html>