/**
 * Trombi spec file to copy to /cypress/integration folder
 */
import {PartenaireTestSuite} from "../../web/app/plugins/wwp-partenaires/tests/cypress/PartenaireTestSuite";

describe('wwp-partenaires test suite', () => {

    let acs              = new PartenaireTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
