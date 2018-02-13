let NotificationOptions = {
    jsTemplates: '#jsTemplates',
    templateType: 'notification',
    delay:4000
};

export class NotificationComponent {
    constructor() {
        this.options = NotificationOptions;
    }

    replaceTplWithMsg(type, msg) {
        let jsTemplates = document.querySelector(this.options.jsTemplates);
        jsTemplates = JSON.parse(jsTemplates.innerHTML);

        let tpl = jsTemplates[this.options.templateType]; // get "notification" template

        tpl = tpl
            .replace('{type}', type)
            .replace('{message}', msg);

        var d = document.createElement('div');
        d.innerHTML = tpl;
        return d.firstChild;
    }

    show(type, msg, $dest) {

        $dest = $dest || document.getElementsByTagName('body');

        this.dest = $dest[0];

        this.tpl = this.replaceTplWithMsg(type, msg);
        this.tpl.classList.add('alert-js');
        this.tpl.classList.add('active');

        this.dest.insertBefore(this.tpl, this.dest.firstChild);
        this.tpl.addEventListener('click', this.close.bind(this.dest), false);


        let self = this;
        setTimeout(function () {
            self.tpl.click();
        }, self.options.delay);
    }

    close() { // scope : this.dest
        let node = this;
        setTimeout(function(){
            node.removeChild(node.firstChild);
         },1000);
    }
}

window.pew.addRegistryEntry({key: 'wdf-notification', domSelector: '.contactForm', classDef: NotificationComponent});
