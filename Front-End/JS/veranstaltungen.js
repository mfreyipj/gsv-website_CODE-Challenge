/*Show-Content-Skript*/



function showcontent(id){

    var divelement = id;

    var kommendD = document.getElementById("new");

    var vergangenD = document.getElementById("old");

    var kommendM = document.getElementById("newMobile");

    var vergangenM = document.getElementById("oldMobile");

    var footer = document.getElementById("footer");



    if(divelement == "oldMobile"){

        if(vergangenD.style.display == "none"){

            vergangenD.style.display = "flex";

            kommendD.style.display = "none";

            footer.style.position = "relative";

        }

        else{

            vergangenD.style.display = "none";

            footer.style.position = "absolute";

        }

    }

    else if(divelement == "newMobile"){

        if(kommendD.style.display == "none"){

            kommendD.style.display = "flex";

            footer.style.position = "relative";

            vergangenD.style.display = "none";

        }

        else{

            kommendD.style.display = "none";

            footer.style.position = "absolute";

        }

    }

    else if( divelement == "old"){

        if(vergangenD.style.display == "none"){

            vergangenD.style.display = "flex";

            kommendD.style.display = "none";



            footer.style.position = "relative";

        }

    }

    else if(divelement == "new"){

        if(kommendD.style.display == "none"){

            kommendD.style.display = "flex";

            vergangenD.style.display = "none";

            footer.style.position = "relative";

        }

    }

}


if (window.matchMedia("(max-width: 600px)").matches) {

  document.getElementById("new").style.display = "none";

}




/*Timerscript*/

    // In den Klammern steht das Datum zu dem wir runterzählen

    var countDownDate = new Date("Aug 16, 2018 15:37:25").getTime();



    // Update the count down every 1 second

    var countdownfunction = setInterval(function() {



        // Das aktuelle Datum wird erzeugt

        var now = new Date().getTime();



        // Die Differenz wird gebildet

        var distance = countDownDate - now;



        // Zeitrechnungen für Tage,Stunden,Minuten und Sekunden

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        var seconds = Math.floor((distance % (1000 * 60)) / 1000);



        // Text wird erzeugt

        document.getElementById("timermobile").innerHTML = "<span>Noch: </span>"+"<span>" + days + "<i>Tage |</i></span> <span>" +  hours + " <i>Stunden |</i></span><span> "

        + minutes + "  <i> Minuten |</i></span><span>  " + seconds + " <i>Sekunden</i></span>  " + "<span> bis zur nächsten GSV! </span>";



        // Text wird erzeugt(Desktop)

        document.getElementById("timerdesktop").innerHTML = "<span>Noch: </span>"+"<span>" + days + "<i>Tage |</i></span> <span>" +  hours + " <i>Stunden |</i></span><span> "

        + minutes + "  <i> Minuten |</i></span><span>  " + seconds + " <i>Sekunden</i></span>  " + "<span> bis zur nächsten GSV! </span>";



        // Text wird erzeugt wenn Zeit abgelaufen ist(Mobil)

        if (distance < 0) {

            clearInterval(countdownfunction);

            document.getElementById("timermobile").innerHTML = "Die GSV hat bereits stattgefunden!";

        }



        // Text wird erzeugt wenn Zeit abgelaufen ist(Desktop)

        if (distance < 0) {

            clearInterval(countdownfunction);

            document.getElementById("timerdesktop").innerHTML = "Die GSV hat bereits stattgefunden!";

        }

    }, 1000);
