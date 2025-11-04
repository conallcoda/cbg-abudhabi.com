export const getViewport = (w) => {
  const width =
    w.innerWidth && w.document.documentElement.clientWidth
      ? Math.min(w.innerWidth, w.document.documentElement.clientWidth)
      : w.innerWidth ||
        w.document.documentElement.clientWidth ||
        w.document.getElementsByTagName("body")[0].clientWidth;
  return {
    h: w.document.documentElement.clientHeight,
    w: width,
  };
};

export const getScrollTop = (w) => {
  return w.scrollY || w.document.documentElement.scrollTop;
};

export const debounce = (fn) => {
  let timeout;
  return function () {
    if (timeout) {
      window.cancelAnimationFrame(timeout);
    }
    timeout = window.requestAnimationFrame(fn);
  };
};

export const toggleActiveState = (items, isActive, classes) => {
  const active = classes.active.length ? classes.active.split(" ") : [];
  const inactive = classes.inactive.length ? classes.inactive.split(" ") : [];
  items.forEach((item, i) => {
    if (active.length) {
      item.classList.remove(...active);
    }
    if (inactive.length) {
      item.classList.remove(...inactive);
    }
    if (isActive(item, i)) {
      if (active.length) {
        item.classList.add(...active);
      }
    } else {
      if (inactive.length) {
        item.classList.add(...inactive);
      }
    }
  });
};
