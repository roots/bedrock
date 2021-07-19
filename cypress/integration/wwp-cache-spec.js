import {CacheTestSuite} from "../../web/app/plugins/wwp-cache/tests/cypress/CacheTestSuite";

describe('wwp-cache test suite', () => {

    let acs              = new CacheTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
