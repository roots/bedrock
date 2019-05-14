export class AbstractNotification {
    show(type, msg, $dest) {

    }

    getAbstractOpts() {
        return {
            type: 'info',
            msg: '',
            focus: true
        }
    }

    close() {

    }
}
