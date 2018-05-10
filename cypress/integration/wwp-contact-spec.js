import {ContactTestSuite} from "../../web/app/plugins/wwp-contact/tests/cypress/ContactTestSuite";

describe('wwp-contact test suite', () => {

    let acs              = new ContactTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
