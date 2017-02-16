 var createShields = function () {
 /* Shields must be inserted in the shields array. The positions are stored in the shieldPos array, which contains two objects (each with an x property and a y property) */
	for (var i = 0; i < 2; i++)
		shields[i] = new Shield(shieldPos[i].x, shieldPos[i].y);
  };