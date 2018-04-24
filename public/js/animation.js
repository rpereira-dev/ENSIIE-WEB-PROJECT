/** une bibliothèque de fonctions pratiques pour rendre les pages plus dynamiques */

/**
 *	rends un élément invisible progressivement
 *		- element : l'élément
 *		- fps : le nombre de fps de l'animation
 *		- duration : la durée de la transition
 */
function fadeOut(element, fps, duration) {
    var op  = 1.0;
	var d_op = 1.0 / (fps * duration);
    var timer = setInterval(function () {
        if (op <= 0.0) {
        	op = 0.0;
            clearInterval(timer);
            element.style.display = "none";
        }
        element.style.opacity = op;
        element.style.filter = "alpha(opacity=" + op * 100.0 + ")";
        op -= d_op;
    }, 1000.0 / fps);
}

/**
 *	rends un élément visible progressivement
 *		- element : l'élément
 *		- fps : le nombre de fps de l'animation
 *		- duration : la durée de la transition
 */
function fadeIn(element, fps, duration) {
    element.style.display = "";
    element.style.opacity = 0.0;
    element.style.filter  = "alpha(opacity=0)";
    
    var op   = 0.0;
	var d_op = 1.0 / (fps * duration);
    var timer = setInterval(function () {
        if (op >= 1.0) {
        	op = 1.0;
            clearInterval(timer);
            element.style.display = '';
        }
        element.style.opacity = op;
        element.style.filter  = "alpha(opacity=" + op * 100.0 + ")";
        op += d_op;
    }, 1000.0 / fps);
}