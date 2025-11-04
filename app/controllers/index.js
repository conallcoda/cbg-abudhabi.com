import { Application } from '@hotwired/stimulus';

import Accordion from './accordion';
import Burger from './burger';
import Carousel from './carousel';
import CookieConsent from './cookie-consent';
import TagFilter from './tag-filter';
import Countdown from './countdown';
import FormStep from './form-step';
import HeaderVideo from './header-video';
import InfiniteScroll from './infinite-scroll';
import Lightbox from './lightbox';
import Nav from './nav';
import Newsletter from './newsletter';
import ReductionCode from './reduction-code';
import Tabs from './tabs';

const application = Application.start();

application.register('accordion', Accordion);
application.register('burger', Burger);
application.register('carousel', Carousel);
application.register('cookie-consent', CookieConsent);
application.register('countdown', Countdown);
application.register('form-step', FormStep);
application.register('header-video', HeaderVideo);
application.register('infinite-scroll', InfiniteScroll);
application.register('lightbox', Lightbox);
application.register('reduction-code', ReductionCode);
application.register('nav', Nav);
application.register('newsletter', Newsletter);
application.register('tabs', Tabs);
application.register('tag-filter', TagFilter);
