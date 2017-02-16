var computeSystemTime = function(parameters) {
	var temp = 0;
	//Parameters array contains 8 elements
	for (i = 0; i < 8; i++) {
		if (parameters[i] < 0) {
			if (parameters[i] > 10) {
				// do nothing
			} else {
				temp = temp + parameters[i];
			}
		} else {
			temp = temp + parameters[i];
		}
	}
	return temp;
};