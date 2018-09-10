import {NewsletterTestSuite} from "../../web/app/plugins/wwp-newsletter/tests/cypress/NewsletterTestSuite";

describe('wwp-newsletter test suite', () => {

    let acs              = new NewsletterTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
