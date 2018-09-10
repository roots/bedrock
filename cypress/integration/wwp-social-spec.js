/**
 * Social spec file to copy to /cypress/integration folder
 */
import {SocialTestSuite} from "../../web/app/plugins/wwp-social/tests/cypress/SocialTestSuite";

describe('wwp-social test suite', () => {

    let acs              = new SocialTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
