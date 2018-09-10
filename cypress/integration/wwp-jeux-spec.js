/**
 * Jeux spec file to copy to /cypress/integration folder
 */
import {JeuxTestSuite} from "../../web/app/plugins/wwp-jeux/tests/cypress/JeuxTestSuite";

describe('wwp-jeux test suite', () => {

    let acs              = new JeuxTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
