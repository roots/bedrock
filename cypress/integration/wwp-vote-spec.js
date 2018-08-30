import {VoteTestSuite} from "../../web/app/plugins/wwp-vote/tests/cypress/VoteTestSuite";

describe('wwp-vote test suite', () => {

    let acs              = new VoteTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
