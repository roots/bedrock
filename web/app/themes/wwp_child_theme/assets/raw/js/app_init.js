export class AppInit {
    constructor() {
        console.log(window.pew);
        window.pew.enhanceRegistry();
    }
}
new AppInit();