import {MeteoTestSuite} from "../../web/app/plugins/wwp-meteo/tests/cypress/MeteoTestSuite";

describe('wwp-meteo test suite', () => {

    let acs              = new MeteoTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
