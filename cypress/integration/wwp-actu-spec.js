import {ActuTestSuite} from "../../web/app/plugins/wwp-actu/tests/cypress/ActuTestSuite";

describe('wwp-actu test suite', () => {

    let acs              = new ActuTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
