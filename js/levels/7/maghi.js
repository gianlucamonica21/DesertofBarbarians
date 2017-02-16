var addMissiles = function (n, amb) {
	/* Adds n missiles to the anti-missile battery given as input (amb), only if it has no missiles left */
	if(amb.missilesLeft === 0){
      amb.missilesLeft = n;
    }
};