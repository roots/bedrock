const toObject = (x) => x.reduce((p, v, k) => {
  p[k] = v;
  return p;
}, {});

export const matchPattern = (pattern, value) => {
  if (Array.isArray(pattern)) {
    for (let p of pattern) {
      let matches = matchPattern(p, value);
      if (matches) return matches;
    }
  }

  if (pattern instanceof RegExp) {
    let matches = String(value).match(pattern);
    if (matches)
      return {...toObject(Array.from(matches).slice(1)), ...matches.groups};
  }

  if (pattern === '*' || pattern === value)
    return {};

  return null;
};

export class EventManager {
  constructor() {
    this.listeners = [];
  }

  on(type, handler) {
    if (typeof handler !== 'function')
      throw new Error('handler is not a function');

    let id = Math.random().toString(36).slice(2);
    let remove = () => {
      for (let i = this.listeners.length - 1; i >= 0; i--) {
        if (this.listeners[i].id === id)
          this.listeners.splice(i, 1);
      }
    };

    let listener = {id, type, handler, remove};
    this.listeners.push(listener);

    return listener;
  }

  trigger(type, payload) {
    let event = {type};
    for (let listener of this.listeners) {
      if (this.shouldCallListener(listener, event))
        listener.handler(this.toHandlerPayload(listener, event), payload);
    }
  }

  shouldCallListener(listener, event) {
    return matchPattern(listener.type, event.type) !== null;
  }

  toHandlerPayload(listener, event) {
    let params = matchPattern(listener.type, event.type);
    return {...event, params};
  }
}
