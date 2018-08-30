/**
 * Emploi spec file to copy to /cypress/integration folder
 */
import {EmploiTestSuite} from "../../web/app/plugins/wwp-emploi/tests/cypress/EmploiTestSuite";

describe('wwp-emploi test suite', () => {

    let acs              = new EmploiTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
