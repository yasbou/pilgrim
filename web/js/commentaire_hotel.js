var game = {
    // Méthode qui initialise notre objet "game"
    init: function() {
        console.log('jeu initialisé');
        enter=
        // On écoute l'événement 'click' sur le bouton dont l'id est "submit"
        $('#submit').on('click', game.date);
        $('#commentaire').keypress(function(e){
    if( e.which == 13 )game.date();
});

    },

    date: function (){
      var date = Date.now();

      var months = ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre',
      'Octobre','Novembre','Décembre'];

      today = new Date();
if (today.getDate() < 10) { var jour = "0"+today.getDate(); }
else { jour = today.getDate(); }
if (today.getMonth() < 10) { var m=today.getMonth(); var mois = m+1; }
else { mois = today.getMonth(); }
annee = today.getFullYear();
if (today.getHours() < 10) {var heure = "0"+today.getHours(); }
else { heure = today.getHours(); }
if (today.getMinutes() < 10) { var minute = "0"+today.getMinutes(); }
else { minute = today.getMinutes(); }
  var pubDate = jour+"/"+mois+"/"+annee+" "+heure+":"+minute;

      console.log(pubDate);
      game.checkNumber(pubDate);
    },
    // Méthode qui va chercher le message
    checkNumber: function(pubDate) {
        console.log('nombre soumis');

        // Donnée à envoyer
        var info = $('#commentaire').val();
        console.log(info);
        var id= $('#id').val();
        console.log(id);
        var comment = id+'/'+info;
        console.log(comment);
         //Envoi de la requête ajax au serveur
        $.ajax(

            // cette variable 'ajaxGetCookieURL' est définie via Twig
            // game.html.twig (via une variable JS)
            {
                url: ajaxCheckNumber,
                method: 'POST',
                data: comment
              }

        // Ecouteur du retour de la requête en cas de succès
        ).done(function(data) {
          console.log('envoyé');

          console.log(pubDate);



          //Affichage du résultat
        var html ='<ul class="comment">'
          +'<li class="auteur">Moi - </li>'
    + '<li class="date">'+pubDate+'--'+'</li>'
      + '<li class="texte">'+info+'</li></ul>';
      $('#titre').before(html);

      $('#commentaire').val(' ');

        });
    }
}

$(game.init());
