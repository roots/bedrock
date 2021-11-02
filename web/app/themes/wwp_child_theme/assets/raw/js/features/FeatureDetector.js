const jsTest = function () {
  return true;
};
const touchTest = function () {
  return (('ontouchstart' in window))
};

const cssVarsTest = function() {
  return window.CSS && window.CSS.supports('color', 'var(--fake-var)');;
}

export class FeatureDetector {

  constructor(tests) {
    this.features = {};
    this.tests = Object.assign(this.getDefaultTests(), tests);
  }

  getDefaultTests() {
    return {
      touch: touchTest,
      cssVars: cssVarsTest
    }
  }

  runTests() {
    var domElt = window.document.documentElement;

    for (let i in this.tests) {
      let currentTest = this.tests[i];
      let hasFeature = currentTest && currentTest();
      this.features[i] = hasFeature;

      let positiveClassName = i + '-enabled';
      let negativeClassName = 'no-' + i;

      if (hasFeature) {
        if (domElt.classList.contains(negativeClassName)) {
          // The box that we clicked has a class of bad so let's remove it and add the good class
          domElt.classList.remove(negativeClassName);
        }
        domElt.className += ' ' + positiveClassName;
      } else {
        if (domElt.classList.contains(positiveClassName)) {
          // The box that we clicked has a class of bad so let's remove it and add the good class
          domElt.classList.remove(positiveClassName);
        }
        domElt.className += ' ' + negativeClassName;
      }
    }
  }

  has(featureKey) {
    if (!this.features[featureKey]) {
      this.features[featureKey] = false;
    }
    return this.features[featureKey];
  }
}
