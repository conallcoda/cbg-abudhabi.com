import { Controller } from '@hotwired/stimulus';
import Hls from 'hls.js';
import { getViewport, debounce } from './util';

export default class extends Controller {
    static targets = ['video'];

    landscape = {
        2560: '2560x1440',
    };

    portrait = {
        1080: '810x1440',
    };
    connect() {
        this.videoName = null;
        this.fileName = null;
        window.addEventListener('resize', debounce(this.init.bind(this)));
        this.init();
    }

    disconnect() {
        window.removeEventListener('resize', debounce(this.init.bind(this)));
    }

    init() {
        if (!window) {
            return;
        }
        const { w, h } = getViewport(window);
        let videoName = this.element.dataset.videoName;
        videoName = w > h ? videoName : videoName + '_portrait';
        const config = w > h ? this.landscape : this.portrait;
        let fileName = false;
        Object.keys(config).forEach((key, i) => {
            if (
                !fileName &&
                (key > w || i === Object.keys(config).length - 1)
            ) {
                fileName = config[key];
            }
        });

        if (this.videoName !== videoName || this.fileName !== fileName) {
            this.videoTarget.poster = this.getVideoPoster(videoName, fileName);
            if (false && Hls.isSupported() && w > 1000) {
                var hls = new Hls();
                hls.loadSource(this.getSegmentedSource(videoName, fileName));
                hls.attachMedia(this.videoTarget);
            } else {
                console.log(this.getCroppedSource(
                    videoName,
                    fileName
                ));
                this.videoTarget.src = this.getCroppedSource(
                    videoName,
                    fileName
                );
            }
        }
    }

    getVideoPoster(videoName, fileName) {
        return `/assets/video/${videoName}/segmented/${fileName}/poster.jpg`;
    }

    getSegmentedSource(videoName, fileName) {
        return `/assets/video/${videoName}/segmented/${fileName}/index.m3u8`;
    }

    getCroppedSource(videoName, fileName) {
        return `/assets/video/${videoName}/cropped/${fileName}.mp4?v=1`;
    }
}
