/*! Built with http://stenciljs.com */
import { h } from '../jhstimg.core.js';

class JhStImg {
    constructor() {
        this._sources = [];
        this._isFallbackImageLoaded = false;
        this._isHandleImageFallback = false;
        this._isUnsupportedPictureElementImageLoaded = false;
    }
    srcWatchHandler() {
        this._isUnsupportedPictureElementImageLoaded = false;
        this.addIntersectionObserver();
    }
    sourcesWatchHandler(newSources) {
        this.updateSources(newSources, true);
        this.addIntersectionObserver();
    }
    documentScrollHandler() {
        if (this._hasIntersectionObserver === false) {
            this.fallback();
        }
    }
    windowResizeHandler() {
        if (this._hasIntersectionObserver === false) {
            this.fallback();
        }
    }
    windowRrientationchangeHandler() {
        if (this._hasIntersectionObserver === false) {
            this.fallback();
        }
    }
    componentWillLoad() {
        this._hasIntersectionObserver = 'IntersectionObserver' in window;
        const pictureElement = document.createElement('picture');
        this._hasPictureElementSupport = pictureElement.toString().includes('HTMLPictureElement');
    }
    componentDidLoad() {
        this.addIntersectionObserver();
    }
    componentDidUnload() {
        this.removeIntersectionObserver();
    }
    addIntersectionObserver() {
        if (!this.src) {
            throw new Error('Required attribute in web component `jh-st-img` not set.');
        }
        if (this._hasIntersectionObserver) {
            this.removeIntersectionObserver();
            this.io = new IntersectionObserver((data) => {
                if (data[0].isIntersecting) {
                    this.updateSources(this.sources);
                    this.handleUnsupportedPictureElement();
                    this.removeIntersectionObserver();
                }
            });
            this.io.observe(this.el.querySelector('img'));
        }
        else if (this._isFallbackImageLoaded === false) {
            this.fallback();
        }
    }
    handleUnsupportedPictureElement() {
        if (this._hasPictureElementSupport === false && this._isUnsupportedPictureElementImageLoaded === false) {
            const image = this.el.querySelector('img');
            image.setAttribute('src', this.src);
            this._isUnsupportedPictureElementImageLoaded = true;
        }
    }
    fallback() {
        if (this._isFallbackImageLoaded === false) {
            const image = this.el.querySelector('img');
            if ((image.getBoundingClientRect().top <= window.innerHeight && image.getBoundingClientRect().bottom >= 0)
                && getComputedStyle(image).display !== 'none') {
                this.updateSources(this.sources);
                this.handleUnsupportedPictureElement();
                this._isFallbackImageLoaded = true;
            }
        }
    }
    ;
    updateSources(sources, forceUpdate = false) {
        if (this._sources.length !== 0 && forceUpdate === false) {
            return;
        }
        if (sources) {
            let _sources = typeof sources === 'string' ? JSON.parse(sources) : sources;
            for (let i = (_sources.length - 1); i >= 0; i--) {
                if (_sources[i]['type'] && _sources[i]['type'] === 'image/jpg') {
                    _sources[i]['type'] = 'image/jpeg';
                }
            }
            this._sources = _sources;
        }
        else {
            this._sources = [{ sizes: null, srcset: this.src, type: null, media: null }];
        }
    }
    removeIntersectionObserver() {
        if (this.io) {
            this.io.disconnect();
            this.io = null;
        }
    }
    render() {
        return h("picture", null,
            this._sources.map((source) => {
                return h("source", { sizes: source.sizes, srcSet: source.srcset, type: source.type, media: source.media });
            }),
            h("img", { src: "", alt: this.alt, class: this.imgClass }));
    }
    static get is() { return "jh-st-img"; }
    static get properties() { return {
        "_sources": {
            "state": true
        },
        "alt": {
            "type": String,
            "attr": "alt"
        },
        "el": {
            "elementRef": true
        },
        "imgClass": {
            "type": String,
            "attr": "img-class"
        },
        "sources": {
            "type": "Any",
            "attr": "sources",
            "watchCallbacks": ["sourcesWatchHandler"]
        },
        "src": {
            "type": String,
            "attr": "src",
            "watchCallbacks": ["srcWatchHandler"]
        }
    }; }
    static get listeners() { return [{
            "name": "document:scroll",
            "method": "documentScrollHandler",
            "passive": true
        }, {
            "name": "window:resize",
            "method": "windowResizeHandler",
            "passive": true
        }, {
            "name": "window:orientationchange",
            "method": "windowRrientationchangeHandler"
        }]; }
    static get style() { return "jh-st-img{display:block}jh-st-img img{max-width:100%;max-height:100%}"; }
}

export { JhStImg };
