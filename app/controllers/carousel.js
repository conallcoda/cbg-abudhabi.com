import { Controller } from '@hotwired/stimulus';
import EmblaCarousel from 'embla-carousel';
import { addPrevNextBtnsClickHandlers } from './embla/arrows';
import { addDotBtnsAndClickHandlers } from './embla/dots';

export default class extends Controller {
    items = [];

    connect() {
        const config = JSON.parse(atob(this.element.dataset.config));

        const options = { slidesToScroll: config.slidesToScroll ?? 1 };

        const emblaNode = this.element;
        const viewportNode = emblaNode.querySelector('.embla__viewport');
        const prevBtnNode = emblaNode.querySelector('.embla__button--prev');
        const nextBtnNode = emblaNode.querySelector('.embla__button--next');
        const dotsNode = emblaNode.querySelector('.embla__dots');

        const emblaApi = EmblaCarousel(viewportNode, options);

        const removePrevNextBtnsClickHandlers = addPrevNextBtnsClickHandlers(
            emblaApi,
            prevBtnNode,
            nextBtnNode
        );
        const removeDotBtnsAndClickHandlers = addDotBtnsAndClickHandlers(
            emblaApi,
            dotsNode
        );

        emblaApi.on('destroy', removePrevNextBtnsClickHandlers);
        emblaApi.on('destroy', removeDotBtnsAndClickHandlers);
    }
}
