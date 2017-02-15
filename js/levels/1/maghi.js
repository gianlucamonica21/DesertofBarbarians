var missileSpeed = function (xDistance, yDistance) {
    var distance = Math.sqrt( Math.pow(xDistance, 2) + Math.pow(yDistance, 2) );
var gggs;
    var distancePerFrame = 12;

    var speed = distance / distancePerFrame;
return speed;
};