var automaticShooting = function() {

	for(i=0;i<enemyMissiles.length;i++){
		if(enemyMissiles[i].delay == 0) {
			playerShoot(enemyMissiles[i].x, enemyMissiles[i].y);
		}
	}

};