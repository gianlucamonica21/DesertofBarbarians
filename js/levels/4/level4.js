var powerOf = function (base, exponent) {
  var result = base;
  while (exponent != 1) {
    result = result * base;
    exponent--;
  }
  return result;
};