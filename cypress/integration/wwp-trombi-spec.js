/**
 * Trombi spec file to copy to /cypress/integration folder
 */
import {TrombiTestSuite} from "../../web/app/plugins/wwp-trombinoscope/tests/cypress/TrombiTestSuite";

describe('wwp-trombi test suite', () => {

    let acs              = new TrombiTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
