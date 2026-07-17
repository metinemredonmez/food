// Scroll reveal: IntersectionObserver + emniyet kemeri (gözlemci aksarsa içerik asla gizli kalmaz)
(function () {
  var revealEls = document.querySelectorAll('[data-reveal]');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('revealed'); io.unobserve(e.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  }
  setTimeout(function () {
    revealEls.forEach(function (el) { el.classList.add('revealed'); });
  }, 2500);
})();
