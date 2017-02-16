var loadMissiles = function() {
  var targets = viableTargets();
  for( var i = 0; i < 5; i++ ) {
    enemyMissiles.push( new EnemyMissile(targets) );
  }
};