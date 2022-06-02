import {RgpdTestSuite} from "../../web/app/plugins/wwp-rgpd/tests/cypress/RgpdTestSuite";

describe('wwp-rgpd test suite', () => {

    let acs              = new RgpdTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
