import {PewComponent} from "./pew-component";
import "jquery-lazy";

export class LazyLoading extends PewComponent
{
    constructor() {
        super();
        console.log('LAZYLOADING');

    }
    init() {

        this.preventImgLoading();
       // $('.lazy').Lazy();

    }

    preventImgLoading() {
       /* let img = document.querySelectorAll('img');

        img.forEach((item) => {
            let src = item.getAttribute('src');
            let srcSet = item.getAttribute('srcset');
            let sizes = item.getAttribute('sizes');
            item.setAttribute('data-src', src);
            //item.setAttribute('data-srcset', srcSet);
            //item.setAttribute('data-sizes', sizes);
            item.classList.add('lazy');
            item.removeAttribute('src');
            item.removeAttribute('srcset');
            item.removeAttribute('sizes');
            console.log('IMG AFTER PROCESS', item);
        });*/
    }
}

window.pew.addRegistryEntry({key: 'wdf-lazy-loading', domSelector: 'body', parentHTMLElement: document,classDef: LazyLoading});
