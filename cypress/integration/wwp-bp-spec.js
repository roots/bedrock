import {BpTestSuite} from "../../web/app/plugins/wwp-branchepage/tests/cypress/BpTestSuite";

describe('wwp-bp test suite', () => {

    let acs              = new BpTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
