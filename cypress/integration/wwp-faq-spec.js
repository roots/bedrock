/**
 * Faq spec file to copy to /cypress/integration folder
 */
import {FaqTestSuite} from "../../web/app/plugins/wwp-faq/tests/cypress/FaqTestSuite";

describe('wwp-faq test suite', () => {

    let acs              = new FaqTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
