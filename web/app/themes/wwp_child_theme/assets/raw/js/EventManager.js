export class EventManager {
    trigger(eventName, eventData, $target) {
        $target = $target || $(document);
        //console.log('EventManager::trigger',eventName,eventData,$target);
        $target.trigger(eventName, eventData);
    }

    on(eventName, callable, $target) {
        $target = $target || $(document);
        //console.log('EventManager::on',eventName,callable,$target);
        $target.on(eventName, callable);
    }

    off(eventName, $target) {
        $target = $target || $(document);
        //console.log('EventManager::off',eventName,$target);
        $target.off(eventName);
    }
}
