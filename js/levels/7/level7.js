function PlayerMissile( source, endX, endY ) {
    // Anti missile battery this missile will be fired from
    var amb = antiMissileBatteries[source];

    Missile.call( this, { startX: amb.x,  startY: amb.y,
      endX: endX,     endY: endY,
      color: 'brown', trailColor: 'rgba(200,50,50,0.5)', explodeColor: 'rgba(255,230,200,0.5)' } );

    var xDistance = this.endX - this.startX,
    yDistance = this.endY - this.startY;
    // Determine a value to be used to scale the orthogonal directions
    // of travel so the missiles travel at a constant speed and in the
    // right direction
    var scale = missileSpeed(xDistance, yDistance);

    this.dx = xDistance / scale;
    this.dy = yDistance / scale;

    amb.missilesLeft--;

  }

var addMissile = function (n, amb) {

};