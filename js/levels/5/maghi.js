var powerOf = function (base, exponent) {
 return base * powerOf(base,exponent-1);
};