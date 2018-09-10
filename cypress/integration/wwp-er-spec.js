/**
 * Emploi spec file to copy to /cypress/integration folder
 */
import {ErTestSuite} from "../../web/app/plugins/wwp-espace-restreint/tests/cypress/ErTestSuite";

describe('wwp-espace-restreint test suite', () => {

    let acs              = new ErTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
