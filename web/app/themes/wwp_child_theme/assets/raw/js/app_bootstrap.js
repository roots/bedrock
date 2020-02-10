import {Pew} from "pewjs/pew"
import {EventManager} from "./EventManager";

window.EventManager = new EventManager();
window.pew          = new Pew();
window.pew.__DEBUG = true;
