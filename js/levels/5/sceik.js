var powerOf = function (base, exponent) {
  if (exponent === 0) return 1;
  return base * powerOf(base, --exponent);
};