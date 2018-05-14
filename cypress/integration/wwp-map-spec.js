import {MapTestSuite} from "../../web/app/plugins/wwp-map/tests/cypress/MapTestSuite";

describe('wwp-map test suite', () => {

    let acs              = new MapTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
