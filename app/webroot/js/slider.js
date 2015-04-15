// Création d'un nouvel objet qui permettrait d'avoir plusieurs slider d'avatars
$(document).ready(function() {
    if ($("#FighterAvatar").length !== 0) {
        slide = new slider(".avatars");
    }
});

// Fonction qui gère le slider
var slider = function(id) {
    var self = this; // Permet de modifier dans des sous-fonctions les variables de la fonction principale
    this.div = $(id); // On récupère l'objet
    this.slider = this.div.find(".slider"); // On trouve l'objet avec la classe slider
    this.sliderWidth = this.div.width(); // On récupère la largeur visible dans le slider

    // On cherche maintenant à récupérer la largeur totale des avatars en prenant compte des marges de chaque image
    this.steps = 0;
    this.div.find('a').each(function() {
        self.steps += 1;
    });
    this.previous = this.div.find(".previous_s");
    this.next = this.div.find(".next_s");

    // On stock dans une variable l'indice de l'image courante
    this.image = 1;
    document.getElementById('FighterAvatar').value = this.image; // Initialise l'indice de l'image pour l'enregistrer ensuite
    this.length = $(".infos").length;
    if (this.length !== 0) {
        document.getElementById(this.image).style.display = 'block';
    }

    this.next.click(function() {
        // Comme on a 8 images prédéfinies d'avatars, on ne peut pas se déplacer au delà
        if (self.image < self.steps) {
            self.image++;
            self.slider.animate({
                left: -(self.image - 1) * self.sliderWidth
            }, 1000); // Définit l'animation du slider
            document.getElementById('FighterAvatar').value = self.image; // Permet de récupérer l'indice de l'image pour l'enregistrer ensuite
            if (self.length !== 0) {
                document.getElementById(self.image).style.display = 'block';
                document.getElementById(self.image-1).style.display = 'none';
            }
        }
    });
    this.previous.click(function() {
        // Condition pour ne pas aller trop vers la gauche
        if (self.image > 1) {
            self.image--;
            self.slider.animate({
                left: -(self.image - 1) * self.sliderWidth
            }, 1000); // Animation
            document.getElementById('FighterAvatar').value = self.image; // Permet de récupérer l'indice de l'image pour l'enregistrer ensuite
            if (self.length !== 0) {
                document.getElementById(self.image).style.display = 'block';
                document.getElementById(self.image+1).style.display = 'none';
            }
        }
    });
};