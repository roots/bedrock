import {TrackerTestSuite} from "../../web/app/plugins/wwp-tracker/tests/cypress/TrackerTestSuite";

describe('wwp-tracker test suite', () => {

    let acs              = new TrackerTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
