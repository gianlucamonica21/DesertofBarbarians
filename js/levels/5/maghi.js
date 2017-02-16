var powerOf = function (base, exponent) {
	if(exponent === 0){
      return 1;
    } else {
      return base * powerOf(base, exponent -1);
    }
};