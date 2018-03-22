var app = {
 init: function() {
   console.log('app init');
   // Creation des vignettes
   app.createThumbs();

   // Création des flèches
   app.createArrows();

   // Lancer un setInterval / Lancer la lecture du slider / play()
   app.play();
 },
 createArrows : function() {
   console.info('carousel.createArrows');

   // Creation de la flèche gauche
   var $arrowLeft = $('<div>', {
     id: 'slider-arrow-left',
     class: 'slider-arrow'
   });

   // Creation de la flèche droite
   var $arrowRight = $('<div>', {
     id: 'slider-arrow-right',
     class: 'slider-arrow'
   });

   // Ecouteur pour le click
   $arrowLeft.on('click', app.goPrev);
   $arrowRight.on('click', app.goNext);

   // Ajout des fleches à slider
   $('#slider').append($arrowLeft, $arrowRight);
 },
 createThumbs: function() {
   // Créer une div pour contenir les vignettes
   var $thumbs = $('<div>', {id: 'slider-thumbs'});

   // Générer les vignettes apartir des images existantes
   $('#slider-images img').each(function() {
     // pour chaque vignette : ajouter le src
     //je veux la source de l'image courante de la collection
     var imgSrc = $(this).attr('src');
     // Creation de la vignette avec la source de l'image courante
     // ajouter la vignette au container
     $('<img>', {src: imgSrc}).appendTo($thumbs);
   });

   // Ajouter le container de vignettes à notre slider
   $thumbs.appendTo('#slider');

   // Ajouter un ecouteur sur toutes les vignettes
   $('#slider-thumbs img').on('click', app.changeImage);

   // Sur la première image : active
   $('#slider-thumbs img').first().addClass('active');
 },
 changeImage: function() {
   // recuperation de l'index de la vignette pour cibler l'image correspondante
   var index = $(this).index();

   // utilisation de l'index trouvé pour cibler l'image
   var $img = $('#slider-images img').eq(index);

   // Affichage et traitement pour l'image correspondante
   app.showImage($img);

   // Je relance la lecture du carousel
   app.play();
 },
 play: function() {
   // Verification si un Interval existe déja, alors je le supprime
   if (app.timer) {
     clearInterval(app.timer);
   }
   // Déclaration d'un setInterval pour réaliser une action toutes les 5 secondes
   app.timer = setInterval(app.goNext, 2000);
 },
 goNext: function() {
   // Je détermine l'image suivante
   var $nextImage = $('#slider-images img.active').next();
   // Verification de l'element suivant, existe-t-il ?
   if ($nextImage.length === 0) {
     // ici nextImage ne possede pas de visuel à afficher
     // donc nous allons chercher le 1er visuel de la div #slider-images
     // $nextImage = $('#slider-images img').eq(0);
     $nextImage = $('#slider-images img').first();
   }
   // J'affiche l'image suivante
   app.showImage($nextImage);

 },
 goPrev: function() {
   // Je détermine l'image suivante
   var $prevImage = $('#slider-images img.active').prev();
   // Verification de l'element suivant, existe-t-il ?
   if ($prevImage.length === 0) {
     $prevImage = $('#slider-images img').last();
   }
   // J'affiche l'image suivante
   app.showImage($prevImage);

 },
 showImage: function($next){
   // Je masque l'image courante et j'enleve la classe active
   $('#slider-images img.active').removeClass('active');

   // J'affiche l'image suivante et j'ajoute la classe active
   $next.addClass('active');

   // Supprimer la classe active de l'ancien thumbnail
   $('#slider-thumbs .active').removeClass('active');

   // On modifie la classe du thumbnail
   $('#slider-thumbs img').eq($next.index()).addClass('active');
 }
};

$(app.init);
