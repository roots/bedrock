/**
 * Video spec file to copy to /cypress/integration folder
 */
import {VideoTestSuite} from "../../web/app/plugins/wwp-video/tests/cypress/VideoTestSuite";

describe('wwp-video test suite', () => {

    let acs              = new VideoTestSuite(),
        testsDefinitions = acs.getTestsDefinitions();

    testsDefinitions.forEach((testDef) => {
        it(testDef.title, () => {
            acs[testDef.callable](cy);
        });
    });

});
