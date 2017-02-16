var playerShoot = function( x, y ) {
    if( y >= 50 && y <= 370 ) {
      var source = whichAntiMissileBattery( x );
      if( source === -1 ){ // No missiles left
        return;
      }
      var dx = 35;
      var dy = 25;
      playerMissiles.push( new PlayerMissile( source, x + dx, y + dy ) );
    }
};